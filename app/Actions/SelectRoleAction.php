<?php

namespace App\Actions;

use App\DTOs\GeneralDTO;
use App\DTOs\SelectRoleDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Brand;
use App\Models\User;
use Carbon\Carbon;
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
            // Create brand
            $brand = Brand::create([
                'uuid' => rand(100000, 999999),
                'status' => Status::UNLISTED,
                'subscription_status' => Status::PREMIUM,
                'no_of_products' => generalSetting()->premium_products_number,
                'subscription_amount' => generalSetting()->premium_fee,
                'exp_date' => Carbon::now()->addMonth(),
            ]);
            $user->update([
                'current_brand_id' => $brand->id,
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
    public static function addBrand(GeneralDTO $dto): User
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $role = $user->role;

        if ($role === UserType::BRAND && $dto->value['plan'] == Status::BASIC) {
            throw new Exception('You need to subscribe to a paid plan to add multiple brands.');
        }

        $planDetails = planDetails($dto->value['plan']);
        $no_of_products = $planDetails['number'];
        $subscription_amount = $planDetails['fee'];

        // Create a brand table
        $brand = Brand::create([
            'user_id' => $user->id,
            'uuid' => rand(100000, 999999),
            'status' => Status::UNLISTED,
            'subscription_status' => $dto->value['plan'],
            'no_of_products' => $no_of_products,
            'subscription_amount' => $subscription_amount,
            'exp_date' => Carbon::now()->addMonth($dto->value['month']),
        ]);
        $user->update([
            'current_brand_id' => $brand->id,
            'role' => UserType::BRAND, // for times when clients or non brand owners add accounts
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
