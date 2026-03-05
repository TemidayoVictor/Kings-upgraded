<?php

namespace App\Actions\Brand;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\DTOs\Brand\ProductDTO;

use App\Models\Product;
use App\Models\ProductImage;
use App\Enums\UserType;
use Carbon\Carbon;

class AddProductAction
{
    public static function execute(ProductDTO $dto): Product
    {
        $user = auth()->user();

        if (!$user || $user->role != UserType::BRAND) {
            throw new \Exception('User not found.');
        }
        $brandId = auth()->user()->brand->id;
//        create product
        if (!$dto->description) {
            $description = $dto->name;
        } else {
            $description = $dto->description;
        }

        $date = Carbon::now()->format('d F, Y');

        $product = Product::create([
           'brand_id' => $brandId,
           'name' => $dto->name,
           'description' => $description,
           'price' => $dto->price,
           'sales_price' => $dto->salesPrice,
           'dropship_price' => $dto->dropshippingPrice,
           'section_id' => $dto->sectionId,
           'link' => $dto->link,
           'stock' => $dto->stock,
            'date' => $date,
        ]);

//        Upload images
        $images = $dto->images;
        foreach ($images as $image) {
            $path = $image->store('products', 'public');
            ProductImage::create([
               'product_id' => $product->id,
               'image_path' => $path,
            ]);
        }

        return $product;
    }
}
