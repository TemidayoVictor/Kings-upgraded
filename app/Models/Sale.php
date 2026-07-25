<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'name',
        'description',
        'discount_type',
        'discount_value',
        'sale_mode',
        'starts_at',
        'ends_at',
        'is_active',
        'ongoing',
        'brand_id',
        'section_id',
        'total_amount',
        'total_orders',
        'id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->oldest();
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function orders()
    {
        return $this->hasManyThrough(
            Order::class,
            OrderItem::class,
            'sale_id',
            'id',
            'id',
            'order_id'
        )->distinct();
    }
}
