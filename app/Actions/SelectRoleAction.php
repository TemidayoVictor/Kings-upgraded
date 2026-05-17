<?php

namespace App\Actions;

use App\DTOs\SelectRoleDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Brand;
use App\Models\User;
use Exception;

class SelectRoleAction
{
    /**
     * @throws Exception
     */
    public static function execute(SelectRoleDTO $dto): User
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $role = $dto->role;

        if ($user->role) {
            throw new Exception('You already have a role');
        }

        $user->update([
            'role' => $role,
            'onboarding_step' => 'profile_setup',
        ]);

        //        Create role table
        if ($role === UserType::BRAND) {
            // Create a brand table
            $user->brand()->create([
                'uuid' => rand(100000, 999999),
                'status' => Status::UNLISTED,
            ]);
            $user->update([
                'current_brand_id' => $user->brand()->id,
            ]);
        } elseif ($role === UserType::DROPSHIPPER) {
            // Create a dropshipper table
            $user->dropshipper()->create([
                'status' => Status::UNLISTED,
            ]);
        }

        return $user;
    }

    /**
     * @throws Exception
     */
    public static function addBrand(string $plan): User
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $role = $user->role;

        if ($role === UserType::BRAND && $plan == Status::BASIC) {
            throw new Exception('You need to subscribe to a paid plan to add multiple brands.');
        }

        // Create a brand table
        $brand = Brand::create([
            'user_id' => $user->id,
            'uuid' => rand(100000, 999999),
            'status' => Status::UNLISTED,
            'subscription_status' => $plan,
        ]);
        $user->update([
            'current_brand_id' => $brand->id,
        ]);

        return $user;
    }

    /**
     * @throws Exception
     */
    public static function switchAccounts(int $brandId): User
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = Brand::findOrFail($brandId);

        if ($brand->user_id !== $user->id) {
            throw new Exception('You do not have access to this brand.');
        }

        $user->update([
            'current_brand_id' => $brand->id,
        ]);

        return $user;
    }
}
