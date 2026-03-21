<?php

namespace App\Actions;

use App\DTOs\ProfileSettingsDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\User;
use Exception;

class ProfileSettingsAction
{
    /**
     * @throws Exception
     */
    public static function execute(ProfileSettingsDTO $dto): User
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        if ($user->role == UserType::BRAND && $user->onboarding_step != Status::COMPLETED) {
            $user->update([
                'name' => $dto->name,
                'phone' => $dto->phone,
                'onboarding_step' => 'brand-setup',
            ]);
        } elseif ($user->role == UserType::DROPSHIPPER && $user->onboarding_step != Status::COMPLETED) {
            $user->update([
                'name' => $dto->name,
                'phone' => $dto->phone,
                'onboarding_step' => 'dropshipper-setup',
            ]);
        } else {
            $user->update([
                'name' => $dto->name,
                'phone' => $dto->phone,
                'onboarding_step' => Status::COMPLETED,
            ]);
        }

        return $user;
    }
}
