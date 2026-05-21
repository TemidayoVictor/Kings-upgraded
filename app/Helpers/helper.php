<?php

use App\Enums\Status;
use App\Models\Coupon;
use App\Models\DropshipperStore;
use App\Models\GeneralSetting;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;

if (! function_exists('firstName')) {
    function firstName(?string $fullName): string
    {
        if (empty($fullName)) {
            return '';
        }

        return explode(' ', trim($fullName))[0];
    }
}

if (! function_exists('lastName')) {
    function lastName(?string $fullName): ?string
    {
        if (empty($fullName)) {
            return null;
        }

        $parts = explode(' ', trim($fullName));

        return count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : null;
    }
}

if (! function_exists('isCodeUniqueForBrand')) {
    function isCodeUniqueForBrand(string $code, int $brandId, int $editId = 0): bool
    {
        if ($editId == 0) {
            return ! Coupon::where('brand_id', $brandId)
                ->where('code', $code)
                ->exists();
        } else {
            return ! Coupon::where('brand_id', $brandId)
                ->where('code', $code)
                ->where('id', '!=', $editId)
                ->exists();
        }
    }
}

if (! function_exists('validateDateRange')) {
    function validateDateRange($start, $end): array
    {
        $errors = [];

        $startDate = $start ? Carbon::parse($start)->startOfDay() : null;
        $endDate = $end ? Carbon::parse($end)->endOfDay() : null;

        // Compare with today's start (not current time)
        $today = now()->startOfDay();

        // Rule 1: Start date should not be in the past
        if ($startDate && $startDate->lt($today)) {
            $errors[] = 'Start date cannot be in the past';
        }

        // Rule 2: End date should not be before start date
        if ($startDate && $endDate && $endDate->lt($startDate)) {
            $errors[] = 'End date cannot be before start date';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    if (! function_exists('generateStoreSlug')) {
        function generateStoreSlug($storeName): array
        {
            $storeSlug = Str::slug($storeName);
            // Check if slug exists
            $exists = DropshipperStore::where('slug', $storeSlug)->exists();

            return [
                'storeSlug' => $storeSlug,
                'exists' => $exists,
            ];
        }
    }

    if (! function_exists('generalSetting')) {
        function generalSetting(): ?GeneralSetting
        {
            return GeneralSetting::first();
        }
    }

    if (! function_exists('maxImages')) {
        function maxImages(): ?int
        {
            $subscription_status = auth()->user()->brand->subscription_status;
            if ($subscription_status == Status::BASIC) {
                return generalSetting()->basic_images_number;
            } elseif ($subscription_status == Status::PREMIUM) {
                return generalSetting()->premium_images_number;
            } elseif ($subscription_status == Status::PLATINUM) {
                return generalSetting()->platinum_images_number;
            }

            return 0;
        }
    }

    if (! function_exists('canAddProduct')) {
        function canAddProduct($brand): ?bool
        {
            $allowed_number_of_products = $brand->no_of_products;
            $products = Product::where('brand_id', $brand->id)->count();

            if ($allowed_number_of_products >= $products) {
                return true;
            } else {
                return false;
            }
        }
    }

    if (! function_exists('planDetails')) {
        function planDetails($subscription_status): ?array
        {
            if ($subscription_status == Status::BASIC) {
                return [
                    'fee' => generalSetting()->basic_fee,
                    'number' => generalSetting()->basic_products_number,
                    'additional_fee' => generalSetting()->basic_additional_products_fee,
                    'additional_number' => generalSetting()->basic_additional_products_number,
                ];
            } elseif ($subscription_status == Status::PREMIUM) {
                return [
                    'fee' => generalSetting()->premium_fee,
                    'number' => generalSetting()->premium_products_number,
                    'additional_fee' => generalSetting()->premium_additional_products_fee,
                    'additional_number' => generalSetting()->premium_additional_products_number,
                ];
            } elseif ($subscription_status == Status::PLATINUM) {
                return [
                    'fee' => generalSetting()->platinum_fee,
                    'number' => generalSetting()->platinum_products_number,
                    'additional_fee' => generalSetting()->platinum_additional_products_fee,
                    'additional_number' => generalSetting()->platinum_additional_products_number,
                ];
            }

            return [];
        }
    }

    if (! function_exists('expiryDate')) {
        function expiryDate($expDate): ?array
        {
            $expiryDate = Carbon::parse($expDate);
            $now = Carbon::now();

            return [
                'daysRemaining' => (int) $now->diffInDays($expiryDate, false),
                'isExpired' => $now->greaterThan($expiryDate),
            ];
        }
    }

    if (! function_exists('resolvePricing')) {
        function resolvePricing($currentPlan, $newPlan, $month = 0): ?int
        {
            if ($currentPlan == $newPlan) {
                return 0;
            }

            $brand = auth()->user()->brand;
            $expDate = expiryDate($brand->exp_date);
            $daysRemaining = $expDate['daysRemaining'];
            $currentRemainingValue = 0;
            $newValue = 0;
            $newPlanPrice = 0;

            if ($daysRemaining > 1) {
                // get current value of remaining days
                $currentPlanPrice = planDetails($currentPlan)['fee'];
                $currentRemainingValue = ($currentPlanPrice / 30) * $daysRemaining;

                $newPlanPrice = planDetails($newPlan)['fee'];
                $newValue = ($newPlanPrice / 30) * $daysRemaining;
            }

            if ($month == 0) {
                return $newValue - $currentRemainingValue;
            } else {
                return ($newValue - $currentRemainingValue) + ($newPlanPrice * $month);
            }

        }
    }
}
