<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DropshipperProduct extends Model
{
    protected $fillable = [
        'dropshipper_store_id',
        'original_product_id',
        'custom_price',
        'stock_override',
        'custom_settings',
    ];

    protected $casts = [
        'custom_price' => 'decimal:2',
        'stock_override' => 'integer',
        'custom_settings' => 'array',
    ];

    /**
     * Get the store that owns this product
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(DropshipperStore::class, 'dropshipper_store_id');
    }

    /**
     * Get the original product from the brand
     */
    public function originalProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'original_product_id');
    }

    /**
     * Get the effective price (custom price or original dropship price)
     */
    public function getEffectivePriceAttribute(): float
    {
        return $this->custom_price ?? $this->originalProduct->dropship_price ?? $this->originalProduct->price;
    }

    /**
     * Get the effective stock (override or original stock)
     */
    public function getEffectiveStockAttribute(): int
    {
        return $this->stock_override ?? $this->originalProduct->stock ?? 0;
    }

    /**
     * Check if product is in stock
     */
    public function getInStockAttribute(): bool
    {
        return $this->effective_stock > 0;
    }

    /**
     * Scope to only include products where original product is active
     */
    public function scopeActive($query)
    {
        return $query->whereHas('originalProduct', function ($q) {
            $q->where('is_active', true);
        });
    }

    /**
     * Scope to only include products with stock
     */
    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('stock_override', '>', 0)
                ->orWhereNull('stock_override');
        })->whereHas('originalProduct', function ($q) {
            $q->where('stock', '>', 0);
        });
    }
}
