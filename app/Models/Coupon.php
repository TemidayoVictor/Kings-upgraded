<?php

// app/Models/Coupon.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'brand_id', 'code', 'type', 'value', 'min_order_amount',
        'max_discount_amount', 'starts_at', 'expires_at', 'usage_limit',
        'usage_per_user', 'used_count', 'applicable_products',
        'excluded_products', 'applicable_categories', 'is_active',
    ];

    protected $casts = [
        'applicable_products' => 'array',
        'excluded_products' => 'array',
        'applicable_categories' => 'array',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }
}
