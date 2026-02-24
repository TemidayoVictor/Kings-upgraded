<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
        'brand_name',
        'category',
        'sub_category',
        'description',
        'position',
        'state',
        'city',
        'address',
        'about',
        'motto',
        'image',
        'instagram',
        'facebook',
        'twitter',
        'youtube',
        'tiktok',
        'linkedin',
        'website',
        'subscription_status',
        'exp_date',
        'exp_date_parsed',
        'status',
        'mode',
        'brand_type',
        'account_name',
        'account_number',
        'bank_name',
        'revenue',
    ];

    protected $casts = [
        'uuid' => 'integer',
        'revenue' => 'decimal:2',
        'exp_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
