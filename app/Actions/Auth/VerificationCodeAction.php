<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\VerificationCodeDTO;
use App\Models\User;
use App\Models\VerificationCode;

class VerificationCodeAction
{
    public static function execute(VerificationCodeDTO $dto): bool
    {
        $user = auth()->user();
        $verification = VerificationCode::where('code', $dto->code)
            ->where('user_id', $user->id)
            ->first();

        if (! $verification) {
            throw new \Exception('Invalid verification code.');
        }

        $user = User::findOrFail($user->id);
        $user->update([
            'email_verified_at' => now(),
            'onboarding_step' => 'role_selection',
        ]);

        $verification->delete();

        return true;
    }
}
