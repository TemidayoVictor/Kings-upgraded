<?php

namespace App\Livewire\Brand\Orders;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public string $paymentFilter = '';

    public int $totalOrders = 0;

    public int $pendingOrders = 0;

    public int $processingOrders = 0;

    public int $completedOrders = 0;

    public int $selectedOrders = 0;

    public bool $showStatusFilter = false;

    public bool $showPaymentFilter = false;

    public string $viewMode = 'list';

    protected $queryString = ['search', 'statusFilter', 'paymentFilter'];

    public function mount(): void
    {
        $this->loadStats();
    }

    public function loadStats(): void
    {
        $query = $this->getBaseQuery();

        $this->totalOrders = $query->count();
        $this->pendingOrders = $query->clone()->where('status', 'pending')->count();
        $this->processingOrders = $query->clone()->where('status', 'processing')->count();
        $this->completedOrders = $query->clone()->where('status', 'delivered')->count();
    }

    private function getBaseQuery()
    {
        $user = Auth::user();
        return Order::where('brand_id', $user->brand->id);
    }

    public function getOrdersProperty()
    {
        $query = $this->getBaseQuery();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%'.$this->search.'%')
                    ->orWhere('customer_name', 'like', '%'.$this->search.'%')
                    ->orWhere('customer_phone', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->paymentFilter) {
            $query->where('payment_status', $this->paymentFilter);
        }

        return $query->with(['items'])->orderBy('created_at', 'desc')->paginate(15);
    }

    public function viewOrder($orderId): RedirectResponse
    {
        return redirect()->route('orders.show', $orderId);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->paymentFilter = '';
        $this->loadStats();
    }

    public function render(): View
    {
        return view('livewire.brand.orders.index', [
            'orders' => $this->orders,
        ])->layout('layouts.auth')
            ->title('Orders');
    }
}
