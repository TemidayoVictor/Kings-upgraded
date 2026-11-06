<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\CatalogDTO;
use App\DTOs\Brand\ProductDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Brand;
use App\Models\CatalogItem;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
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
    public static function increaseProduct(int $productNumber, ?int $brandId = null): Payment
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

            // prepare payment
            $txRef = Str::uuid();
            $userId = auth()->user()->id;

            $payload = [
                'brand_id' => $brand->id,
                'subscription_amount' => $new_subscription_amount,
                'no_of_products' => $new_no_of_products,
                'description' => Status::INCREMENT,
                'subscription_status' => $brand->subscription_status,
            ];

            $payment = Payment::updateOrCreate(
                [
                    'user_id' => $userId,
                    'status' => Status::PENDING,
                ],
                [
                    'transaction_ref' => $txRef,
                    'amount' => $newFee,
                    'currency' => 'NGN',
                    'status' => Status::PENDING,
                    'action' => 'increase_products',
                    'payload' => $payload,
                ]
            );

            DB::commit();

            return $payment;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function addCatalog(CatalogDTO $dto): array
    {
        $user = auth()->user();

        if (! $user || $user->role != UserType::BRAND) {
            throw new Exception('You are not authorised to manage this catalog.');
        }

        $brand = $user->brand;

        if (! $brand || $brand->id !== $dto->brandId) {
            throw new Exception('Brand not found.');
        }

        $uploaded = 0;
        $skipped = $dto->skippedFiles;

        foreach ($dto->photos as $photo) {
            if (! $photo instanceof TemporaryUploadedFile) {
                $skipped++;

                continue;
            }

            $validator = Validator::make(
                ['photo' => $photo],
                [
                    'photo' => [
                        'required',
                        'image',
                        'mimes:jpg,jpeg,png,webp,gif',
                        'max:10240',
                    ],
                ]
            );

            if ($validator->fails()) {
                $skipped++;

                continue;
            }

            $path = null;

            try {
                $path = $photo->store('catalog', 'public');

                if (! $path) {
                    throw new \RuntimeException('Unable to store catalog image.');
                }

                DB::transaction(function () use ($brand, $photo, $path) {
                    CatalogItem::create([
                        'brand_id' => $brand->id,
                        'image_path' => $path,
                        'original_name' => mb_substr(
                            $photo->getClientOriginalName(),
                            0,
                            255
                        ),
                    ]);
                });

                $uploaded++;
            } catch (Throwable $exception) {
                // Remove the uploaded file if its database record could not be created.
                if ($path) {
                    Storage::disk('public')->delete($path);
                }

                report($exception);

                $skipped++;
            }
        }

        return [
            'uploaded' => $uploaded,
            'skipped' => $skipped,
        ];
    }

    /**
     * @throws Throwable
     */
    public static function deleteCatalog(CatalogDTO $dto): void
    {
        $user = auth()->user();

        if (! $user || $user->role != UserType::BRAND) {
            throw new Exception('You are not authorised to manage this catalog.');
        }

        $brand = $user->brand;

        if (! $brand || $brand->id !== $dto->brandId) {
            throw new Exception('Brand not found.');
        }

        $item = CatalogItem::where('brand_id', $brand->id)
            ->findOrFail($dto->catalogId);

        $path = $item->image_path;

        // Delete the database record first.
        DB::transaction(function () use ($item) {
            $item->delete();
        });

        // Remove the physical file after the database transaction succeeds.
        Storage::disk('public')->delete($path);
    }
}
