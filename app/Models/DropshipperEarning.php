<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DropshipperEarning extends Model
{
    protected $fillable = [
        'dropshipper_store_id',
        'order_id',
        'amount',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(DropshipperStore::class, 'dropshipper_store_id');
    }
}
