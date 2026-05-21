<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\ProductDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Revenue;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class AddProductAction
{
    /**
     * @throws Exception|Throwable
     */
    public static function execute(ProductDTO $dto): Product
    {
        $user = auth()->user();

        if (! $user || $user->role != UserType::BRAND) {
            throw new Exception('User not found.');
        }
        $brandId = auth()->user()->brand->id;

        // Check if user can add a new product
        if (! canAddProduct(auth()->user()->brand)) {
            throw new Exception('You have exceed the number of products you can add. Please upgrade.');
        }

        // Check if user has not exceeded the max amount of images they can add
        $images = $dto->images;
        if (count($images) > maxImages()) {
            throw new Exception('You cannot add more than '.maxImages().' images. Please upgrade to add more');
        }

        // create product
        if (! $dto->description) {
            $description = $dto->name;
        } else {
            $description = $dto->description;
        }

        $date = Carbon::now()->format('d F, Y');

        try {
            DB::beginTransaction();

            $product = Product::create([
                'brand_id' => $brandId,
                'name' => $dto->name,
                'description' => $description,
                'price' => $dto->price,
                'status' => Status::ACTIVE,
                'sales_price' => $dto->salesPrice,
                'dropship_price' => $dto->dropshippingPrice,
                'section_id' => $dto->sectionId,
                'link' => $dto->link,
                'stock' => $dto->stock,
                'date' => $date,
                'publish' => true,
            ]);

            // Upload images
            foreach ($images as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }

            DB::commit();
            return $product;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    /**
     * @throws Throwable
     */
    public static function increaseProduct(int $productNumber): Brand
    {
        $user = auth()->user();

        if (! $user || $user->role != UserType::BRAND) {
            throw new Exception('User not found.');
        }

        // Increase products
        try {
            DB::beginTransaction();

            $brand = Brand::where('id', auth()->user()->brand->id)->first();
            $additionalProducts = planDetails($brand->subscription_status);

            $newFee = $additionalProducts['additional_fee'] * $productNumber;
            $newProductNumber = $additionalProducts['additional_number'] * $productNumber;

            $new_subscription_amount = $brand->subscription_amount + $newFee;
            $new_no_of_products = $brand->no_of_products + $newProductNumber;

            $brand->update([
                'subscription_amount' => $new_subscription_amount,
                'no_of_products' => $new_no_of_products,
            ]);

            // Add Revenue
            Revenue::create([
                'user_id' => $user->id,
                'brand_id' => $brand->id,
                'amount' => $newFee,
                'description' => Status::INCREMENT,
                'subscription_status' => $brand->subscription_status,
            ]);

            DB::commit();

            return $brand;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Error: '.$e->getMessage());
        }
    }
}
