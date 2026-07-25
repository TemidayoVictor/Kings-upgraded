<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
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
        'subscription_type',
        'last_subscription_type_update',
        'exp_date',
    ];

    protected $casts = [
        'revenue' => 'decimal:2',
        'last_subscription_type_update' => 'datetime',
        'exp_date' => 'datetime',
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

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', Status::COMPLETED);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', Status::UNLISTED);
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query
            ->where('subscription_type', Status::MONTHLY)
            ->whereDate('exp_date', '<', now());
    }
}
