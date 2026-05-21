<?php

namespace App\Actions\Brand;

use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Brand;
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
    public static function execute(string $plan, int $month): Brand
    {
        $user = auth()->user();

        if (! $user || $user->role != UserType::BRAND) {
            throw new Exception('User not found.');
        }

        try {
            DB::beginTransaction();

            $brand = Brand::where('id', auth()->user()->brand->id)->first();

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
                $amount = resolvePricing($brand->subscription_status, $plan, $month);
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

    public static function renew(int $month): Brand
    {
        $user = auth()->user();

        if (! $user || $user->role != UserType::BRAND) {
            throw new Exception('User not found.');
        }

        try {
            DB::beginTransaction();

            $brand = Brand::where('id', auth()->user()->brand->id)->first();

            if (! $brand) {
                throw new Exception('Brand not found. Please contact support');
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
}
