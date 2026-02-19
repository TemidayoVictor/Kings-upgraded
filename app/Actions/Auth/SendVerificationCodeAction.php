<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Models\VerificationCode;
use App\Mail\VerificationMail;
use App\DTOs\Auth\SendVerificationCodeDTO;

class SendVerificationCodeAction
{
    public static function execute(SendVerificationCodeDTO $dto): void
    {
//        Delete existing one if there is
        VerificationCode::where('user_id', $dto->id)->delete();

//        Create new code
        $verificationCode = VerificationCode::create([
            'user_id' => $dto->id,
            'code' => rand(100000, 999999),
        ]);

        Log::info('Verification code generated', [
            'user_id' => $dto->id,
        ]);

//        Send verification code
        $emailData = [
            'name' => firstName($dto->name),
            'code' => $verificationCode->code,
        ];

        Mail::to($dto->email)->send(new VerificationMail($emailData));
    }
}
