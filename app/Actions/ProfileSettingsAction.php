<?php

namespace App\Actions;

use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\DTOs\ProfileSettingsDTO;

class ProfileSettingsAction
{
    public static function execute(ProfileSettingsDTO $dto): User
    {
        $user = auth()->user();

        if (!$user) {
            throw new \Exception('User not found.');
        }

        $user->update([
           'name' => $dto->name,
           'phone' => $dto->phone,
        ]);

        return $user;
    }
}
