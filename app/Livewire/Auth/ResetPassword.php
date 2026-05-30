<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class ResetPassword extends Component
{
    public string $token;

    public string $email;

    public string $password;

    public string $password_confirmation;

    protected $rules = [
        'token' => 'required',
        'email' => 'required|email',
        'password' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/[a-z]/',  // At least one lowercase letter
            'regex:/[A-Z]/',  // At least one uppercase letter
            'regex:/[0-9]/',   // At least one number
            'regex:/[@$!%*#?&]/',  ], // At least one special character
    ];

    protected $messages = [
        'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
    ];

    public function mount($token): void
    {
        $this->token = $token;
        // Automatically prefill the email if it is passed safely in the URL string parameters
        $this->email = request()->query('email');
    }

    public function resetPassword()
    {
        $this->validate();

        // Validates the secure token and matches it with the database record
        $status = Password::broker()->reset(
            [
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ],
            function ($user, $password) {
                // Updates the user entry securely
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', 'Your password has been changed successfully.');

            return redirect()->route('login');
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render(): View
    {
        return view('livewire.auth.reset-password')
            ->layout('layouts.app')
            ->title('Reset Password');
    }
}
