<?php

namespace App\Actions\Brand;

use App\DTOs\GeneralDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Brand;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Revenue;
use App\Services\FlutterwavePaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class SubscriptionStatusAction
{
    /**
     * @throws Throwable
     */
    public static function execute(GeneralDTO $dto): Payment
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

            // prepare payment
            $txRef = Str::uuid();
            $userId = auth()->user()->id;

            $payload = [
                'brand_id' => $brand->id,
                'subscription_amount' => $planDetails['fee'],
                'no_of_products' => $planDetails['number'],
                'subscription_status' => $plan,
                'expiry_date' => $newExpiry,
                'description' => Status::UPGRADE,
            ];

            $payment = Payment::updateOrCreate(
                [
                    'user_id' => $userId,
                    'status' => Status::PENDING,
                ],
                [
                    'transaction_ref' => $txRef,
                    'amount' => $amount,
                    'currency' => 'NGN',
                    'status' => Status::PENDING,
                    'action' => 'upgrade_subscription',
                    'payload' => $payload,
                ]
            );

            DB::commit();

            return $payment;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    /**
     * @throws Throwable
     */
    public static function renew(int $month, ?int $brandId = null): Payment
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

            // prepare payment
            $txRef = Str::uuid();
            $amount = $brand->subscription_amount * $month;
            $userId = auth()->user()->id;

            $payload = [
                'expiry_date' => $newExpiry,
                'brand_id' => $brand->id,
                'description' => Status::RENEWAL,
                'subscription_status' => $brand->subscription_status,
            ];

            $payment = Payment::updateOrCreate(
                [
                    'user_id' => $userId,
                    'status' => Status::PENDING,
                ],
                [
                    'transaction_ref' => $txRef,
                    'amount' => $amount,
                    'currency' => 'NGN',
                    'status' => Status::PENDING,
                    'action' => 'renew_subscription',
                    'payload' => $payload,
                ]
            );

            DB::commit();

            return $payment;

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

    public function makePayment(FlutterwavePaymentService $flutterwave, array $payload): void
    {
        $txRef = Str::uuid();
        $amount = $payload['amount'];
        // save payment
        Payment::create([
            'user_id' => auth()->user()->id,
            'transaction_ref' => $txRef,
            'amount' => $amount,
            'currency' => $payload['currency'] ?? 'NGN',
            'status' => 'pending',
            'action' => $payload['action'],
            'payload' => $payload,
        ]);

        $this->dispatch(
            'flutterwave-payment',
            $flutterwave->checkoutData(
                amount: $amount,
                txRef: $txRef,
                customer: [
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->phone,
                    'name' => auth()->user()->name,
                ],
                description: 'payment',
                meta: [
                    'plan_id' => 'basic',
                ]
            )
        );
    }
}
