<?php

namespace App\Jobs;

use App\Enums\Status;
use App\Mail\SubscriptionExpiryMail;
use App\Models\Brand;
use App\Models\Dropshipper;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionExpiryJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $today = Carbon::today();
        $expiryLimit = $today->copy()->addDays(5);
        Log::info('Running subscription expiry job');

        Brand::query()
            ->whereDate('exp_date', '>=', $today)
            ->whereDate('exp_date', '<=', $expiryLimit)
            ->where('subscription_status', '!=', Status::BASIC)
            ->with('user')
            ->chunkById(500, function ($brands) {

                foreach ($brands as $brand) {
                    $emailData = [
                        'name' => $brand->user->name,
                        'subject' => "KING'S Subscription Expiry Notice",
                        'expiry' => $brand->exp_date->format('F d, Y'),
                        'type' => 'brand',
                        'plan' => $brand->subscription_status,
                        'url' => route('brand-subscription-status'),
                    ];
                    Mail::to($brand->user->email)->send(new SubscriptionExpiryMail($emailData));
                }
            });

        Dropshipper::query()
            ->where('subscription_type', Status::MONTHLY)
            ->whereDate('exp_date', '>=', $today)
            ->whereDate('exp_date', '<=', $expiryLimit)
            ->with('user')
            ->chunkById(500, function ($dropshippers) {
                foreach ($dropshippers as $dropshipper) {
                    $emailData = [
                        'name' => $dropshipper->user->name,
                        'subject' => "KING'S Subscription Expiry Notice",
                        'expiry' => $dropshipper->exp_date->format('F d, Y'),
                        'type' => 'dropshipper',
                        'url' => route('dropshipper-subscriptions'),
                    ];
                    Mail::to($dropshipper->user->email)->send(new SubscriptionExpiryMail($emailData));
                }
            });
    }
}
