<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Preference;
use Illuminate\Support\Str;

class PreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preferences = [
            'Technology',
            'Fashion',
            'Fitness',
            'Beauty',
            'Electronics',
            'Home & Living',
            'Gaming',
            'Food',
            'Travel',
            'Business',
        ];

        foreach ($preferences as $pref) {
            Preference::create([
                'name' => $pref,
                'slug' => Str::slug($pref),
            ]);
        }
    }
}
