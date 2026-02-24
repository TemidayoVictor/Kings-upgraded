<?php

namespace App\Actions;

use App\Enums\UserType;
use App\Enums\Status;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\DTOs\SelectRoleDTO;

class SelectRoleAction
{
    public static function execute(SelectRoleDTO $dto): User
    {
        $user = auth()->user();

        if (!$user) {
            throw new \Exception('User not found.');
        }

        $role = $dto->role;

        $user->update([
            'role' => $role,
            'onboarding_step' => 'profile_setup'
        ]);

//        Create role table
        if($role === UserType::BRAND) {
//            Create a brand table
            $user->brand()->create([
                'uuid' => rand(100000, 999999),
                'status' => Status::UNLISTED,
            ]);
        }
        elseif ($role === UserType::DROPSHIPPER) {
//            Create a dropshipper table
            $user->dropshipper()->create([
                'status' => Status::UNLISTED,
            ]);
        }

        return $user;
    }
}
