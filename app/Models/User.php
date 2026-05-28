<?php

namespace App\Models;

use App\Enums\UserType;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'current_brand_id',
        'is_admin',
        'status',
        'onboarding_step',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function preferences(): BelongsToMany
    {
        return $this->belongsToMany(Preference::class);
    }

    public function hasPreference($preferenceId): bool
    {
        return $this->preferences()->where('preference_id', $preferenceId)->exists();
    }

    public function dropshipper(): HasOne
    {
        return $this->hasOne(Dropshipper::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'current_brand_id');
    }

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function couponUsages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function verification(): HasOne
    {
        return $this->hasOne(VerificationCode::class);
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            UserType::ADMIN => 'admin-manage-users',
            UserType::BRAND => 'brand-dashboard',
            UserType::DROPSHIPPER => 'dropshipper-partnered-brands',
            UserType::CLIENT => 'client-dashboard',
            default => 'home',
        };
    }
}
