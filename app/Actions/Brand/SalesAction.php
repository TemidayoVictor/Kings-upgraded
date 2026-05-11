<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\SalesDTO;
use App\DTOs\GeneralDTO;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class SalesAction
{
    /**
     * @throws Exception
     * @throws Throwable
     */
    public static function execute(SalesDTO $dto): Sale
    {
        $user = auth()->user();
        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = Brand::where('user_id', $user->id)->first();
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        self::validateTime($dto->startsAt, $dto->endsAt);

        DB::beginTransaction();
        try {
            $sale = Sale::updateOrCreate(
                [
                    'brand_id' => auth()->user()->brand->id,
                    'id' => $dto->id,
                ],
                [
                    'name' => $dto->name,
                    'description' => $dto->description,
                    'sale_mode' => $dto->saleMode,
                    'discount_type' => $dto->discountType,
                    'discount_value' => $dto->discountValue,
                    'starts_at' => $dto->startsAt,
                    'section_id' => (int) $dto->section,
                    'ends_at' => $dto->endsAt,
                    'is_active' => true,
                ]);
            DB::commit();

            return $sale;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to create sale: {$e->getMessage()}");
        }
    }

    /**
     * @throws Exception
     */
    public static function toggle(GeneralDTO $dto): Sale
    {
        $user = auth()->user();
        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = Brand::where('user_id', $user->id)->first();
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        $sale = Sale::where('id', $dto->id)->first();
        if (! $sale) {
            throw new Exception('Sale not found.');
        }

        if ($sale->is_active) {
            $sale->update([
                'is_active' => false,
                'ongoing' => false,
            ]);
        } else {
            self::validateTime($sale->starts_at, $sale->ends_at);

            $sale->update([
                'is_active' => true,
            ]);
        }

        return $sale;

    }

    /**
     * @throws Throwable
     */
    public static function startSale(GeneralDTO $dto): void
    {
        $sale = Sale::where('id', $dto->id)->first();
        if (! $sale) {
            throw new Exception('Sale not found.');
        }

        if (! $sale->is_active) {
            // Check time validation of sale, if it has been inactivated before.
            // this is so that in the event that the sale has been run already, user
            // needs to set new start and end date to restart the same sale
            self::validateTime($sale->starts_at, $sale->ends_at);
        }

        // Check for any active sales at the moment
        $ongoingSale = Sale::where('brand_id', $sale->brand_id)
            ->where('section_id', $sale->section_id)
            ->where('ongoing', true)
            ->first();

        if ($ongoingSale) {
            throw new Exception('You have already started a sale "'.$ongoingSale->name.'". Kindly end it, to start a new one');
        }

        $sectionId = $sale->section_id;
        if ($sectionId == 0) {
            // Get all products for this brand
            $products = Product::where('brand_id', $sale->brand_id)->get();
        } else {
            // Get all products for this brand for that section
            $products = Product::where('brand_id', $sale->brand_id)
                ->where('section_id', $sectionId)
                ->get();
        }

        DB::beginTransaction();
        try {
            foreach ($products as $product) {
                $salePrice = $product->price;

                if ($sale->discount_type === 'percentage') {
                    $salePrice = $product->price * (1 - ($sale->discount_value / 100));
                } elseif ($sale->discount_type === 'fixed') {
                    $salePrice = max(0, $product->price - $sale->discount_value);
                }

                $product->update([
                    'sale_status' => true,
                    'sales_price' => round($salePrice, 2),
                    'sale_id' => $sale->id,
                ]);
            }

            $sale->update([
                'starts_at' => Carbon::now(),
                'is_active' => true,
                'ongoing' => true,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to start sale: {$e->getMessage()}");
        }
    }

    /**
     * @throws Throwable
     */
    public static function endSale(GeneralDTO $dto): void
    {
        $sale = Sale::where('id', $dto->id)->first();
        if (! $sale) {
            throw new Exception('Sale not found.');
        }

        $sectionId = $sale->section_id;
        if ($sectionId == 0) {
            // Get all products for this brand
            $products = Product::where('brand_id', $sale->brand_id)->get();
        } else {
            // Get all products for this brand for that section
            $products = Product::where('brand_id', $sale->brand_id)
                ->where('section_id', $sectionId)
                ->get();
        }

        DB::beginTransaction();
        try {
            foreach ($products as $product) {
                $salePrice = $product->price;
                $product->update([
                    'sale_status' => false,
                    'sales_price' => round($salePrice, 2),
                    'sale_id' => null,
                ]);
            }

            $sale->update([
                'is_active' => false,
                'ongoing' => false,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to end sale: {$e->getMessage()}");
        }
    }

    private static function validateTime($startDate, $endDate): void
    {
        $now = Carbon::now();
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        if ($startDate->lt($now)) {
            throw new Exception('Start date cannot be in the past. Please select a future date.');
        }

        // Check if end date is before start date
        if ($endDate->lte($startDate)) {
            throw new Exception('End date must be after the start date.');
        }

        // Check if end date is too far in the future (optional - 1 year max)
        $maxEndDate = $now->copy()->addYear();
        if ($endDate->gt($maxEndDate)) {
            throw new Exception('Sale end date cannot be more than 1 year from now.');
        }

        // Check minimum duration (optional - at least 1 hour)
        $minDuration = $startDate->copy()->addHour();
        if ($endDate->lt($minDuration)) {
            throw new Exception('Sale must last at least 1 hour.');
        }

        $existingSale = Sale::where('brand_id', auth()->user()->brand->id)
            ->where('is_active', true)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('starts_at', [$startDate, $endDate])
                    ->orWhereBetween('ends_at', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('starts_at', '<=', $startDate)
                            ->where('ends_at', '>=', $endDate);
                    });
            })->exists();

        if ($existingSale) {
            throw new Exception('You already have a sale scheduled during this time period.');
        }
    }
}
