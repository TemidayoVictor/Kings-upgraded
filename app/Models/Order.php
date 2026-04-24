<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'brand_id',
        'dropshipper_id',
        'dropshipper_store_id',
        'delivery_location_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_address',
        'delivery_city',
        'delivery_state',
        'delivery_zip',
        'delivery_instructions',
        'subtotal',
        'tax',
        'shipping',
        'discount',
        'total',
        'payment_method',
        'payment_status',
        'payment_reference',
        'payment_data',
        'status',
        'admin_notes',
        'customer_notes',
        'coupon_code',
        'coupon_data',
        'paid_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'dropshipper_status',
        'order_batch_id',
        'dropshipper_profit',
    ];

    protected $casts = [
        'payment_data' => 'array',
        'coupon_data' => 'array',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function couponUsages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(DropshipperStore::class, 'dropshipper_store_id');
    }

    public function deliveryLocation(): BelongsTo
    {
        return $this->belongsTo(DeliveryLocation::class);
    }
}
