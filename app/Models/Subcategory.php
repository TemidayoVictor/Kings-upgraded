<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'subcategory';
    protected $fillable = [
        'category',
        'subcategory',
        'brands',
        'contracts',
        'adverts'
    ];
}
