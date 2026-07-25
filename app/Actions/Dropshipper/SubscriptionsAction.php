<?php

namespace App\Actions\Dropshipper;

use App\Enums\Status;
use App\Models\Dropshipper;
use App\Models\Revenue;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class SubscriptionsAction
{
    /**
     * @throws Exception
     * @throws Throwable
     */
    public static function execute(string $type, ?int $id = null): User
    {
        $user = auth()->user();
        if (! $user) {
            throw new Exception('User not found.');
        }

        $dropshipper = $user->dropshipper;
        if (! $dropshipper) {
            if (! $id) {
                throw new Exception('Dropshipper not found.');
            }
            $dropshipper = Dropshipper::findOrFail($id);
        }

        if ($dropshipper->last_subscription_type_update && $dropshipper->last_subscription_type_update->diffInDays(now()) < 30) {
            throw new Exception('Your subscription type can only be changed once every 30 days.');
        }

        try {
            DB::beginTransaction();

            $data = [
                'subscription_type' => $type,
                'last_subscription_type_update' => now(),
            ];

            if ($type === Status::COMMISSION) {
                $data['exp_date'] = null;
            } else {
                $data['exp_date'] = now();
            }

            $dropshipper->update($data);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to create store: {$e->getMessage()}");
        }
    }

    public static function renew(int $month, ?int $id = null): User
    {
        $user = auth()->user();
        if (! $user) {
            throw new Exception('User not found.');
        }

        $dropshipper = $user->dropshipper;
        if (! $dropshipper) {
            if (! $id) {
                throw new Exception('Dropshipper not found.');
            }
            $dropshipper = Dropshipper::findOrFail($id);
        }

        try {
            DB::beginTransaction();

            $currentExpiry = $dropshipper->exp_date;
            // If subscription is still active, extend from current expiry
            if ($currentExpiry && Carbon::parse($currentExpiry)->isFuture()) {
                $newExpiry = Carbon::parse($currentExpiry)->addMonth($month);
            } else {
                // If expired or null, start from now
                $newExpiry = now()->addMonth($month);
            }

            $dropshipper->update([
                'exp_date' => $newExpiry,
            ]);

            $amount = generalSetting()->dropshipper_fee * $month;

            // Add Revenue
            Revenue::create([
                'user_id' => $user->id,
                'dropshipper_id' => $dropshipper->id,
                'amount' => $amount,
                'description' => Status::RENEWAL,
                'subscription_status' => 'Renewal for '.$month.' month(s)',
            ]);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to create store: {$e->getMessage()}");
        }
    }
}
