<?php

use App\Models\Coupon;
use App\Models\DropshipperStore;
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
}
