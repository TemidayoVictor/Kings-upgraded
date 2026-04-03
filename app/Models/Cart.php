<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'session_id', 'brand_id', 'subtotal', 'tax',
        'shipping', 'delivery_location_id', 'discount', 'total', 'coupon_code', 'coupon_data',
        'product_id',
        'product_name',
        'sku',
        'unit_price',
        'discount_price',
        'quantity',
        'options',
        'dropshipper_store_id',
        'dropshipper_product_id',
        'dropship_price',
        'custom_price',
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

    public function dropshipperStore(): BelongsTo
    {
        return $this->belongsTo(DropshipperStore::class, 'dropshipper_store_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(DeliveryLocation::class, 'delivery_location_id');
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

    /**
     * Scope for brand carts
     */
    public function scopeForBrand($query, int $brandId)
    {
        return $query->where('brand_id', $brandId)
            ->whereNull('dropshipper_store_id');
    }

    /**
     * Scope for dropshipper store carts
     */
    public function scopeForDropshipperStore($query, int $storeId)
    {
        return $query->where('dropshipper_store_id', $storeId)
            ->whereNull('brand_id');
    }
}
