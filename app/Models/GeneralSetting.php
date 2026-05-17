<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'basic_fee',
        'basic_products_number',
        'basic_images_number',
        'basic_additional_products_fee',
        'basic_additional_products_number',
        'premium_fee',
        'premium_products_number',
        'premium_images_number',
        'premium_additional_products_fee',
        'premium_additional_products_number',
        'platinum_fee',
        'platinum_products_number',
        'platinum_images_number',
        'platinum_additional_products_fee',
        'platinum_additional_products_number',
        'dropshipper_fee',
        'dropshipper_percent',
        'collector_percent',
    ];
}
