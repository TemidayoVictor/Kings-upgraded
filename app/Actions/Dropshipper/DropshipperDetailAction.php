<?php

namespace App\Actions\Dropshipper;

use App\DTOs\Dropshipper\DropshipperDetailsDTO;
use App\Enums\Status;
use App\Models\Dropshipper;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;

class DropshipperDetailAction
{
    /**
     * @throws Exception
     */
    public static function execute(DropshipperDetailsDTO $dto): User
    {
        $user = auth()->user();
        if (! $user) {
            throw new Exception('User not found.');
        }

        $dropshipper = Dropshipper::where('user_id', $user->id)->first();
        if (! $dropshipper) {
            throw new Exception('Brand not found.');
        }

        // Check if slug already exists for another user
        $check = Dropshipper::where('username', $dto->useranme)->first();
        if ($check && $check->id != $dropshipper->id) {
            throw new Exception('Please choose another username.');
        }

        $path = null;
        $image = $dto->logo;
        if (! empty($image)) {
            $path = $image->store('images', 'public');
            // logo has been updated
            if (! empty($dropshipper->image) && Storage::disk('public')->exists($dropshipper->image)) {
                //                delete previous logo
                Storage::disk('public')->delete($dropshipper->image);
            }

        } elseif (! empty($dropshipper->image)) {
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
            'onboarding_step' => Status::COMPLETED,
        ]);

        return $user;
    }
}
