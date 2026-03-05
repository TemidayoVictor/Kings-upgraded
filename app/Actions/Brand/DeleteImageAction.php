<?php

namespace App\Actions\Brand;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\ProductImage;
use App\DTOs\Brand\DeleteImageDTO;

class DeleteImageAction
{
    public static function execute(DeleteImageDTO $dto): void
    {
        $user = auth()->user();
        if (!$user) {
            throw new \Exception('User not found.');
        }

        $product = Product::where('id', $dto->productId)->with('images')->first();
        if(!$product) {
            throw new \Exception('Product not found.');
        }

        if($product->images->count() <= 1 && !$dto->override) {
            throw new \Exception('Product must have at least one image.');
        } else {
            $image = ProductImage::find($dto->imageId);
            if (!$image) {
                throw new \Exception('Image not found.');
            }

            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }
}
