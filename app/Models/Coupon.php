<?php

// app/Models/Coupon.php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'brand_id',
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'starts_at',
        'expires_at',
        'usage_limit',
        'usage_per_user',
        'used_count',
        'applicable_products',
        'excluded_products',
        'applicable_categories',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'applicable_products' => 'array',
        'excluded_products' => 'array',
        'applicable_categories' => 'array',
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

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            });
    }

    public function isValidForUser($user, $cartTotal): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->usage_per_user && $user) {
            $used = $this->usages()
                ->where('user_id', $user->id)
                ->count();

            if ($used >= $this->usage_per_user) {
                return false;
            }
        }

        if ($this->min_order_amount && $cartTotal < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    public function isValid(): bool
    {
        // Check if coupon is active
        if (! $this->is_active) {
            return false;
        }

        // Check if current date is before start date (if start date exists)
        if ($this->starts_at && now()->startOfDay()->lt($this->starts_at)) {
            return false;
        }

        // Check if current date is after expiration date (if expiration date exists)
        if ($this->expires_at && now()->endOfDay()->gt($this->expires_at)) {
            return false;
        }

        // Check usage limit (if usage_limit column exists)
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($amount): float
    {
        if ($this->type === 'fixed') {
            return min($this->value, $amount);
        }

        if ($this->type === 'percentage') {
            $discount = ($this->value / 100) * $amount;

            if ($this->max_discount_amount) {
                return min($discount, $this->max_discount_amount);
            }

            return $discount;
        }

        return 0;
    }
}
