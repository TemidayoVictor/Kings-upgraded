<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\ProductDTO;
use App\DTOs\GeneralDTO;
use App\Enums\UserType;
use App\Models\DropshipperProduct;
use App\Models\Product;
use App\Models\ProductImage;
use Exception;

class EditProductAction
{
    public static function execute(ProductDTO $dto): Product
    {
        $user = auth()->user();

        if (! $user || $user->role != UserType::BRAND) {
            throw new Exception('User not found.');
        }
        $brandId = auth()->user()->brand->id;
        // create product
        if (! $dto->description) {
            $description = $dto->name;
        } else {
            $description = $dto->description;
        }

        $product = Product::where('id', $dto->productId)->with('images')->first();
        if (! $product) {
            throw new Exception('Product not found.');
        }

        $previousImagesCount = $product->images->count();
        $newImagesCount = 0;
        $images = [];
        if (! empty($dto->images)) {
            $images = $dto->images;
            $newImagesCount = count($images);
        }

        if ($previousImagesCount + $newImagesCount > 5) {
            throw new Exception('You can only add a total of 5 images.');
        }

        $product->update([
            'name' => $dto->name,
            'description' => $description,
            'price' => $dto->price,
            'sales_price' => $dto->salesPrice,
            'dropship_price' => $dto->dropshippingPrice,
            'section_id' => $dto->sectionId,
            'link' => $dto->link,
            'stock' => $dto->stock,
        ]);

        //        Upload images
        if ($newImagesCount > 0) {
            foreach ($images as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return $product;
    }

    /**
     * @throws Exception
     */
    public static function editPrice(GeneralDTO $dto): DropshipperProduct
    {
        $user = auth()->user();

        if (! $user || $user->role != UserType::DROPSHIPPER) {
            throw new Exception('User not found.');
        }

        $product = DropshipperProduct::find($dto->id);
        if (! $product) {
            throw new Exception('Product not found.');
        }

        $product->update([
            'custom_price' => $dto->value['custom_price'],
            'profit' => $dto->value['profit'],
        ]);

        return $product;
    }
}
