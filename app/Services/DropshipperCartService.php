<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\DropshipperProduct;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DropshipperCartService
{
    protected ?Cart $cart = null;

    protected int $storeId;

    protected int $stockAlert;

    public function __construct(int $storeId, bool $stockAlert = false)
    {
        $this->storeId = $storeId;
        $this->stockAlert = $stockAlert;
    }

    public function getCart(): Cart
    {
        if ($this->cart) {
            return $this->cart;
        }

        $sessionKey = 'dropshipper_cart_session_'.$this->storeId;
        $sessionId = Session::get($sessionKey);

        // Logged-in user cart
        if (auth()->check()) {
            $userCart = Cart::with('items.dropshipperProduct.originalProduct')
                ->where('user_id', auth()->id())
                ->where('dropshipper_store_id', $this->storeId)
                ->first();

            // If session cart exists → merge ALWAYS
            if ($sessionId) {
                $this->cart = $this->mergeSessionCart($sessionId, $userCart);
            } else {
                $this->cart = $userCart;
            }
        }

        // Guest cart
        if (! $this->cart && $sessionId) {
            $this->cart = Cart::with('items.dropshipperProduct.originalProduct')
                ->where('session_id', $sessionId)
                ->where('dropshipper_store_id', $this->storeId)
                ->first();
        }

        // Create if none exists
        if (! $this->cart) {
            $this->cart = $this->createCart();
        }

        return $this->cart;
    }

    /**
     * Create a new cart
     */
    protected function createCart(): Cart
    {
        $sessionKey = 'dropshipper_cart_session_'.$this->storeId;
        $sessionId = Session::get($sessionKey);

        if (! $sessionId) {
            $sessionId = (string) Str::uuid();
            Session::put($sessionKey, $sessionId);
        }

        return Cart::create([
            'user_id' => auth()->id(),
            'session_id' => $sessionId,
            'brand_id' => null,
            'dropshipper_store_id' => $this->storeId,
            'subtotal' => 0,
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'total' => 0,
        ]);
    }

    /**
     * Merge session cart with user cart after login
     */
    protected function mergeSessionCart(string $sessionId, ?Cart $userCart = null): Cart
    {
        $sessionCart = Cart::with('items')
            ->where('session_id', $sessionId)
            ->where('dropshipper_store_id', $this->storeId)
            ->first();

        if (! $sessionCart) {
            return $userCart ?? $this->createCart();
        }

        // ✅ If user has no cart → just assign session cart
        if (! $userCart) {
            $sessionCart->update([
                'user_id' => auth()->id(),
            ]);

            Session::forget('dropshipper_cart_session_'.$this->storeId);

            return $sessionCart;
        }

        // ✅ Merge carts
        DB::transaction(function () use ($sessionCart, $userCart) {
            foreach ($sessionCart->items as $item) {

                $existing = $userCart->items()
                    ->where('product_id', $item->product_id)
                    ->get()
                    ->first(function ($i) use ($item) {
                        return json_encode($i->options) === json_encode($item->options);
                    });

                if ($existing) {
                    $existing->increment('quantity', $item->quantity);
                    $existing->recalculate();
                } else {
                    $userCart->items()->create([
                        'product_id' => 0,
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
                }
            }

            $sessionCart->delete();
        });

        Session::forget('dropshipper_cart_session_'.$this->storeId);

        return $userCart;
    }

    /**
     * Add item to cart
     *
     * @throws Exception
     */
    public function addItem(int $dropshipperProductId, int $quantity = 1, array $options = []): CartItem
    {
        // Load product with original product to check availability
        $product = DropshipperProduct::with('originalProduct')
            ->where('id', $dropshipperProductId)
            ->where('dropshipper_store_id', $this->storeId)
            ->firstOrFail();

        $cart = $this->getCart();

        // Check if original product is active and published
        if (! $product->originalProduct || ! $product->originalProduct->is_active || ! $product->originalProduct->publish) {
            throw new Exception('This product is no longer available');
        }

        // Check stock
        if ($this->stockAlert && $product->originalProduct->stock < $quantity) {
            throw new \Exception("Only {$product->originalProduct->stock} items available in stock");
        }

        // Check if item exists with same options
        $existingItem = $cart->items()
            ->where('dropshipper_product_id', $dropshipperProductId)
            ->get()
            ->first(function ($item) use ($options) {
                return json_encode($item->options) === json_encode($options);
            });

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;

            // Check stock for new total
            if ($this->stockAlert && $product->stock < $newQuantity) {
                throw new \Exception("Cannot add more. Only {$product->stock} available");
            }

            $existingItem->update([
                'quantity' => $newQuantity,
            ]);
            $existingItem->recalculate();
            $item = $existingItem;

        } else {
            $price = $product->discount_price ?? $product->custom_price;
            $item = $cart->items()->create([
                'product_id' => null,
                'dropshipper_product_id' => $dropshipperProductId,
                'product_name' => $product->originalProduct->name,
                'sku' => $product->originalProduct->sku,
                'unit_price' => $price,
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
     * Update item quantity
     *
     * @throws Exception
     */
    public function updateItem(int $itemId, int $quantity): ?CartItem
    {
        $this->cart = $this->getCart();
        $item = CartItem::with('dropshipperProduct.originalProduct')
            ->where('id', $itemId)
            ->whereHas('cart', function ($q) {
                $q->where('dropshipper_store_id', $this->storeId);
            })
            ->firstOrFail();

        if ($quantity <= 0) {
            $this->removeItem($itemId);

            return null;
        }

        // Check if original product is still active
        if (! $item->dropshipperProduct->originalProduct || ! $item->dropshipperProduct->originalProduct->is_active || ! $item->dropshipperProduct->originalProduct->publish) {
            throw new Exception('This product is no longer available');
        }

        // Check stock
        if ($this->stockAlert && $item->dropshipperProduct->originalProduct->stock < $quantity) {
            throw new Exception("Only {$item->dropshipperProduct->originalProduct->stock} items available");
        }

        $item->quantity = $quantity;
        $item->recalculate();
        $this->updateCartTotals();

        return $item;
    }

    /**
     * Remove item from cart
     */
    public function removeItem(int $itemId): void
    {
        $item = CartItem::where('id', $itemId)
            ->whereHas('cart', function ($q) {
                $q->where('dropshipper_store_id', $this->storeId);
            })
            ->firstOrFail();

        $item->delete();

        $this->getCart();
        $this->updateCartTotals();

        if ($this->cart->items()->count() === 0) {
            $this->clearCart();
        }
    }

    /**
     * Clear all items from cart
     */
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
        $total = $subtotal + $tax + $this->cart->shipping;

        $this->cart->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => max(0, $total),
            'discount' => $discount,
        ]);
    }

    /**
     * Set shipping cost
     */
    public function setShipping(float $shippingCost, int $locationId): void
    {
        $cart = $this->getCart();

        $cart->update([
            'shipping' => $shippingCost,
            'delivery_location_id' => $locationId,
            'total' => $cart->subtotal + $cart->tax + $shippingCost - $cart->discount,
        ]);
    }

    /**
     * Set tax amount
     */
    public function setTax(float $taxAmount): void
    {
        $cart = $this->getCart();

        $cart->update([
            'tax' => $taxAmount,
            'total' => $cart->subtotal + $taxAmount + $cart->shipping - $cart->discount,
        ]);
    }

    /**
     * Get cart summary
     */
    public function getSummary(): array
    {
        $cart = $this->getCart();

        return [
            'subtotal' => $cart->subtotal,
            'tax' => $cart->tax,
            'shipping' => $cart->shipping,
            'discount' => $cart->discount,
            'total' => $cart->total,
            'item_count' => $cart->items->sum('quantity'),
            'unique_item_count' => $cart->items->count(),
            'coupon_code' => $cart->coupon_code,
        ];
    }

    /**
     * Validate all cart items (check if still available)
     */
    public function validateCart(): array
    {
        $cart = $this->getCart();
        $invalidItems = [];

        foreach ($cart->items as $item) {
            $product = $item->product;

            // Check if original product is still active
            if (! $product->originalProduct || ! $product->originalProduct->is_active || ! $product->originalProduct->publish) {
                $invalidItems[] = [
                    'id' => $item->id,
                    'name' => $item->product_name,
                    'reason' => 'Product is no longer available',
                ];
                $item->delete();

                continue;
            }

            // Check stock
            if ($product->effective_stock < $item->quantity) {
                $invalidItems[] = [
                    'id' => $item->id,
                    'name' => $item->product_name,
                    'reason' => "Only {$product->effective_stock} items available",
                ];

                if ($product->effective_stock > 0) {
                    $item->quantity = $product->effective_stock;
                    $item->recalculate()->save();
                } else {
                    $item->delete();
                }
            }
        }

        if (count($invalidItems) > 0) {
            $cart->recalculateTotals();
        }

        return $invalidItems;
    }
}
