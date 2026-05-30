<?php

namespace App\Livewire\Shop;

use App\Enums\Status;
use App\Models\Brand;
use App\Models\DropshipperStore;
use App\Models\Order;
use App\Models\OrderBatch;
use App\Models\OrderStatusHistory;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;

class Orders extends Component
{
    public ?OrderBatch $batch = null;

    public Brand $brand;

    public ?Sale $sale = null;

    public string $search = '';

    public string $statusFilter = 'all';

    public string $paymentFilter = 'all';

    public string $dateRange = '30';

    // Bulk actions
    public array $selectedOrders = [];

    // Modal states
    public bool $showOrderModal = false;

    public ?Order $selectedOrder = null;

    // Stats
    public int $totalOrders = 0;

    public int $totalRevenue = 0;

    public int $pendingOrders = 0;

    public int $avgOrderValue = 0;

    public ?int $orderTrend = null;

    public ?int $revenueTrend = null;

    public ?string $status = null;

    public ?bool $admin = false;

    public ?bool $user = false;

    public ?DropshipperStore $store = null;

    protected array $queryString = ['search', 'statusFilter', 'paymentFilter', 'dateRange'];

    public function mount(Brand $brand): void
    {
        $this->calculateStats();
        $this->brand = $brand;
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
        $this->calculateStats();
    }
    public function getOrdersProperty(): LengthAwarePaginator
    {
        $query = $this->getBaseQuery();

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%'.$this->search.'%')
                    ->orWhere('customer_name', 'like', '%'.$this->search.'%')
                    ->orWhere('customer_phone', 'like', '%'.$this->search.'%')
                    ->orWhere('customer_email', 'like', '%'.$this->search.'%');
            });
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply payment filter
        if ($this->paymentFilter !== 'all') {
            $query->where('payment_status', $this->paymentFilter);
        }

        // Apply date range
        if ($this->dateRange !== 'all') {
            $query->where('created_at', '>=', now()->subDays((int) $this->dateRange));
        }

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
        $previousQuery = $this->getBaseQuery();

        // Apply current filters for stats
        if ($this->statusFilter !== 'all') {
            $currentQuery->where('status', $this->statusFilter);
        }
        if ($this->paymentFilter !== 'all') {
            $currentQuery->where('payment_status', $this->paymentFilter);
        }

        // Current period
        if ($this->dateRange !== 'all') {
            $currentQuery->where('created_at', '>=', now()->subDays((int) $this->dateRange));
        }

        $this->totalOrders = $currentQuery->count();
        $this->totalRevenue = $this->getRevenue($currentQuery);
        $this->pendingOrders = $currentQuery->where('status', 'pending')->count();

        $this->avgOrderValue = $this->totalOrders > 0 ? $this->totalRevenue / $this->totalOrders : 0;

        // Previous period for trends
        if ($this->dateRange !== 'all') {
            $days = (int) $this->dateRange;
            $previousQuery->whereBetween('created_at', [
                now()->subDays($days * 2),
                now()->subDays($days),
            ]);

            if ($this->statusFilter !== 'all') {
                $previousQuery->where('status', $this->statusFilter);
            }
            if ($this->paymentFilter !== 'all') {
                $previousQuery->where('payment_status', $this->paymentFilter);
            }

            $previousOrders = $previousQuery->count();
            $previousRevenue = $previousQuery->sum('total');

            $this->orderTrend = $previousOrders > 0
                ? round((($this->totalOrders - $previousOrders) / $previousOrders) * 100, 1)
                : ($this->totalOrders > 0 ? 100 : 0);

            $this->revenueTrend = $previousRevenue > 0
                ? round((($this->totalRevenue - $previousRevenue) / $previousRevenue) * 100, 1)
                : ($this->totalRevenue > 0 ? 100 : 0);
        }
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

    public function updateStatus($orderId, $status, $type = 'status'): void
    {
        $order = Order::findOrFail($orderId);
        $this->authorizeOrderAccess($order);

        if ($type === 'status') {
            $order->update(['status' => $status]);
        } else {
            $order->update(['payment_status' => $status]);
        }

        // Add to status history
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'new_status' => $status,
            'changed_by' => auth()->id(),
            'notes' => 'Order status updated to '.ucfirst($status),
        ]);

        $this->toast('success', 'Order status updated successfully.');
        $this->calculateStats();
    }

    public function clearSelected(): void
    {
        $this->selectedOrders = [];
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->statusFilter = 'all';
        $this->paymentFilter = 'all';
        $this->dateRange = '30';
        $this->resetPage();
        $this->calculateStats();
    }

    public function exportOrders(): void
    {
        $orders = $this->getBaseQuery()
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->paymentFilter !== 'all', fn ($q) => $q->where('payment_status', $this->paymentFilter))
            ->when($this->dateRange !== 'all', fn ($q) => $q->where('created_at', '>=', now()->subDays((int) $this->dateRange)))
            ->get();

        // Export logic here
        session()->flash('message', 'Export started. You will be notified when ready.');
    }

    private function authorizeOrderAccess($order): void
    {
        $user = auth()->user();
        if ((! $user->brand && $order->brand_id !== $user->brand->id) || (! $this->admin)) {
            abort(403);
        }
    }

    private function canAccessOrder($order): bool
    {
        try {
            $this->authorizeOrderAccess($order);

            return true;
        } catch (\Exception $e) {
            return false;
        }
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
