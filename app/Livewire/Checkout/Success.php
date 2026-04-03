<?php

// app/Livewire/Checkout/Success.php

namespace App\Livewire\Checkout;

use App\Models\Brand;
use App\Models\Dropshipper;
use App\Models\DropshipperStore;
use App\Models\Order;
use Livewire\Component;

class Success extends Component
{
    public Order $order;

    public Brand $brand;

    public DropshipperStore $store;

    public function mount($order): void
    {
        $this->order = Order::with(['items', 'deliveryLocation'])
            ->where('id', $order->id)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('customer_email', auth()->user()->email ?? '');
            })
            ->firstOrFail();

        if ($this->order->dropshipper_store_id) {
            // This order belongs to a dropshipper
            $this->store = $this->order->store;
        } else {
            $this->brand = $this->order->brand;
        }

    }

    public function render()
    {
        if ($this->order->dropshipper_store_id) {
            return view('livewire.checkout.success')->layout('layouts.store', [
                'store' => $this->store,
            ]);
        } else {
            return view('livewire.checkout.success')->layout('layouts.shop', [
                'brand' => $this->brand,
            ]);
        }
    }
}
