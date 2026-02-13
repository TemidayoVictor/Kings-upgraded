<?php
namespace App\Actions\Auth;

use App\DTOs\Auth\VerificationCodeDTO;
use App\Models\User;
use App\Models\VerificationCode;

class VerificationCodeAction
{
    public static function execute(VerificationCodeDTO $dto): bool
    {
        $verification = VerificationCode::where('code', $dto->code)
            ->where('user_id', $dto->userId)
            ->first();

        $user = User::findOrFail($dto->userId);
        $user->update([
            'email_verified_at' => now(),
            'onboarding_step' => 'email_verified',
        ]);

        if (!$verification) {
            throw new \Exception('Invalid verification code.');
        }

        $verification->delete();

        return true;
    }
}
