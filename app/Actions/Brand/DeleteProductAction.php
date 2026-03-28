<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\DeleteImageDTO;
use App\DTOs\GeneralDTO;
use App\Enums\UserType;
use App\Models\Product;
use Exception;

class DeleteProductAction
{
    /**
     * @throws Exception
     */
    public static function execute(GeneralDTO $dto): void
    {
        $user = auth()->user();

        if (! $user || ($user->role != UserType::BRAND)) {
            throw new Exception('User not found.');
        }
        //        get the product
        $product = Product::where('id', $dto->id)->with('images')->first();
        if (! $product) {
            throw new Exception('Product not found.');
        }

        //        delete images
        $images = $product->images;
        foreach ($images as $image) {
            $buildDto = [
                'productId' => $product->id,
                'imageId' => $image->id,
                'override' => true,
            ];
            try {
                $dto = DeleteImageDTO::fromArray($buildDto);
                DeleteImageAction::execute($dto);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        //        delete product
        $product->delete();
    }
}
