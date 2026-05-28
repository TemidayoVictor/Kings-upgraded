<?php

namespace App\Actions\Brand;

use App\DTOs\GeneralDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Revenue;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class SubscriptionStatusAction
{
    /**
     * @throws Throwable
     */
    public static function execute(GeneralDTO $dto): Brand
    {
        $user = auth()->user();
        $plan = $dto->value['plan'];
        $month = $dto->value['month'];

        if (isset($dto->value['brandId'])) {
            // request is from admin
            if (! $user || $user->role != UserType::ADMIN) {
                throw new Exception('User not found.');
            }
            $brand = Brand::findOrFail($dto->value['brandId']);
        } else {
            // request is from user
            if (! $user || $user->role != UserType::BRAND) {
                throw new Exception('User not found.');
            }
            $brand = $user->brand;
        }

        try {
            DB::beginTransaction();

            if ($brand->subscription_status == $plan) {
                throw new Exception('You are already subscribed to this plan.');
            }

            $planDetails = planDetails($plan);
            $currentExpiry = $brand->exp_date;

            // If subscription is still active, extend from current expiry
            if ($currentExpiry && Carbon::parse($currentExpiry)->isFuture()) {
                $newExpiry = Carbon::parse($currentExpiry)->addMonth($month);
            } else {
                // If expired or null, start from now
                $newExpiry = now()->addMonth($month);
            }

            if (expiryDate($brand->exp_date)['daysRemaining'] < 1) {
                $amount = $planDetails['fee'] * $month;
            } else {
                $amount = resolvePricing($brand->subscription_status, $plan, $month, $brand->id);
            }

            $brand->update([
                'subscription_amount' => $planDetails['fee'],
                'no_of_products' => $planDetails['number'],
                'subscription_status' => $plan,
                'exp_date' => $newExpiry,
            ]);

            // Add Revenue
            Revenue::create([
                'user_id' => $user->id,
                'brand_id' => $brand->id,
                'amount' => $amount,
                'description' => Status::UPGRADE,
                'subscription_status' => $plan,
            ]);

            DB::commit();

            return $brand;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    /**
     * @throws Throwable
     */
    public static function renew(int $month, ?int $brandId = null): Brand
    {
        $user = auth()->user();
        if ($brandId) {
            // request is from admin
            if (! $user || $user->role != UserType::ADMIN) {
                throw new Exception('User not found.');
            }
            $brand = Brand::where('id', $brandId)->first();
        } else {
            if (! $user || $user->role != UserType::BRAND) {
                throw new Exception('User not found.');
            }
            $brand = $user->brand;
        }

        try {
            DB::beginTransaction();

            if (! $brand) {
                throw new Exception('Brand not found. Please try again');
            }

            $currentExpiry = $brand->exp_date;

            // If subscription is still active, extend from current expiry
            if ($currentExpiry && Carbon::parse($currentExpiry)->isFuture()) {
                $newExpiry = Carbon::parse($currentExpiry)->addMonth($month);
            } else {
                // If expired or null, start from now
                $newExpiry = now()->addMonth($month);
            }

            $brand->update([
                'exp_date' => $newExpiry,
            ]);

            // Add Revenue
            Revenue::create([
                'user_id' => $user->id,
                'brand_id' => $brand->id,
                'amount' => $brand->subscription_amount * $month,
                'description' => Status::RENEWAL,
                'subscription_status' => $brand->subscription_status,
            ]);

            DB::commit();

            return $brand;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    /**
     * @throws Throwable
     */
    public static function downgrade(GeneralDTO $dto): Brand
    {
        $plan = $dto->value['plan'];
        if (! $plan) {
            throw new Exception('Invalid Request');
        }

        $user = auth()->user();

        if (! $user || $user->role != UserType::ADMIN) {
            throw new Exception('You are not allowed to authorized to perform this action.');
        }

        try {
            DB::beginTransaction();

            $brand = Brand::where('id', $dto->id)->first();

            if (! $brand) {
                throw new Exception('Brand not found. Please try again.');
            }

            $planDetails = planDetails($plan);
            $subscriptionAmount = $planDetails['fee'];
            $productNumber = $planDetails['number'];

            $products = Product::where('brand_id', $dto->id)->get();

            // Only leave the number of products for that plan active, and deactivate others
            $products->take($productNumber)->each->update(['status' => Status::ACTIVE]);
            $products->skip($productNumber)->each->update(['status' => Status::INACTIVE]);

            // Update brand with new status
            $brand->update([
                'subscription_amount' => $subscriptionAmount,
                'no_of_products' => $productNumber,
                'subscription_status' => $plan,
                'exp_date' => now(),
            ]);

            DB::commit();

            return $brand;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Error: '.$e->getMessage());
        }
    }
}
