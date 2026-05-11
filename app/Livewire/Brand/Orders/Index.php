<?php

namespace App\Livewire\Brand\Orders;

use App\Enums\Status;
use App\Models\DropshipperStore;
use App\Models\Order;
use App\Models\OrderBatch;
use App\Models\OrderStatusHistory;
use App\Models\Sale;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use Toastable;

    // Filters
    use WithPagination;

    public ?OrderBatch $batch = null;

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

    public ?DropshipperStore $store = null;

    protected array $queryString = ['search', 'statusFilter', 'paymentFilter', 'dateRange'];

    public function mount($batch = null, $sale = null, $status = null, $store = null): void
    {
        if ($batch) {
            $this->batch = $batch;
        } elseif ($sale) {
            $this->sale = $sale;
        } elseif ($status) {
            $this->status = $status;
        } elseif ($store) {
            $this->store = $store;
        }
        $this->calculateStats();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
        $this->calculateStats();
    }

    public function updatedPaymentFilter(): void
    {
        $this->resetPage();
        $this->calculateStats();
    }

    public function updatedDateRange(): void
    {
        $this->resetPage();
        $this->calculateStats();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function getOrdersProperty(): mixed
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

    private function getBaseQuery(): mixed
    {
        $user = auth()->user();
        if ($this->batch != null) {
            return Order::where('brand_id', $user->brand->id)
                ->where('order_batch_id', $this->batch->id);
        } elseif ($this->sale != null) {
            return Order::where('brand_id', $user->brand->id)
                ->whereHas('items', function ($query) {
                    $query->where('sale_id', $this->sale->id);
                });
        } elseif ($this->status != null) {
            return Order::where('brand_id', $user->brand->id)
                ->where('status', $this->status);
        } elseif ($this->store != null) {
            return Order::where('brand_id', $user->brand->id)
                ->where('dropshipper_store_id', $this->store->id);
        } else {
            return Order::where('brand_id', $user->brand->id);
        }
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

        $this->totalOrders = $this->applyValidOrders(clone $currentQuery)->count();
        $this->totalRevenue = $this->getRevenue($this->applyValidOrders($currentQuery));
        $this->pendingOrders = $this->applyValidOrders(clone $currentQuery)
            ->where('status', 'pending')
            ->count();

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

    private function applyValidOrders($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('dropshipper_store_id')
                ->orWhere(function ($q2) {
                    $q2->whereNotNull('dropshipper_store_id')
                        ->where('dropshipper_status', 'approved');
                });
        });
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

    public function bulkUpdateStatus($status)
    {
        foreach ($this->selectedOrders as $orderId) {
            $order = Order::find($orderId);
            if ($order && $this->canAccessOrder($order)) {
                $order->update(['status' => $status]);

                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'new_status' => $status,
                    'changed_by' => auth()->id(),
                    'notes' => 'Bulk update: Status changed to '.ucfirst($status),
                ]);
            }
        }

        $this->selectedOrders = [];
        session()->flash('message', count($this->selectedOrders).' orders updated successfully.');
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

    private function authorizeOrderAccess($order)
    {
        $user = auth()->user();
        if (! $user->brand && $order->brand_id !== $user->brand->id) {
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
        return view('livewire.brand.orders.index', [
            'orders' => $this->orders,
        ])->layout('layouts.auth')
            ->title('Orders');
    }
}
