<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Models\VerificationCode;
use App\Mail\VerificationMail;

class SendVerificationCodeAction
{
    public static function execute(): void
    {
        $user = auth()->user();
//        Delete existing one if there is
        VerificationCode::where('user_id', $user->id)->delete();

//        Create new code
        $verificationCode = VerificationCode::create([
            'user_id' => $user->id,
            'code' => rand(100000, 999999),
        ]);

        Log::info('Verification code regenerated', [
            'user_id' => $user->id,
        ]);

//        Send verification code
        $emailData = [
            'name' => firstName($user->name),
            'code' => $verificationCode->code,
        ];

        Mail::to($user->email)->send(new VerificationMail($emailData));
    }
}
