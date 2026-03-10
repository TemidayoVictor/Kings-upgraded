<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\BrandSettingsDTO;
use App\Enums\Status;
use App\Models\Brand;
use App\Models\User;
use Exception;

class BrandSettingsAction
{
    /**
     * @throws Exception
     */
    public static function execute(BrandSettingsDTO $dto): User
    {
        $user = auth()->user();
        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = Brand::where('user_id', $user->id)->first();
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        // Check if slug already exists for another user
        $check = Brand::where('slug', $dto->slug)->first();
        if ($check && $check->id != $brand->id) {
            throw new Exception('Please use another slug.');
        }

        $brand->update([
            'brand_name' => $dto->brandName,
            'category' => $dto->selectedCategory,
            'sub_category' => $dto->selectedSubcategory,
            'brand_type' => $dto->type,
            'slug' => $dto->slug,
            'description' => $dto->description,
            'position' => $dto->position,
            'state' => $dto->selectedState,
            'city' => $dto->selectedLocalGovernment,
            'address' => $dto->address,
            'account_name' => $dto->accountName,
            'account_number' => $dto->accountNumber,
            'bank_name' => $dto->bankName,
            'subscription_status' => Status::PREMIUM,
            'status' => Status::COMPLETED,
        ]);

        $user->update([
            'onboarding_step' => Status::COMPLETED,
        ]);

        return $user;
    }
}
