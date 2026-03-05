<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'product_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'image_url',
        'filename',
    ];

    /**
     * Get the full image URL.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * Get just the filename from the path.
     */
    public function getFilenameAttribute(): string
    {
        return basename($this->image_path);
    }

    /**
     * Get the directory path without filename.
     */
    public function getDirectoryAttribute(): string
    {
        return dirname($this->image_path);
    }

    /**
     * Scope a query to only include images for a specific product.
     */
    public function scopeForProduct($query, int $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Get the product that owns the image.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Delete the image file from storage when model is deleted.
     */
    protected static function booted()
    {
        static::deleting(function ($productImage) {
            // Delete the physical file when database record is deleted
            $path = storage_path('app/public/' . $productImage->image_path);
            if (file_exists($path)) {
                unlink($path);
            }
        });
    }
}
