<?php

namespace App\Actions\Brand;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\DTOs\Brand\AdditionalDetailsDTO;

use App\Models\User;
use App\Models\Brand;

class AdditionalDetailsActions
{
    public static function execute(AdditionalDetailsDTO $dto): User
    {
        $user = auth()->user();
        if (!$user) {
            throw new \Exception('User not found.');
        }

        $brand = Brand::where('user_id', $user->id)->first();
        if (!$brand) {
            throw new \Exception('Brand not found.');
        }

        $path = null;
        $image = $dto->logo;
        if(!empty($image))
        {
            $path = $image->store('images', 'public');
            // logo has been updated
            if(!empty($brand->image) && Storage::disk('public')->exists($brand->image))
            {
//                delete previous logo
                Storage::disk('public')->delete($brand->image);
            }

        } elseif(!empty($brand->image)) {
            $path = $brand->image;
        }

        $brand->update([
            'image' => $path,
            'about' => $dto->about,
            'motto' => $dto->motto,
            'instagram' => $dto->instagram,
            'facebook' => $dto->facebook,
            'twitter' => $dto->twitter,
            'youtube' => $dto->youtube,
            'tiktok' => $dto->tiktok,
            'linkedin' => $dto->linkedin,
            'website' => $dto->website,
        ]);

        return $user;
    }
}
