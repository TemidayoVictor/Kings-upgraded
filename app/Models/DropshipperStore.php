<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DropshipperStore extends Model
{
    protected $fillable = [
        'dropshipper_id',
        'brand_id',
        'store_name',
        'slug',
        'image',
        'settings',
        'status',
        'cloned_at',
        'clone_stats',
        'cloned_from_brand',
    ];

    protected $casts = [
        'settings' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            if (empty($store->slug)) {
                $store->slug = Str::slug($store->store_name).'-'.uniqid();
            }
        });
    }

    /**
     * Get the dropshipper that owns the store
     */
    public function dropshipper(): BelongsTo
    {
        return $this->belongsTo(Dropshipper::class);
    }

    /**
     * Get the brand that this store is cloned from
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the products in this store
     */
    public function dropshipperProducts(): HasMany
    {
        return $this->hasMany(DropshipperProduct::class, 'dropshipper_store_id');
    }

    /**
     * Get orders for this store
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'dropshipper_store_id');
    }

    /**
     * Scope a query to only include active stores
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the store's URL
     */
    public function getUrlAttribute(): string
    {
        return route('dropshipper.store.show', $this->slug);
    }

    /**
     * Check if store is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get theme settings
     */
    public function getThemeSettingsAttribute(): array
    {
        return $this->settings['theme'] ?? [];
    }

    /**
     * Get shipping settings
     */
    public function getShippingSettingsAttribute(): array
    {
        return $this->settings['shipping_settings'] ?? [];
    }

    /**
     * Get payment settings
     */
    public function getPaymentSettingsAttribute(): array
    {
        return $this->settings['payment_settings'] ?? [];
    }
}
