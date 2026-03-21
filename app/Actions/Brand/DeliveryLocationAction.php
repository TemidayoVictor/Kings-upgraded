<?php

namespace App\Actions\Brand;

use App\DTOs\Brand\DeliveryLocationDTO;
use App\Enums\UserType;
use App\Models\DeliveryLocation;
use Exception;

class DeliveryLocationAction
{
    /**
     * @throws Exception
     */
    public static function execute(DeliveryLocationDTO $dto): DeliveryLocation
    {
        $user = auth()->user();

        if (! $user || ($user->role != UserType::BRAND)) {
            throw new Exception('User not found.');
        }

        // create the delivery location
        return DeliveryLocation::create([
            'brand_id' => $dto->brandId,
            'name' => $dto->name,
            'delivery_price' => $dto->deliveryPrice ?? 0,
            'parent_id' => $dto->parentId,
            'level' => $dto->parentId ? DeliveryLocation::find($dto->parentId)->level + 1 : 0,
        ]);
    }

    public static function update(DeliveryLocationDTO $dto): DeliveryLocation
    {
        $user = auth()->user();

        if (! $user || ($user->role != UserType::BRAND)) {
            throw new Exception('User not found.');
        }

        $location = DeliveryLocation::findOrFail($dto->id);
        $location->update([
            'name' => $dto->name,
            'delivery_price' => $dto->deliveryPrice ?? 0,
            'parent_id' => $dto->parentId,
        ]);

        return $location;
    }

    /**
     * @throws Exception
     */
    public static function delete(DeliveryLocationDTO $dto): void
    {
        $user = auth()->user();

        if (! $user || ($user->role != UserType::BRAND)) {
            throw new Exception('User not found.');
        }

        $location = DeliveryLocation::findOrFail($dto->id);
        if ($location->children()->count() > 0) {
            throw new Exception('Cannot delete location with sub-locations. Delete sub-locations first.');
        }

        $location->delete();

    }
}
