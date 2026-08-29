<?php

// app/Livewire/Checkout/Success.php

namespace App\Livewire\Checkout;

use App\Models\Brand;
use App\Models\Dropshipper;
use App\Models\DropshipperStore;
use App\Models\Order;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use Livewire\Component;

class Success extends Component
{
    public Order $order;

    public Brand $brand;

    public DropshipperStore $store;

    public string $whatsappNumber;

    public string $link;

    public string $accountNumber;
    public string $accountName;
    public string $bank;

    public function mount($orderId): void
    {
        $orderId = Crypt::decryptString(urldecode($orderId));
        $this->order = Order::with(['items', 'deliveryLocation'])
            ->where('id', $orderId)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('customer_email', auth()->user()->email ?? '');
            })
            ->firstOrFail();

        if ($this->order->dropshipper_store_id) {
            // This order belongs to a dropshipper
            $this->store = $this->order->store;
            $this->accountName = $this->order->store->dropshipper->account_name;
            $this->accountNumber = $this->order->store->dropshipper->account_number;
            $this->bank = $this->order->store->dropshipper->bank_name;
            $phone = $this->order->store->dropshipper->user->phone;
        } else {
            $this->brand = $this->order->brand;
            $this->accountName = $this->brand->account_name;
            $this->accountNumber = $this->brand->account_number;
            $this->bank = $this->brand->bank_name;
            $phone = $this->brand->user->phone;
        }

        $this->whatsappNumber = '234'.ltrim($phone, '0');
        $this->link = route('checkout.success', [
            'orderId' => urlencode(Crypt::encryptString((string) $this->order->id)),
        ]);
    }

    public function render(): View
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
