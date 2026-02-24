<?php

namespace App\Actions\Brand;

use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Brand;
use App\DTOs\Brand\BrandSettingsDTO;
use App\Enums\Status;

class BrandSettingsAction
{
    public static function execute(BrandSettingsDTO $dto): User
    {
        $user = auth()->user();
        if (!$user) {
            throw new \Exception('User not found.');
        }

        $brand = Brand::where('user_id', $user->id)->first();
        if(!$brand) {
            throw new \Exception('Brand not found.');
        }

        $brand->update([
            'brand_name' => $dto->brandName,
            'category' => $dto->selectedCategory,
            'sub_category' => $dto->selectedSubcategory,
            'brand_type' => $dto->type,
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
            'onboarding_step' => Status::COMPLETED
        ]);

        return $user;
    }
}
