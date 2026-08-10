<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\DropshipperEarning;
use App\Models\OrderBatch;
use Illuminate\Support\Collection;

class OrderBatchService
{
    public function createBatch(int $dropshipperStoreId, Collection $orders): ?OrderBatch
    {
        if ($orders->isEmpty()) {
            return null;
        }

        $batch = OrderBatch::create([
            'dropshipper_store_id' => $dropshipperStoreId,
            'orders' => $orders->count(),
            'amount' => $orders->sum('total'),
            'dropshipper_amount' => $orders->sum('total') - $orders->sum('dropshipper_profit'),
        ]);

        foreach ($orders as $order) {
            $order->update([
                'dropshipper_status' => Status::APPROVED,
                'order_batch_id' => $batch->id,
            ]);

            DropshipperEarning::create([
                'dropshipper_store_id' => $dropshipperStoreId,
                'order_id' => $order->id,
                'amount' => $order->dropshipper_profit,
            ]);
        }

        return $batch;
    }
}
