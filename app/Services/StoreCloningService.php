<?php

// app/Services/StoreCloningService.php

namespace App\Services;

use App\Enums\Status;
use App\Models\Brand;
use App\Models\DropshipperProduct;
use App\Models\DropshipperStore;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreCloningService
{
    /**
     * Clone an entire brand to a dropshipper store
     */
    public function cloneBrand(DropshipperStore $store, array $options = []): array
    {
        $brand = $store->brand;
        $batchSize = $options['batch_size'] ?? 100;

        $stats = [
            'total_products' => 0,
            'cloned_products' => 0,
            'skipped_products' => 0,
            'failed_products' => 0,
            'errors' => [],
            'status' => 'processing',
            'percentage' => 0,
        ];

        try {
            DB::beginTransaction();

            // Clone brand settings
            $this->cloneSettings($store, $brand, $options);

            // Get total products for progress calculation
            $totalProducts = Product::where('brand_id', $brand->id)->count();
            $processedCount = 0;

            // Clone products in chunks
            Product::where('brand_id', $brand->id)
                ->chunk($batchSize, function (Collection $products) use ($store, &$stats, &$processedCount, $totalProducts) {
                    foreach ($products as $product) {
                        $result = $this->cloneProduct($store, $product);

                        $stats['total_products']++;
                        $processedCount++;

                        if ($result['success']) {
                            $stats['cloned_products']++;
                        } elseif ($result['skipped']) {
                            $stats['skipped_products']++;
                        } else {
                            $stats['failed_products']++;
                            if ($result['error']) {
                                $stats['errors'][] = $result['error'];
                            }
                        }

                        // Update progress percentage every 5 products for smoother updates
                        if ($processedCount % 5 === 0 || $processedCount === $totalProducts) {
                            $stats['percentage'] = $totalProducts > 0
                                ? round(($processedCount / $totalProducts) * 100, 2)
                                : 100;

                            // Update store with progress
                            $store->update([
                                'settings' => array_merge($store->settings ?? [], [
                                    'clone_stats' => $stats,
                                ]),
                            ]);
                        }
                    }
                });

            // Final stats
            $stats['percentage'] = 100;
            $stats['status'] = 'completed';

            // Update store with cloning metadata
            $store->update([
                'settings' => array_merge($store->settings ?? [], [
                    'cloned_at' => now()->toDateTimeString(),
                    'cloned_from_brand' => $brand->id,
                    'clone_stats' => $stats,
                ]),
                'status' => Status::CLONED,
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Brand cloned successfully',
                'stats' => $stats,
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            $stats['status'] = 'failed';
            $stats['error'] = $e->getMessage();

            $store->update([
                'settings' => array_merge($store->settings ?? [], [
                    'clone_stats' => $stats,
                ]),
            ]);

            Log::error('Store cloning failed', [
                'store_id' => $store->id,
                'brand_id' => $brand->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to clone brand: '.$e->getMessage(),
                'stats' => $stats,
            ];
        }
    }

    /**
     * Clone a single product
     */
    protected function cloneProduct(DropshipperStore $store, Product $product): array
    {
        try {
            // Check if product already exists in store
            $exists = DropshipperProduct::where('dropshipper_store_id', $store->id)
                ->where('original_product_id', $product->id)
                ->exists();

            if ($exists) {
                return [
                    'success' => false,
                    'skipped' => true,
                    'error' => null,
                ];
            }

            // Determine the price to use
            $price = $product->dropship_price ?? $product->price;

            // Create the dropshipper product
            DropshipperProduct::create([
                'dropshipper_store_id' => $store->id,
                'original_product_id' => $product->id,
                'custom_price' => $price,
                'stock_override' => null,
                'custom_settings' => json_encode([
                    'cloned_at' => now()->toDateTimeString(),
                    'original_created_at' => $product->created_at,
                    'original_updated_at' => $product->updated_at,
                ]),
            ]);

            return [
                'success' => true,
                'skipped' => false,
                'error' => null,
            ];

        } catch (\Exception $e) {
            Log::warning('Failed to clone product', [
                'store_id' => $store->id,
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'skipped' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Clone brand settings to store
     */
    protected function cloneSettings(DropshipperStore $store, Brand $brand, array $options = []): void
    {
        $settings = [
            'theme' => $options['theme'] ?? 'default',
            'layout' => $options['layout'] ?? 'standard',
            'currency' => $options['currency'] ?? 'USD',
            'tax_settings' => $options['tax_settings'] ?? [
                'inclusive' => false,
                'rate' => 0,
            ],
            'shipping_settings' => $options['shipping_settings'] ?? [
                'free_shipping_threshold' => 50,
                'shipping_rate' => 5.99,
            ],
            'payment_settings' => $options['payment_settings'] ?? [
                'methods' => ['card', 'bank_transfer'],
            ],
            'brand_info' => [
                'name' => $brand->brand_name,
                'category' => $brand->category,
                'description' => $brand->description,
            ],
        ];

        // Merge with existing settings
        $store->settings = array_merge($store->settings ?? [], $settings);
        $store->save();
    }

    /**
     * Get clone progress for a store
     */
    public function getCloneProgress(DropshipperStore $store): array
    {
        // First check if we have stats in settings (from ongoing clone)
        $settings = $store->settings ?? [];
        $stats = $settings['clone_stats'] ?? [];

        if (! empty($stats) && isset($stats['percentage'])) {
            return [
                'total' => $stats['total_products'] ?? 0,
                'cloned' => $stats['cloned_products'] ?? 0,
                'percentage' => $stats['percentage'] ?? 0,
                'remaining' => ($stats['total_products'] ?? 0) - ($stats['cloned_products'] ?? 0),
                'is_complete' => ($stats['status'] ?? '') === 'completed',
                'status' => $stats['status'] ?? 'unknown',
                'errors' => $stats['errors'] ?? [],
            ];
        }

        // Fallback to database counts
        $totalProducts = Product::where('brand_id', $store->brand_id)->count();
        $clonedProducts = DropshipperProduct::where('dropshipper_store_id', $store->id)->count();

        $percentage = $totalProducts > 0
            ? round(($clonedProducts / $totalProducts) * 100, 2)
            : 100;

        return [
            'total' => $totalProducts,
            'cloned' => $clonedProducts,
            'percentage' => $percentage,
            'remaining' => $totalProducts - $clonedProducts,
            'is_complete' => $clonedProducts >= $totalProducts || $store->status == Status::CLONED,
            'status' => $store->status == Status::CLONED ? 'completed' : 'processing',
            'errors' => [],
        ];
    }
}
