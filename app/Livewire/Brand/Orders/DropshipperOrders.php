<?php

namespace App\Livewire\Brand\Orders;

use App\Models\OrderBatch;
use Illuminate\View\View;
use Livewire\Component;

class DropshipperOrders extends Component
{
    public int $perPage = 20;

    public function render(): View
    {
        $brandId = auth()->user()->brand->id;
        $batches = OrderBatch::whereHas('dropshipperStore', function ($query) use ($brandId) {
            $query->where('brand_id', $brandId);
        })->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.brand.orders.dropshipper-orders', [
            'batches' => $batches,
        ])->layout('layouts.auth')
            ->title('Batched Orders');
    }
}
