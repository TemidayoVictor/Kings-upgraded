<?php

namespace App\Actions\Dropshipper;

use App\DTOs\Dropshipper\CloneStoreDTO;
use App\DTOs\GeneralDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Jobs\CloneBrandJob;
use App\Models\Dropshipper;
use App\Models\DropshipperProduct;
use App\Models\DropshipperStore;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class CloneStoreAction
{
    /**
     * @throws Exception
     * @throws Throwable
     */
    public static function execute(CloneStoreDTO $dto): DropshipperStore
    {
        $user = auth()->user();
        if (! $user) {
            throw new Exception('User not found.');
        }

        $dropshipper = Dropshipper::where('user_id', $user->id)->first();
        if (! $dropshipper) {
            throw new Exception('Dropshipper not found.');
        }

        DB::beginTransaction();
        try {
            // Get total products for initial stats
            $totalProducts = Product::where('brand_id', $dto->brandId)->count();

            $store = DropshipperStore::create([
                'dropshipper_id' => auth()->user()->dropshipper->id,
                'brand_id' => $dto->brandId,
                'store_name' => $dto->storeName,
                'slug' => $dto->storeSlug,
                'settings' => [
                    'theme' => $dto->settings['theme'],
                    'layout' => $dto->settings['layout'],
                    'created_from_brand' => $dto->brandName,
                    'created_at' => now()->toDateTimeString(),
                    'clone_stats' => [
                        'total_products' => $totalProducts,
                        'cloned_products' => 0,
                        'percentage' => 0,
                        'status' => Status::PENDING,
                        'updated_at' => now()->toDateTimeString(),
                    ],
                ],
                'status' => Status::ACTIVE,
            ]);

            DB::commit();
            CloneBrandJob::dispatch($store);

            return $store;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to create store: {$e->getMessage()}");
        }
    }

    /**
     * @throws Exception
     */
    public static function editStore(GeneralDTO $dto): DropshipperStore
    {
        $user = auth()->user();

        if (! $user || $user->role != UserType::DROPSHIPPER) {
            throw new Exception('User not found.');
        }

        $store = DropshipperStore::find($dto->id);
        if (! $store) {
            throw new Exception('Store not found.');
        }

        $store->update([
            'store_name' => $dto->value['store_name'],
            'slug' => $dto->value['slug'],
        ]);

        return $store;
    }

    /**
     * @throws Exception
     */
    public static function updateNewProducts(int $id): DropshipperStore
    {
        $user = auth()->user();

        if (! $user || $user->role != UserType::DROPSHIPPER) {
            throw new Exception('User not found.');
        }

        $store = DropshipperStore::find($id);
        if (! $store) {
            throw new Exception('Store not found.');
        }

        $newProducts = Product::query()
            ->where('brand_id', $store->brand_id)
            ->where('status', Status::ACTIVE)
            ->whereDoesntHave('dropshipperProducts', function ($query) use ($store) {
                $query->where('dropshipper_store_id', $store->id);
            })
            ->get();

        foreach ($newProducts as $product) {
            $exists = DropshipperProduct::where('dropshipper_store_id', $store->id)
                ->where('original_product_id', $product->id)
                ->exists();

            if (! $exists) {
                DropshipperProduct::create([
                    'dropshipper_store_id' => $store->id,
                    'original_product_id' => $product->id,
                    'custom_price' => $product->price,
                    'profit' => $product->price - $product->dropship_price,
                    'stock_override' => null,
                    'custom_settings' => json_encode([
                        'cloned_at' => now()->toDateTimeString(),
                        'original_created_at' => $product->created_at,
                        'original_updated_at' => $product->updated_at,
                    ]),
                ]);
            }
        }

        return $store;
    }
}
