<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\CouponDTO;
use App\DTOs\GeneralDTO;
use App\Enums\UserType;
use App\Models\Coupon;
use Exception;

class CouponAction
{
    /**
     * @throws Exception
     */
    public static function execute(CouponDTO $dto): Coupon
    {
        $user = auth()->user();
        if (! $user || ($user->role != UserType::BRAND)) {
            throw new Exception('User not found.');
        }

        $brandId = auth()->user()->brand->id;
        $check = isCodeUniqueForBrand($dto->code, $brandId);

        if (! $check) {
            throw new Exception('Coupon code already exists');
        }

        $checkDates = validateDateRange($dto->startsAt, $dto->expiresAt);
        if (! $checkDates['valid']) {
            $error = $checkDates['errors'];
            throw new Exception($error[0]);
        }

        return Coupon::create([
            'brand_id' => $brandId,
            'code' => strtoupper($dto->code),
            'type' => $dto->type,
            'value' => $dto->value,
            'starts_at' => $dto->startsAt,
            'expires_at' => $dto->expiresAt,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function update(CouponDTO $dto): Coupon
    {
        $user = auth()->user();
        if (! $user || ($user->role != UserType::BRAND)) {
            throw new Exception('User not found.');
        }

        $brandId = auth()->user()->brand->id;
        $check = isCodeUniqueForBrand($dto->code, $brandId, $dto->id);

        if (! $check) {
            throw new Exception('Coupon code already exists');
        }

        $checkDates = validateDateRange($dto->startsAt, $dto->expiresAt);
        if (! $checkDates['valid']) {
            $error = $checkDates['errors'];
            throw new Exception($error[0]);
        }

        $coupon = Coupon::where('id', $dto->id)->first();
        if (! $coupon) {
            throw new Exception('Coupon not found.');
        }

        $coupon->update([
            'code' => strtoupper($dto->code),
            'type' => $dto->type,
            'value' => $dto->value,
            'starts_at' => $dto->startsAt,
            'expires_at' => $dto->expiresAt,
            'is_active' => true,
        ]);

        return $coupon;
    }

    /**
     * @throws Exception
     */
    public static function deactivate(GeneralDTO $dto): Coupon
    {
        $user = auth()->user();
        if (! $user || ($user->role != UserType::BRAND)) {
            throw new Exception('User not found.');
        }

        $coupon = Coupon::where('id', $dto->id)->first();
        if (! $coupon) {
            throw new Exception('Coupon not found.');
        }

        $coupon->update([
            'is_active' => false,
        ]);

        return $coupon;
    }
}
