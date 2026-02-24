<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dropshipper extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'account_name',
        'account_number',
        'bank_name',
        'status',
        'revenue',
        'image'
    ];

    protected $casts = [
        'revenue' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
