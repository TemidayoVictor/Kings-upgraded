<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    protected ?Cart $cart = null;

    protected int $brandId;

    protected bool $stockAlert = false;

    public function __construct(int $brandId, bool $stockAlert = false)
    {
        $this->brandId = $brandId;
        $this->stockAlert = $stockAlert;
    }

    public function getCart(): Cart
    {
        if ($this->cart) {
            return $this->cart;
        }

        // Proceeds here if cart was not found
        $sessionId = Session::get('cart_session_id');

        // If user is logged in, get their cart
        if (auth()->check()) {
            $this->cart = Cart::with('items.product')
                ->where('user_id', auth()->id())
                ->where('brand_id', $this->brandId)
                ->first();

            // If there's a session cart, merge it
            if ($sessionId && ! $this->cart) {
                $this->cart = $this->mergeSessionCart($sessionId);
            }
        }

        // If still no cart, get by session
        if (! $this->cart && $sessionId) {
            $this->cart = Cart::with('items.product')
                ->where('session_id', $sessionId)
                ->where('brand_id', $this->brandId)
                ->first();
        }

        // Create new cart if none exists
        if (! $this->cart) {
            $this->cart = $this->createCart();
        }

        return $this->cart;
    }

    protected function createCart(): Cart
    {
        $sessionId = Session::get('cart_session_id');

        if (! $sessionId) {
            $sessionId = Str::uuid()->toString();
            Session::put('cart_session_id', $sessionId);
        }

        return Cart::create([
            'user_id' => auth()->id(),
            'session_id' => $sessionId,
            'brand_id' => $this->brandId,
            'subtotal' => 0,
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'total' => 0,
        ]);
    }

    protected function mergeSessionCart(string $sessionId): ?Cart
    {
        $sessionCart = Cart::where('session_id', $sessionId)->first();

        if (! $sessionCart) {
            return null;
        }

        DB::transaction(function () use ($sessionCart) {
            foreach ($sessionCart->items as $item) {
                $this->addItem(
                    $item->product_id,
                    $item->quantity,
                    $item->options ?? []
                );
            }

            $sessionCart->delete();
        });

        return $this->cart;
    }

    /**
     * @throws Exception
     */
    public function addItem(int $productId, int $quantity = 1, array $options = []): CartItem
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        // Check if product belongs to same brand
        if ($product->brand_id !== $this->brandId) {
            throw new \Exception('Product does not belong to this brand');
        }

        if ($this->stockAlert) {
            if ($product->stock < $quantity) {
                throw new \Exception("Only {$product->stock} items available in stock");
            }
        }

        // Check if item exists with same options
        $existingItem = $cart->items()
            ->where('product_id', $productId)
            ->get()
            ->first(function ($item) use ($options) {
                return json_encode($item->options) === json_encode($options);
            });

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;

            if ($this->stockAlert) {
                // Check stock for new total
                if ($product->stock < $newQuantity) {
                    throw new \Exception("Cannot add more. Only {$product->stock} available");
                }
            }

            $existingItem->quantity = $newQuantity;
            $existingItem->recalculate();
            $item = $existingItem;
        } else {
            $price = $product->discount_price ?? $product->price;
            $item = $cart->items()->create([
                'product_id' => $productId,
                'product_name' => $product->name,
                'sku' => $product->sku,
                'unit_price' => $product->price,
                'discount_price' => $product->discount_price,
                'quantity' => $quantity,
                'subtotal' => $price * $quantity,
                'total' => $price * $quantity,
                'options' => $options,
            ]);
        }

        $this->updateCartTotals();

        return $item;
    }

    /**
     * @throws Exception
     */
    public function updateItem(int $itemId, int $quantity): ?CartItem
    {
        $this->cart = $this->getCart();
        $item = CartItem::with('product')->findOrFail($itemId);
        if ($quantity <= 0) {
            $this->removeItem($itemId);

            return null;
        }
        if ($this->stockAlert) {
            // Check stock
            if ($item->product->stock < $quantity) {
                throw new Exception("Only {$item->product->stock} items available");
            }
        }
        $item->quantity = $quantity;
        $item->recalculate();
        $this->updateCartTotals();

        return $item;
    }

    public function removeItem(int $itemId): void
    {
        $item = CartItem::findOrFail($itemId);
        $item->delete();

        $this->getCart();
        $this->updateCartTotals();

        if ($this->cart->items()->count() === 0) {
            $this->clearCart();
        }
    }

    public function clearCart(): void
    {
        $this->cart->items()->delete();
        $this->cart->update([
            'subtotal' => 0,
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'total' => 0,
            'coupon_code' => null,
            'coupon_data' => null,
        ]);
    }

    public function applyCoupon(string $couponCode): array
    {
        $cart = $this->getCart();

        // Find valid coupon
        $coupon = Coupon::where('code', $couponCode)
            ->where('brand_id', $this->brandId)
            ->where('is_active', true)
            ->first();

        if (! $coupon || ! $coupon->isValid()) {
            return [
                'success' => false,
                'message' => 'Invalid or expired coupon code',
            ];
        }

        // Calculate discount
        $discount = 0;
        if ($coupon->type === 'fixed') {
            $discount = $coupon->value;
        } else {
            $discount = ($cart->subtotal * $coupon->value) / 100;
        }

        // Ensure discount doesn't exceed subtotal
        $discount = min($discount, $cart->subtotal);

        // Update cart
        $cart->update([
            'coupon_code' => $coupon->code,
            'coupon_data' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
            ],
            'discount' => $discount,
            'total' => $cart->subtotal + $cart->tax + $cart->shipping - $discount,
        ]);

        return [
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => $discount,
        ];
    }

    public function removeCoupon(): void
    {
        $cart = $this->getCart();
        $cart->update([
            'coupon_code' => null,
            'coupon_data' => null,
            'discount' => 0,
            'total' => $cart->subtotal + $cart->tax + $cart->shipping,
        ]);
    }

    public function setShipping(float $shippingCost, int $locationId): void
    {
        $cart = $this->getCart();

        $cart->update([
            'shipping' => $shippingCost,
            'delivery_location_id' => $locationId,
            'total' => $cart->subtotal + $cart->tax + $shippingCost - $cart->discount,
        ]);
    }

    private function updateCartTotals(): void
    {
        // Use database aggregation to get totals
        $totals = CartItem::where('cart_id', $this->cart->id)
            ->selectRaw('
            SUM(
                CASE
                    WHEN discount_price IS NOT NULL
                    THEN discount_price * quantity
                    ELSE unit_price * quantity
                END
            ) as subtotal
        ')
            ->first();

        $subtotal = $totals->subtotal ?? 0;
        $tax = round($subtotal * 0.075, 2);
        $discount = 0.00;
        $couponData = null;
        $couponCheck = $this->cart->coupon_code;
        if (! $couponCheck) {
            $total = $subtotal + $tax + $this->cart->shipping;
        } else {
            $coupon = Coupon::where('code', $this->cart->coupon_code)
                ->where('brand_id', $this->brandId)
                ->where('is_active', true)
                ->first();

            if (! $coupon || ! $coupon->isValid()) {
                $total = $subtotal + $tax + $this->cart->shipping;
            } else {
                if ($coupon->type === 'fixed') {
                    $discount = $coupon->value;
                } else {
                    $discount = ($subtotal * $coupon->value) / 100;
                }
                // Ensure discount doesn't exceed subtotal
                $discount = min($discount, $subtotal);
                $total = $subtotal + $tax + $this->cart->shipping - $discount;

                $couponData = [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                ];
            }
        }

        $this->cart->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => max(0, $total),
            'discount' => $discount,
            'coupon_data' => $couponData,
        ]);
    }

    protected function getBrandId(): int
    {
        // Option 2: From session (if brand is selected)
        if (Session::has('current_brand_id')) {
            return Session::get('current_brand_id');
        }

        // Option 3: From request/route parameter
        if (request()->has('brand_id')) {
            return (int) request()->input('brand_id');
        }

        return 1;
    }
}
