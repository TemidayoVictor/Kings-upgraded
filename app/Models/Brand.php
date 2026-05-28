<?php

namespace App\Models;

use App\Enums\Status;
use App\Livewire\Brand\Settings\BrandSettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'user_id',
        'uuid',
        'brand_name',
        'brand_email',
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
        'no_of_products',
        'subscription_amount',
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
        'slug',
        'account_name',
        'account_number',
        'bank_name',
        'revenue',
        'stock_alert',
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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function deliveryLocations(): HasMany
    {
        return $this->hasMany(DeliveryLocation::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function dropshipperApplications(): HasMany
    {
        return $this->hasMany(DropshipperApplication::class);
    }

    public function approvedDropshippers(): BelongsToMany
    {
        return $this->belongsToMany(Dropshipper::class, 'dropshipper_applications')
            ->wherePivot('status', 'approved')
            ->withTimestamps();
    }

    public function dropshipperStores(): HasMany
    {
        return $this->hasMany(DropshipperStore::class);
    }

    public function pendingDropshipperApplications(): HasMany
    {
        return $this->dropshipperApplications()->where('status', 'pending');
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
            ->where('subscription_status', '!=', Status::BASIC)
            ->whereDate('exp_date', '<', now());
    }

    public function scopeNew(Builder $query): Builder
    {
        return $query
            ->where('created_at', '>=', now()->subDays(7));
    }

    public function brandSetting()
    {
        return $this->hasOne(BrandSetting::class);
    }
}
