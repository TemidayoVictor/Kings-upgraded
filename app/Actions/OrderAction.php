<?php

namespace App\Actions;

use App\DTOs\GeneralDTO;
use App\DTOs\OrderDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Mail\OrderMail;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Wishlist;
use App\Services\OrderBatchService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class OrderAction
{
    /**
     * @throws Exception|Throwable
     */
    public static function execute(OrderDTO $dto): Order
    {
        try {
            DB::beginTransaction();
            // Get cart
            $cart = $dto->cart;
            // Check stock again
            if ($dto->type == UserType::DROPSHIPPER) {
                if ($cart->dropshipperStore->brand->stock_alert) {
                    foreach ($cart->items as $item) {
                        if ($item->product->stock < $item->quantity) {
                            throw new \Exception("Insufficient stock for {$item->product_name}");
                        }
                    }
                }
            } else {
                if ($cart->brand->stock_alert) {
                    foreach ($cart->items as $item) {
                        if ($item->product->stock < $item->quantity) {
                            throw new \Exception("Insufficient stock for {$item->product_name}");
                        }
                    }
                }
            }

            // Generate unique order number
            $orderNumber = 'ORD-'.strtoupper(uniqid());
            $amount = $cart->total;

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id() ?? null,
                'brand_id' => $cart->brand_id ?? null,
                'dropshipper_store_id' => $cart->dropshipper_store_id ?? null,
                'delivery_location_id' => $cart->delivery_location_id,

                // Customer Information
                'customer_name' => $dto->customerName,
                'customer_email' => $dto->customerEmail,
                'customer_phone' => $dto->customerPhone,

                // Delivery Information
                'delivery_address' => $dto->deliveryAddress,
                'delivery_city' => $dto->deliveryCity,
                'delivery_state' => $dto->deliveryState,
                'delivery_zip' => $dto->deliveryZipCode,
                'delivery_instructions' => $dto->deliveryInstructions,

                // Pricing
                'subtotal' => $cart->subtotal,
                'tax' => $cart->tax,
                'shipping' => $cart->shipping,
                'discount' => $cart->discount,
                'total' => $cart->total,

                // Payment
                'payment_method' => $dto->paymentMethod,
                'payment_status' => Status::PENDING,
                'status' => Status::PENDING,
                'customer_notes' => $dto->notes,

                // Coupon
                'coupon_code' => $cart->coupon_code,
                'coupon_data' => $cart->coupon_data,

                // Dropshipper (if applicable)
                'dropshipper_id' => $dto->dropshipperId,
                'dropshipper_profit' => $cart->dropshipper_profit,

                // sales id if currently on sale
                'sale_id' => $cart->sale_id ?? null,
            ]);

            $dropshipperSubtotal = 0;

            if ($dto->type == UserType::DROPSHIPPER) {
                $dropshipperTotal = $order->total - $order->dropshipper_profit;
            } else {
                $dropshipperTotal = $order->total;
            }

            // Create order items
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'dropshipper_product_id' => $item->dropshipper_product_id,
                    'product_name' => $item->product_name,
                    'sku' => $item->sku,
                    'unit_price' => $item->unit_price,
                    'discount_price' => $item->discount_price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                    'dropshipper_subtotal' => $dropshipperSubtotal,
                    'total' => $item->total,
                    'sale_id' => $item->sale_id,
                    'dropshipper_total' => $dropshipperTotal,
                    'options' => $item->options,
                ]);

                // Reduce stock
                if ($dto->type == UserType::DROPSHIPPER) {
                    $item->dropshipperProduct->originalProduct->decrement('stock', $item->quantity);
                } else {
                    $item->product->decrement('stock', $item->quantity);
                }

                // if its is a product on sale, update the sale (only for brand owners)
                if ($dto->type != UserType::DROPSHIPPER) {
                    if ($item->sale_id) {
                        $sale = $item->sale;
                        $sale->update([
                            'total_amount' => $sale->total_amount + $item->subtotal,
                            'total_orders' => $sale->total_orders + $item->quantity,
                        ]);
                    }
                }
            }

            // Record coupon usage if applied
            if ($cart->coupon_code && $cart->coupon_data) {
                CouponUsage::create([
                    'coupon_id' => $cart->coupon_data['id'],
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'discount_amount' => $cart->discount,
                ]);

                // Increment coupon usage count
                Coupon::where('id', $cart->coupon_data['id'])
                    ->increment('used_count');
            }

            // Create status history
            $order->statusHistory()->create([
                'old_status' => null,
                'new_status' => 'pending',
                'changed_by' => auth()->id(),
            ]);

            // clear cart
            $cart->items()->delete();
            $cart->update([
                'subtotal' => 0,
                'tax' => 0,
                'shipping' => 0,
                'discount' => 0,
                'total' => 0,
                'coupon_code' => null,
                'coupon_data' => null,
            ]);

            DB::commit();

            // send email
            $url = $dto->type == UserType::DROPSHIPPER ? route('dropshipper-orders', $cart->dropshipperStore) : route('brand-orders');
            $name = $dto->type == UserType::DROPSHIPPER ? $cart->dropshipperStore->dropshipper->user->name : $cart->brand->user->name;
            $emailData = [
                'name' => $name,
                'orderNumber' => $orderNumber,
                'customerName' => $dto->customerName,
                'amount' => $amount,
                'url' => $url,
                'subject' => "New Order on KING'S!",
            ];

            $userEmail = $dto->type == UserType::DROPSHIPPER ? $cart->dropshipperStore->dropshipper->user->email : $cart->brand->user->email;

            Mail::to($userEmail)->send(new OrderMail($emailData));

            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Order placement failed: '.$e->getMessage());
        }
    }

    /**
     * @throws Throwable
     */
    public static function batch(GeneralDTO $dto): Payment|bool
    {
        $user = auth()->user();
        if (! $user) {
            throw new Exception('User not found.');
        }

        $dropshipper = $user->dropshipper;
        if (! $dropshipper) {
            throw new Exception('Dropshipper not found.');
        }

        try {
            DB::beginTransaction();
            $unbatchedOrders = $dto->items;

            if ($unbatchedOrders->isEmpty()) {
                throw new Exception('No orders are ready to be batched.');
            }

            if ($dropshipper->subscription_type === Status::MONTHLY) {
                if ($dropshipper->exp_date->isFuture()) {
                    app(OrderBatchService::class)->createBatch($dto->id, $unbatchedOrders);
                    DB::commit();

                    return true;
                } else {
                    throw new Exception('Kindly Renew your subscription to batch orders.');
                }
            }

            // Dropshipper utilizes commission.
            $txRef = (string) Str::uuid();
            $userId = auth()->id();
            $amount = (int) max(
                $unbatchedOrders->sum('dropshipper_profit') * (generalSetting()->dropshipper_percent / 100),
                500
            );

            $payload = [
                'user_id' => $userId,
                'dropshipper_id' => $dropshipper->id,
                'amount' => $amount,
                'description' => 'Commission Payment',
                'subscription_status' => Status::COMMISSION,
                'storeId' => $dto->id,
                'orderIds' => $unbatchedOrders->pluck('id')->all(),
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
                    'action' => 'dropshipper_commission',
                    'payload' => $payload,
                ]
            );

            DB::commit();

            return $payment;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Orders batching failed: '.$e->getMessage());
        }
    }

    /**
     * @throws Throwable
     */
    public static function removeWish(int $id): void
    {
        $user = auth()->user();
        if (! $user) {
            throw new Exception('User not found.');
        }

        try {
            DB::beginTransaction();

            $wishList = Wishlist::findOrFail($id);
            $wishList->delete();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Error: '.$e->getMessage());
        }
    }
}
