<?php

// app/Livewire/Checkout/Success.php

namespace App\Livewire\Checkout;

use App\Models\Order;
use Livewire\Component;

class Success extends Component
{
    public Order $order;

    public function mount($orderId)
    {
        $this->order = Order::with(['items', 'deliveryLocation'])
            ->where('id', $orderId)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('customer_email', auth()->user()->email ?? '');
            })
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.checkout.success')->layout('layouts.shop');
    }
}
