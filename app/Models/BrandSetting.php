<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandSetting extends Model
{
    protected $fillable = [
        'brand_id',
        'hero_tagline',
        'hero_title_line_1',
        'hero_title_line_2_italic',
        'hero_description',
        'hero_button_text',
        'primary_color',
        'secondary_color',
    ];
}
