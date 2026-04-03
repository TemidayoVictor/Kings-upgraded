<?php

// app/Models/OrderItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'sku', 'unit_price',
        'discount_price', 'quantity', 'subtotal', 'total', 'options', 'metadata', 'dropshipper_product_id',
    ];

    protected $casts = [
        'options' => 'array',
        'metadata' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function dropshipperProduct(): BelongsTo
    {
        return $this->belongsTo(DropshipperProduct::class, 'dropshipper_product_id');
    }
}
