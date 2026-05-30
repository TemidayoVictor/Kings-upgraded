<?php

namespace App\Livewire\Shop;

use App\Enums\Status;
use App\Models\Brand;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;

class Orders extends Component
{
    public Brand $brand;

    // Modal states
    public bool $showOrderModal = false;

    public ?Order $selectedOrder = null;

    // Stats
    public int $totalOrders = 0;

    public int $totalRevenue = 0;

    public int $pendingOrders = 0;

    public int $avgOrderValue = 0;

    public function mount(Brand $brand): void
    {
        $this->calculateStats();
        $this->brand = $brand;
    }

    public function getOrdersProperty(): LengthAwarePaginator
    {
        $query = $this->getBaseQuery();

        return $query->with(['items'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    private function getBaseQuery(): Builder
    {
        $user = auth()->user();

        return Order::where('user_id', $user->id)->where('brand_id', $this->brand->id);
    }

    private function calculateStats(): void
    {
        $currentQuery = $this->getBaseQuery();

        $this->totalOrders = $currentQuery->count();
        $this->totalRevenue = $this->getRevenue($currentQuery);
        $this->pendingOrders = $currentQuery->where('status', 'pending')->count();

        $this->avgOrderValue = $this->totalOrders > 0 ? $this->totalRevenue / $this->totalOrders : 0;

    }

    private function getRevenue($query): float
    {
        return (clone $query)
            ->selectRaw('
            SUM(
                CASE
                    WHEN dropshipper_store_id IS NULL THEN total
                    WHEN dropshipper_store_id IS NOT NULL AND dropshipper_status = "approved" THEN total - dropshipper_profit
                    ELSE 0
                END
            ) as revenue
        ')
            ->value('revenue') ?? 0;
    }

    public function viewOrder($orderId): void
    {
        $this->selectedOrder = Order::with('items')->findOrFail($orderId);
        if ($this->selectedOrder->dropshipper_store_id !== null && $this->selectedOrder->dropshipper_status != Status::APPROVED) {
            $this->showOrderModal = false;
        } else {
            $this->showOrderModal = true;
        }
    }

    public function closeOrderModal(): void
    {
        $this->showOrderModal = false;
        $this->selectedOrder = null;
    }

    public function render(): View
    {
        return view('livewire.shop.orders', [
            'orders' => $this->orders,
        ])->layout('layouts.shop', [
            'brand' => $this->brand,
        ])->title('Orders');
    }
}
