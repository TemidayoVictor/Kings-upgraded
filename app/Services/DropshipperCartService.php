<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\DropshipperProduct;
use App\Models\DropshipperStore;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DropshipperCartService
{
    protected ?Cart $cart = null;

    protected int $storeId;

    public function __construct(int $storeId)
    {
        $this->storeId = $storeId;
    }

    public function getCart(): Cart
    {
        if ($this->cart) {
            return $this->cart;
        }

        $sessionId = Session::get('dropshipper_cart_session_'.$this->storeId);

        // If user is logged in, get their cart
        if (auth()->check()) {
            $this->cart = Cart::with(['items.dropshipperProduct.originalProduct'])
                ->where('user_id', auth()->id())
                ->where('dropshipper_store_id', $this->storeId)
                ->first();

            // If there's a session cart, merge it
            if ($sessionId && ! $this->cart) {
                $this->cart = $this->mergeSessionCart($sessionId);
            }
        }

        // If still no cart, get by session
        if (! $this->cart && $sessionId) {
            $this->cart = Cart::with(['items.dropshipperProduct.originalProduct'])
                ->where('session_id', $sessionId)
                ->where('dropshipper_store_id', $this->storeId)
                ->first();
        }

        // Create new cart if none exists
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
        $sessionId = Session::get('dropshipper_cart_session_'.$this->storeId);

        if (! $sessionId) {
            $sessionId = Str::uuid()->toString();
            Session::put('dropshipper_cart_session_'.$this->storeId, $sessionId);
        }

        return Cart::create([
            'user_id' => auth()->id(),
            'session_id' => $sessionId,
            'dropshipper_store_id' => $this->storeId,
            'brand_id' => null, // Ensure brand_id is null for dropshipper carts
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
    protected function mergeSessionCart(string $sessionId): ?Cart
    {
        $sessionCart = Cart::where('session_id', $sessionId)
            ->where('dropshipper_store_id', $this->storeId)
            ->first();

        if (! $sessionCart) {
            return null;
        }

        DB::transaction(function () use ($sessionCart) {
            foreach ($sessionCart->items as $item) {
                try {
                    $this->addItem(
                        $item->dropshipper_product_id,
                        $item->quantity,
                        $item->options ?? []
                    );
                } catch (Exception $e) {
                    // Skip items that can't be added
                    continue;
                }
            }

            $sessionCart->delete();
        });

        return $this->cart;
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

        // Check if original product is active and published
        if (! $product->originalProduct || ! $product->originalProduct->is_active || ! $product->originalProduct->publish) {
            throw new Exception('This product is no longer available');
        }

        // Check stock
        if ($product->effective_stock < $quantity) {
            throw new Exception("Only {$product->effective_stock} items available in stock");
        }

        $cart = $this->getCart();

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
            if ($product->effective_stock < $newQuantity) {
                throw new Exception("Cannot add more. Only {$product->effective_stock} available");
            }

            $existingItem->quantity = $newQuantity;
            $existingItem->recalculate();
            $item = $existingItem;
        } else {
            $item = $cart->items()->create([
                'dropshipper_product_id' => $dropshipperProductId,
                'product_name' => $product->originalProduct->name,
                'sku' => $product->originalProduct->sku ?? 'N/A',
                'unit_price' => $product->originalProduct->price,
                'dropship_price' => $product->originalProduct->dropship_price,
                'custom_price' => $product->custom_price,
                'quantity' => $quantity,
                'subtotal' => $product->effective_price * $quantity,
                'total' => $product->effective_price * $quantity,
                'options' => $options,
            ]);
        }

        $cart->recalculateTotals();

        return $item;
    }

    /**
     * Update item quantity
     *
     * @throws Exception
     */
    public function updateItem(int $itemId, int $quantity): ?CartItem
    {
        $item = CartItem::with('product.originalProduct')
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
        if (! $item->product->originalProduct || ! $item->product->originalProduct->is_active || ! $item->product->originalProduct->publish) {
            throw new Exception('This product is no longer available');
        }

        // Check stock
        if ($item->product->effective_stock < $quantity) {
            throw new Exception("Only {$item->product->effective_stock} items available");
        }

        $item->quantity = $quantity;
        $item->recalculate()->save();

        $this->cart = $item->cart;
        $this->cart->recalculateTotals();

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
        $this->cart->recalculateTotals();

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

    /**
     * Apply coupon to cart
     */
    public function applyCoupon(string $couponCode): array
    {
        $cart = $this->getCart();
        $store = DropshipperStore::findOrFail($this->storeId);

        // Find valid coupon (using brand's coupons since dropshippers use brand coupons)
        $coupon = Coupon::where('code', $couponCode)
            ->where('brand_id', $store->brand_id) // Coupons belong to the original brand
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->first();

        if (! $coupon) {
            return [
                'success' => false,
                'message' => 'Invalid or expired coupon code',
            ];
        }

        // Check usage limits
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return [
                'success' => false,
                'message' => 'This coupon has reached its usage limit',
            ];
        }

        // Check per-user limit
        if (auth()->check() && $coupon->usage_per_user) {
            $userUsage = $coupon->usages()
                ->where('user_id', auth()->id())
                ->count();

            if ($userUsage >= $coupon->usage_per_user) {
                return [
                    'success' => false,
                    'message' => 'You have already used this coupon',
                ];
            }
        }

        // Check minimum order amount
        if ($coupon->min_order_amount && $cart->subtotal < $coupon->min_order_amount) {
            return [
                'success' => false,
                'message' => 'Minimum order amount of ₦'.number_format($coupon->min_order_amount).' required',
            ];
        }

        // Calculate discount
        $discount = 0;
        if ($coupon->type === 'fixed') {
            $discount = $coupon->value;
        } else {
            $discount = ($cart->subtotal * $coupon->value) / 100;
            if ($coupon->max_discount_amount && $discount > $coupon->max_discount_amount) {
                $discount = $coupon->max_discount_amount;
            }
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
                'discount' => $discount,
                'brand_id' => $coupon->brand_id,
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

    /**
     * Remove coupon from cart
     */
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

    /**
     * Set shipping cost
     */
    public function setShipping(float $shippingCost): void
    {
        $cart = $this->getCart();

        $cart->update([
            'shipping' => $shippingCost,
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
