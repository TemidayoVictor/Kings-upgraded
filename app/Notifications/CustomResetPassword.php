<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // This tells Laravel to render the HTML file we are creating below
        return (new MailMessage)
            ->subject('KINGS: Reset Password')
            ->view('emails.auth.password-reset', [
                'url' => $resetUrl,
                'name' => $notifiable->name ?? 'there',
            ]);
    }
}
