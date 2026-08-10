<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_ref',
        'amount',
        'currency',
        'status',
        'action',
        'payload',
        'transaction_id',
        'paid_at',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
