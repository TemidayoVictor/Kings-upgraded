<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\DeleteImageDTO;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class DeleteImageAction
{
    public static function execute(DeleteImageDTO $dto): void
    {
        $user = auth()->user();
        if (! $user) {
            throw new \Exception('User not found.');
        }

        $product = Product::where('id', $dto->productId)->with('images')->first();
        if (! $product) {
            throw new \Exception('Product not found.');
        }

        if ($product->images->count() <= 1 && ! $dto->override) {
            throw new \Exception('Product must have at least one image.');
        } else {
            $image = ProductImage::find($dto->imageId);
            if (! $image) {
                throw new \Exception('Image not found.');
            }

            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }
}
