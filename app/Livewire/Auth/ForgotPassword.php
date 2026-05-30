<?php

namespace App\Livewire\Auth;

use App\Traits\Toastable;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Livewire\Component;

class ForgotPassword extends Component
{
    use Toastable;

    public string $email;

    protected $rules = [
        'email' => 'required|email',
    ];

    public function sendResetLink(): void
    {
        $this->validate();

        // Sends the standard Laravel password reset email using core services
        $status = Password::broker()->sendResetLink(
            ['email' => $this->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->toast('success', 'We have sent a password reset link to your email.');
            $this->reset('email');
        } elseif ($status === Password::INVALID_USER) {
            $this->toast('error', 'Invalid user.');
        } else {
            $this->toast('error', 'We could not send a reset link to this email address.');
        }
    }

    public function render(): View
    {
        return view('livewire.auth.forgot-password')
            ->layout('layouts.app')
            ->title('Forgot Password');
    }
}
