<?php

// app/Models/CartItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\HigherOrderCollectionProxy;

class CartItem extends Model
{
    /**
     * @var HigherOrderCollectionProxy|int|mixed
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'dropshipper_product_id',
        'product_name',
        'sku',
        'unit_price',
        'discount_price',
        'dropship_price',
        'custom_price',
        'quantity',
        'subtotal',
        'total',
        'dropshipper_profit',
        'options',
        'metadata',
    ];

    protected $casts = [
        'options' => 'array',
        'metadata' => 'array',
        'dropship_price' => 'decimal:2',
        'custom_price' => 'decimal:2',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function dropshipperProduct(): BelongsTo
    {
        return $this->belongsTo(DropshipperProduct::class, 'dropshipper_product_id');
    }

    /**
     * Recalculate item subtotal and total based on quantity and price
     */
    public function recalculate(): self
    {
        // Use discount price if available, otherwise use unit price
        $price = $this->discount_price ?? $this->unit_price;

        // Calculate subtotal (price × quantity)
        $this->subtotal = $price * $this->quantity;

        // Total is same as subtotal (no additional taxes at item level)
        $this->total = $this->subtotal;

        $this->save();

        return $this;
    }

    /**
     * Get the effective price (discount price if available)
     */
    public function getEffectivePriceAttribute(): float
    {
        return $this->discount_price ?? $this->unit_price;
    }

    /**
     * Check if this is a dropshipper store item
     */
    public function getIsDropshipperItemAttribute(): bool
    {
        return ! is_null($this->dropshipper_product_id);
    }

    /**
     * Get formatted price for display
     */
    public function getFormattedPriceAttribute(): string
    {
        return '₦'.number_format($this->effective_price, 2);
    }

    /**
     * Get formatted subtotal for display
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return '₦'.number_format($this->subtotal, 2);
    }
}
