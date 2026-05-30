<?php

namespace App\Actions;

use App\DTOs\GeneralDTO;
use App\Models\Rating;
use Exception;

class RatingAction
{
    /**
     * @throws Exception
     */
    public static function execute(GeneralDTO $dto): Rating
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        // Performs an atomic update-or-create call protecting structural integrity
        $rating = Rating::updateOrCreate(
            ['brand_id' => $dto->value['brand_id'], 'user_id' => auth()->id()],
            ['rating' => $dto->value['rating'], 'review' => $dto->value['review']]
        );

        return $rating;

    }
}
