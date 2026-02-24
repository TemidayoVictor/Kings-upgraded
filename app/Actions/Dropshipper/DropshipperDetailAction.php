<?php

namespace App\Actions\Dropshipper;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Dropshipper;
use App\Enums\UserType;
use App\Enums\Status;
use App\DTOs\Dropshipper\DropshipperDetailsDTO;

class DropshipperDetailAction
{
    public static function execute(DropshipperDetailsDTO $dto): User
    {
        $user = auth()->user();
        if (!$user) {
            throw new \Exception('User not found.');
        }

        $dropshipper = Dropshipper::where('user_id', $user->id)->first();
        if (!$dropshipper) {
            throw new \Exception('Brand not found.');
        }

        $path = null;
        $image = $dto->logo;
        if(!empty($image))
        {
            $path = $image->store('images', 'public');
            // logo has been updated
            if(!empty($dropshipper->image) && Storage::disk('public')->exists($dropshipper->image))
            {
//                delete previous logo
                Storage::disk('public')->delete($dropshipper->image);
            }

        } elseif(!empty($dropshipper->image)) {
            $path = $dropshipper->image;
        }

        $dropshipper->update([
            'image' => $path,
            'username' => $dto->username,
            'account_name' => $dto->accountName,
            'account_number' => $dto->accountNumber,
            'bank_name' => $dto->bankName,
            'status' => Status::COMPLETED,
        ]);

        $user->update([
            'onboarding_step' => Status::COMPLETED
        ]);

        return $user;
    }
}
