<?php

// app/Livewire/Checkout/Success.php

namespace App\Livewire\Checkout;

use App\Models\Brand;
use App\Models\Order;
use Livewire\Component;

class Success extends Component
{
    public Order $order;

    public Brand $brand;

    public function mount($order): void
    {
        $this->order = Order::with(['items', 'deliveryLocation'])
            ->where('id', $order->id)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('customer_email', auth()->user()->email ?? '');
            })
            ->firstOrFail();

        $this->brand = $this->order->brand;
    }

    public function render()
    {
        return view('livewire.checkout.success')->layout('layouts.shop', [
            'brand' => $this->brand,
        ]);
    }
}
