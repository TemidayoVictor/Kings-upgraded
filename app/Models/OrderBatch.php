<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderBatch extends Model
{
    protected $fillable = [
        'dropshipper_store_id',
        'orders',
        'amount',
        'dropshipper_amount',
    ];

    public function dropshipperStore(): BelongsTo
    {
        return $this->belongsTo(DropshipperStore::class);
    }
}
