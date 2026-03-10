<?php

// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'session_id', 'brand_id', 'subtotal', 'tax',
        'shipping', 'discount', 'total', 'coupon_code', 'coupon_data',
        'product_id',
        'product_name',
        'sku',
        'unit_price',
        'discount_price',
        'quantity',
        'options',
    ];

    protected $casts = [
        'coupon_data' => 'array',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function recalculateTotals(): self
    {
        // Load items if not already loaded
        if (! $this->relationLoaded('items')) {
            $this->load('items');
        }

        // Calculate subtotal from items
        $this->subtotal = $this->items->sum('total');

        // Calculate tax (7.5% example)
        $this->tax = round($this->subtotal * 0.075, 2);

        // Calculate final total
        $this->total = $this->subtotal + $this->tax + $this->shipping - $this->discount;

        // Ensure total is not negative
        if ($this->total < 0) {
            $this->total = 0;
        }

        $this->save();

        return $this;
    }

    /**
     * Get total number of items in cart
     */
    public function getItemCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Check if cart is empty
     */
    public function isEmpty(): bool
    {
        return $this->items->count() === 0;
    }

    /**
     * Clear all items from cart
     */
    public function clear(): void
    {
        $this->items()->delete();
        $this->subtotal = 0;
        $this->tax = 0;
        $this->discount = 0;
        $this->total = 0;
        $this->coupon_code = null;
        $this->coupon_data = null;
        $this->save();
    }
}
