<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\DTOs\Auth\SignupDTO;
use App\Actions\Auth\SignupAction;
use Illuminate\Support\Facades\Auth;

class Signup extends Component
{
    public string $email = '';
    public string $password = '';
    public string $name = '';
    public string $password_confirmation = '';
    protected array $rules = [
        'email' => 'required|email|unique:users,email',
        'name' => 'required|string|max:255',
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

    public function submit() {
        $validated = $this->validate();
        $dto = SignupDTO::fromArray($validated);

        try {
//          Create User
            $user = SignupAction::execute($dto);

//          Send success toast if successful. Using session to retain toast when redirect happens
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Verification mail sent',
                'title' => 'Success',
                'duration' => 5000,
            ]);

//          redirect to email verification page
            return redirect()->route('verify-email');

        } catch (\Exception $e) {
//          Send error toast if error occurs
            session()->flash('toast', [
                'type' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Something went wrong!',
                'duration' => 5000,
            ]);

            return back();
        }
    }

    public function render()
    {
        return view('livewire.auth.signup')
            ->layout('layouts.app')
            ->title('Signup');
    }
}
