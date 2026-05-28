<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use Exception;
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

        $sessionKey = 'cart_session_id_'.$this->brandId;
        $sessionId = Session::get($sessionKey);

        // Logged-in user cart
        if (auth()->check()) {
            $userCart = Cart::with('items.product')
                ->where('user_id', auth()->id())
                ->where('brand_id', $this->brandId)
                ->first();

            if (! $userCart) {
                $this->createCart();
            }
        }

        // Guest cart
        if (! $this->cart && $sessionId) {
            $this->cart = Cart::with('items.product')
                ->where('session_id', $sessionId)
                ->where('brand_id', $this->brandId)
                ->first();
        }

        // Create if none exists
        if (! $this->cart) {
            $this->cart = $this->createCart();
        }

        return $this->cart;
    }

    protected function createCart(): Cart
    {
        $sessionKey = 'cart_session_id_'.$this->brandId;
        $sessionId = Session::get($sessionKey);

        if (! $sessionId) {
            $sessionId = (string) Str::uuid();
            Session::put($sessionKey, $sessionId);
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

    /**
     * @throws Exception
     */
    public function addItem(int $productId, int $quantity = 1, array $options = []): CartItem
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        if ($product->brand_id !== $this->brandId) {
            throw new \Exception('Product does not belong to this brand');
        }

        if ($this->stockAlert && $product->stock < $quantity) {
            throw new \Exception("Only {$product->stock} items available in stock");
        }

        $existingItem = $cart->items()
            ->where('product_id', $productId)
            ->get()
            ->first(function ($item) use ($options) {
                return json_encode($item->options) === json_encode($options);
            });

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;

            if ($this->stockAlert && $product->stock < $newQuantity) {
                throw new \Exception("Cannot add more. Only {$product->stock} available");
            }

            $existingItem->update([
                'quantity' => $newQuantity,
            ]);

            $existingItem->recalculate();

            $item = $existingItem;
        } else {
            $price = $product->sale_status ? $product->sales_price : $product->price;
            $saleId = $product->sale_status ? $product->sale_id : null;

            $item = $cart->items()->create([
                'product_id' => $productId,
                'product_name' => $product->name,
                'sku' => $product->sku,
                'unit_price' => $price,
                'discount_price' => $product->sale_status ? $product->sales_price : null,
                'quantity' => $quantity,
                'subtotal' => $price * $quantity,
                'total' => $price * $quantity,
                'sale_id' => $saleId,
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
        // Check stock
        if ($this->stockAlert && $item->product->stock < $quantity) {
            throw new Exception("Only {$item->product->stock} items available");
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
}
