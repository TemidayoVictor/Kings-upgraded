<?php

namespace App\Livewire\Dropshipper;

use App\Models\DropshipperStore;
use App\Models\OrderBatch;
use Illuminate\View\View;
use Livewire\Component;

class BatchedOrder extends Component
{
    public ?DropshipperStore $store = null;

    public int $perPage = 20;

    public function mount($store): void
    {
        $this->store = $store;
    }

    public function render(): View
    {
        $batches = OrderBatch::where('dropshipper_store_id', $this->store->id)->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.dropshipper.batched-order', [
            'batches' => $batches,
        ])->layout('layouts.auth')
            ->title('Batched Orders');
    }
}
