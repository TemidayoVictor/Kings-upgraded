<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'description',
        'link',
        'price',
        'sales_price',
        'dropship_price',
        'date',
        'section_id',
        'stock',
        'sale_status',
        'publish',
        'visible',
    ];

    protected $casts = [
        'price' => 'integer',
        'sales_price' => 'integer',
        'dropship_price' => 'integer',
        'stock' => 'integer',
        'sale_status' => 'boolean',
        'publish' => 'boolean',
        'visible' => 'boolean',
        'date' => 'date',
        'section_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'visible' => true,
        'stock' => 0,
        'sale_status' => false,
        'publish' => false,
    ];

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)->oldest();
    }

    /**
     * Scope a query to only include visible products.
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    /**
     * Scope a query to only include published products.
     */
    public function scopePublished($query)
    {
        return $query->where('publish', true);
    }

    /**
     * Scope a query to only include products on sale.
     */
    public function scopeOnSale($query)
    {
        return $query->where('sale_status', true);
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to filter by section.
     */
    public function scopeInSection($query, string $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Scope a query to search products by name or description.
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        });
    }

    /**
     * Get the current price (sales price if available, otherwise regular price).
     */
    public function getCurrentPriceAttribute(): int
    {
        return $this->sales_price ?? $this->price;
    }

    /**
     * Check if the product has a sales price.
     */
    public function getHasSaleAttribute(): bool
    {
        return !is_null($this->sales_price) && $this->sales_price < $this->price;
    }

    /**
     * Get the discount percentage if on sale.
     */
    public function getDiscountPercentageAttribute(): ?int
    {
        if (!$this->has_sale) {
            return null;
        }

        return round((($this->price - $this->sales_price) / $this->price) * 100);
    }

    /**
     * Get the formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '₱' . number_format($this->price, 2);
    }

    /**
     * Get the formatted sales price.
     */
    public function getFormattedSalesPriceAttribute(): ?string
    {
        return $this->sales_price ? '₱' . number_format($this->sales_price, 2) : null;
    }

    /**
     * Get all image URLs.
     */
    public function getImageUrlsAttribute(): array
    {
        return $this->images->map(function ($image) {
            return asset('storage/' . $image->image_path);
        })->toArray();
    }

    /**
     * Get the primary image URL.
     */
    public function getPrimaryImageUrlAttribute(): ?string
    {
        $primaryImage = $this->images->first();

        return $primaryImage
            ? asset('storage/' . $primaryImage->image_path)
            : asset('images/placeholder.jpg'); // Fallback image
    }

    /**
     * Check if product is available for purchase.
     */
    public function getIsAvailableAttribute(): bool
    {
        return $this->visible && $this->publish && $this->stock > 0;
    }

    /**
     * Decrement stock when product is purchased.
     */
    public function decrementStock(int $quantity = 1): bool
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }

        return false;
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the primary/first image for the product.
     */

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
