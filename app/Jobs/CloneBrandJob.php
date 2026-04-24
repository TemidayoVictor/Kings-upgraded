<?php

// app/Jobs/CloneBrandJob.php

namespace App\Jobs;

use App\Models\DropshipperStore;
use App\Services\StoreCloningService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CloneBrandJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 600;

    public int $tries = 3;

    protected DropshipperStore $store;

    public function __construct(DropshipperStore $store)
    {
        $this->store = $store;
    }

    public function handle(StoreCloningService $cloningService): void
    {
        try {
            // Update status to processing
            $this->updateStatus('processing', 0);

            // Call the service to do the actual cloning
            $result = $cloningService->cloneBrand($this->store);

            if ($result['success']) {
                Log::info('Store cloned successfully', [
                    'store_id' => $this->store->id,
                    'stats' => $result['stats'],
                ]);
            } else {
                throw new \Exception($result['message']);
            }

        } catch (\Exception $e) {
            // Update status to failed
            $this->updateStatus('failed', 0, $e->getMessage());

            Log::error('Clone job failed', [
                'store_id' => $this->store->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    private function updateStatus(string $status, int $percentage = 0, ?string $error = null): void
    {
        $stats = $this->store->settings['clone_stats'] ?? [];

        $this->store->update([
            'settings' => array_merge($this->store->settings ?? [], [
                'clone_stats' => array_merge($stats, [
                    'status' => $status,
                    'percentage' => $percentage,
                    'error' => $error,
                    'updated_at' => now()->toDateTimeString(),
                ]),
            ]),
        ]);
    }
}
