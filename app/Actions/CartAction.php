<?php

namespace App\Actions;

use App\DTOs\CartDTO;
use App\Enums\UserType;
use App\Models\DropshipperProduct;
use App\Models\Product;
use App\Services\CartService;
use App\Services\DropshipperCartService;
use Exception;

class CartAction
{
    /**
     * @throws Exception
     */
    public static function execute(CartDTO $dto): array
    {
        try {
            $type = $dto->type;
            if ($type == UserType::DROPSHIPPER) {
                // Verify product belongs to this store
                $product = DropshipperProduct::with('originalProduct')
                    ->where('id', $dto->productId)
                    ->where('dropshipper_store_id', $dto->storeId)
                    ->whereHas('originalProduct', function ($q) {
                        $q->where('is_active', true)
                            ->where('publish', true);
                    })
                    ->firstOrFail();

                if (! $product) {
                    throw new \Exception('Product not found.');
                }

                $productName = $product->originalProduct->name;
                $cartBag = new DropshipperCartService($dto->storeId, $dto->stockAlert);
            } else {
                // Verify product belongs to this brand
                $product = Product::where('id', $dto->productId)
                    ->where('brand_id', $dto->brandId)
                    ->first();

                if (! $product) {
                    throw new \Exception('Product not found.');
                }

                $productName = $product->name;
                $cartBag = new CartService($dto->brandId, $dto->stockAlert);
            }
            $cartBag->addItem($dto->productId, $dto->quantity);

            return [
                'cartBag' => $cartBag,
                'productName' => $productName,
            ];

        } catch (\Exception $e) {
            throw new Exception('Failed to add to cart: '.$e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function updateQuantity(CartDTO $dto): void
    {
        try {
            $type = $dto->type;
            if ($type == UserType::DROPSHIPPER) {
                $cartService = new DropshipperCartService($dto->storeId, $dto->stockAlert);
            } else {
                $cartService = new CartService($dto->brandId, $dto->stockAlert);
            }
            $cartService->updateItem($dto->productId, $dto->quantity);
        } catch (\Exception $e) {
            throw new Exception('Failed to update cart: '.$e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function removeItem(CartDTO $dto): void
    {
        try {
            $type = $dto->type;
            if ($type == UserType::DROPSHIPPER) {
                $cartService = new DropshipperCartService($dto->storeId, $dto->stockAlert);
            } else {
                $cartService = new CartService($dto->brandId, $dto->stockAlert);
            }
            $cartService->removeItem($dto->productId);
        } catch (\Exception $e) {
            throw new Exception('Failed to remove item: '.$e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function applyCoupon(CartDTO $dto): array
    {
        try {
            $cartService = new CartService($dto->brandId, $dto->stockAlert);

            return $cartService->applyCoupon($dto->couponCode);
        } catch (\Exception $e) {
            throw new Exception('Failed to add apply coupon: '.$e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function removeCoupon(CartDTO $dto): void
    {
        try {
            $cartService = new CartService($dto->brandId, $dto->stockAlert);
            $cartService->removeCoupon();
        } catch (\Exception $e) {
            throw new Exception('Failed to remove coupon: '.$e->getMessage());
        }
    }
}
