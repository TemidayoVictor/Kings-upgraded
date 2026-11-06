<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Support\Str;

class SaleTagService
{
    public static function sync(Sale $sale, array $tags): void
    {
        $processedTags = collect($tags)
            ->filter(fn ($tag) => is_string($tag))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->map(fn ($tag) => [
                'name' => Str::limit($tag, 50, ''),
                'normalized_name' => Str::lower(
                    Str::squish($tag)
                ),
            ])
            ->unique('normalized_name')
            ->take(10)
            ->values();

        $sale->tags()->delete();

        foreach ($processedTags as $tag) {
            $sale->tags()->create($tag);
        }
    }
}
