<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\ProductDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Revenue;
use App\Models\Subcategory;
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

            if (! $dto->dropshippingPrice || ! $dto->dropshippingPrice == 0) {
                $dropshippingPrice = $dto->price;
            } else {
                $dropshippingPrice = $dto->dropshippingPrice;
            }

            if (! $dto->salesPrice || ! $dto->salesPrice == 0) {
                $salesPrice = $dto->price;
            } else {
                $salesPrice = $dto->salesPrice;
            }

            $product = Product::create([
                'brand_id' => $brandId,
                'name' => $dto->name,
                'description' => $description,
                'price' => $dto->price,
                'status' => Status::ACTIVE,
                'sales_price' => $salesPrice,
                'dropship_price' => $dropshippingPrice,
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

            //            // Update category and subcategory counts
            //            $category = Category::where()->first('category', $user->brand->category)->first();
            //            if ($category) {
            //                $currentProducts = $category->products;
            //                $category->update([
            //                    'products' => $currentProducts + 1,
            //                ]);
            //            }
            //
            //            $subcategory = Subcategory::where()->first('subcategory', $user->brand->sub_category)->first();
            //            if ($subcategory) {
            //                $currentProducts = $subcategory->products;
            //                $subcategory->update([
            //                    'products' => $currentProducts + 1,
            //                ]);
            //            }

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
    public static function increaseProduct(int $productNumber, ?int $brandId = null): Brand
    {
        $user = auth()->user();
        if ($brandId) {
            // request is from admin
            if (! $user || $user->role != UserType::ADMIN) {
                throw new Exception('User not found.');
            }
            $brand = Brand::where('id', $brandId)->first();
        } else {
            if (! $user || $user->role != UserType::BRAND) {
                throw new Exception('User not found.');
            }
            $brand = $user->brand;
        }

        // Increase products
        try {
            DB::beginTransaction();
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
