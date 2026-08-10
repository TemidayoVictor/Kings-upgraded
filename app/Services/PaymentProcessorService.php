<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Brand;
use App\Models\Dropshipper;
use App\Models\DropshipperApplication;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Revenue;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentProcessorService
{
    public function handle(Payment $payment): array
    {
        return match ($payment->action) {
            'upgrade_subscription' => $this->upgradePlan($payment),
            'renew_subscription' => $this->renewSubscription($payment),
            'increase_products' => $this->increaseProducts($payment),
            'add_dropshipper' => $this->addDropshipper($payment),
            'dropshipper_monthly_subscription' => $this->dropShipperMonthlySubscription($payment),
            'dropshipper_commission' => $this->dropshipperCommission($payment),
            default => throw new \Exception("Unknown payment action: {$payment->action}"),
        };
    }

    public function renewSubscription(Payment $payment): array
    {
        try {
            DB::beginTransaction();

            $brandId = $payment->payload['brand_id'];

            Brand::where('id', $brandId)->update([
                'exp_date' => $payment->payload['expiry_date'],
            ]);

            Revenue::create([
                'user_id' => $payment->user_id,
                'brand_id' => $brandId,
                'payment_id' => $payment->id,
                'amount' => $payment->amount,
                'description' => $payment->payload['description'],
                'subscription_status' => $payment->payload['subscription_status'],
            ]);

            DB::commit();

            return [
                'route' => 'brand-subscription-status',
                'status' => 'success',
                'message' => 'Subscription renewed successfully.',
            ];
        } catch (\Throwable $e) {
            DB::rollBack();

            return [
                'route' => 'brand-subscription-status',
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function upgradePlan(Payment $payment): array
    {
        try {
            DB::beginTransaction();
            $brandId = $payment->payload['brand_id'];

            Brand::where('id', $brandId)->update([
                'subscription_amount' => $payment->payload['subscription_amount'],
                'no_of_products' => $payment->payload['no_of_products'],
                'subscription_status' => $payment->payload['subscription_status'],
                'exp_date' => $payment->payload['expiry_date'],
            ]);

            // Add Revenue
            Revenue::create([
                'user_id' => $payment->user_id,
                'brand_id' => $brandId,
                'payment_id' => $payment->id,
                'amount' => $payment->amount,
                'description' => $payment->payload['description'],
                'subscription_status' => $payment->payload['subscription_status'],
            ]);

            DB::commit();

            return [
                'route' => 'brand-subscription-status',
                'status' => 'success',
                'message' => 'Subscription upgraded successfully.',
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            return [
                'route' => 'brand-subscription-status',
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function increaseProducts(Payment $payment): array
    {
        try {
            DB::beginTransaction();
            $brandId = $payment->payload['brand_id'];

            Brand::where('id', $brandId)->update([
                'subscription_amount' => $payment->payload['subscription_amount'],
                'no_of_products' => $payment->payload['no_of_products'],
            ]);

            // Add Revenue
            Revenue::create([
                'user_id' => $payment->user_id,
                'brand_id' => $brandId,
                'payment_id' => $payment->id,
                'amount' => $payment->amount,
                'description' => $payment->payload['description'],
                'subscription_status' => $payment->payload['subscription_status'],
            ]);

            DB::commit();

            return [
                'route' => 'brand-subscription-status',
                'status' => 'success',
                'message' => 'Products capacity increased successfully.',
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            return [
                'route' => 'brand-subscription-status',
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function addDropshipper(Payment $payment): array
    {
        try {
            DB::beginTransaction();
            $applicationId = $payment->payload['application_id'];

            DropshipperApplication::where('id', $applicationId)->update([
                'status' => $payment->payload['status'],
                'notes' => $payment->payload['notes'],
                'reviewed_at' => now(),
                'reviewed_by' => $payment->payload['reviewed_by'],
            ]);

            // Add Revenue
            Revenue::create([
                'user_id' => $payment->user_id,
                'brand_id' => $payment->payload['brand_id'],
                'dropshipper_id' => $payment->payload['dropshipper_id'],
                'payment_id' => $payment->id,
                'amount' => $payment->amount,
                'description' => $payment->payload['description'],
                'subscription_status' => Status::COMMISSION,
            ]);

            DB::commit();

            return [
                'route' => 'brand-pending-applications',
                'status' => 'success',
                'message' => 'Dropshipper added successfully.',
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            return [
                'route' => 'brand-pending-applications',
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function dropshipperMonthlySubscription(Payment $payment): array
    {
        try {
            DB::beginTransaction();
            $dropshipperId = $payment->payload['dropshipper_id'];

            Dropshipper::where('id', $dropshipperId)->update([
                'exp_date' => Carbon::parse($payment->payload['expiry_date']),
            ]);

            // Add Revenue
            Revenue::create([
                'user_id' => $payment->user_id,
                'dropshipper_id' => $payment->payload['dropshipper_id'],
                'payment_id' => $payment->id,
                'amount' => $payment->amount,
                'description' => $payment->payload['description'],
                'subscription_status' => Status::MONTHLY,
            ]);

            DB::commit();

            return [
                'route' => 'dropshipper-subscriptions',
                'status' => 'success',
                'message' => 'Subscription renewed successfully..',
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            return [
                'route' => 'dropshipper-subscriptions',
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function dropshipperCommission(Payment $payment): array
    {
        $storeId = $payment->payload['storeId'];
        $orders = Order::whereIn('id', $payment->payload['orderIds'])->get();

        // process the orders
        app(OrderBatchService::class)->createBatch($storeId, $orders);

        try {
            DB::beginTransaction();

            // Add Revenue
            Revenue::create([
                'user_id' => $payment->user_id,
                'dropshipper_id' => $payment->payload['dropshipper_id'],
                'payment_id' => $payment->id,
                'amount' => $payment->amount,
                'description' => $payment->payload['description'],
                'subscription_status' => $payment->payload['description'],
            ]);

            DB::commit();

            return [
                'route' => 'dropshipper-orders',
                'params' => [
                    'store' => $storeId,
                ],
                'status' => 'success',
                'message' => 'Order batched successfully.',
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            return [
                'route' => 'dropshipper-orders',
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
