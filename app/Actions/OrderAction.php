<?php

namespace App\Actions;

use App\DTOs\OrderDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\DB;
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
            ]);

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
                    'total' => $item->total,
                    'options' => $item->options,
                ]);

                // Reduce stock
                if ($dto->type == UserType::DROPSHIPPER) {
                    $item->dropshipperProduct->originalProduct->decrement('stock', $item->quantity);
                } else {
                    $item->product->decrement('stock', $item->quantity);
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

            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Order placement failed: '.$e->getMessage());
        }
    }
}
