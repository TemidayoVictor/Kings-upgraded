<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryLocation extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'delivery_price',
        'parent_id',
        'level',
        'is_active'
    ];

    protected $casts = [
        'delivery_price' => 'decimal:2',
        'is_active' => 'boolean',
        'level' => 'integer'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(DeliveryLocation::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(DeliveryLocation::class, 'parent_id')->orderBy('name');
    }

    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    // Scopes
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    // Helper methods
    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function getFullPathAttribute(): string
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }

    public function getEffectivePriceAttribute(): ?float
    {
        if ($this->delivery_price !== null) {
            return (float) $this->delivery_price;
        }

        return $this->parent ? $this->parent->effective_price : null;
    }
}
