<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dropshipper extends Model
{

    protected $fillable = [
        'user_id',
        'username',
        'account_name',
        'account_number',
        'bank_name',
        'status',
        'revenue',
        'image',
    ];

    protected $casts = [
        'revenue' => 'decimal:2',
    ];

    public function applications()
    {
        return $this->hasMany(DropshipperApplication::class);
    }

    public function approvedBrands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'dropshipper_applications')
            ->wherePivot('status', 'approved')
            ->withTimestamps();
    }

    public function stores(): HasMany
    {
        return $this->hasMany(DropshipperStore::class);
    }

    public function pendingApplications()
    {
        return $this->applications()->where('status', 'pending');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
