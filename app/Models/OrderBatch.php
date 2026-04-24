<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderBatch extends Model
{
    protected $fillable = [
        'dropshipper_store_id',
        'orders',
        'amount',
        'dropshipper_amount',
    ];
}
