<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'id',
    ];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }
}
