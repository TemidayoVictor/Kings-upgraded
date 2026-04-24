<?php

namespace App\Livewire\Dropshipper;

use App\Actions\OrderAction;
use App\DTOs\GeneralDTO;
use App\Models\DropshipperStore;
use App\Models\Order;
use App\Models\OrderBatch;
use App\Models\OrderStatusHistory;
use App\Traits\Toastable;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use Toastable;

    // Filters
    use WithPagination;

    public ?DropshipperStore $store = null;

    public ?OrderBatch $batch = null;

    public string $search = '';

    public string $statusFilter = 'all';

    public string $paymentFilter = 'all';

    public string $dateRange = '30';

    // Bulk actions
    public array $selectedOrders = [];

    // Modal states
    public bool $showOrderModal = false;

    public bool $showBatchedOrdersModal = false;

    public ?Order $selectedOrder = null;

    // Stats
    public int $totalOrders = 0;

    public int $totalRevenue = 0;

    public int $pendingOrders = 0;

    public int $avgOrderValue = 0;

    public ?int $orderTrend = null;

    public ?int $revenueTrend = null;

    public ?int $batchedOrderCount = 0;

    public ?string $batchedOrderSum = '0';

    protected $queryString = ['search', 'statusFilter', 'paymentFilter', 'dateRange'];

    public function mount($store = null, $batch = null): void
    {
        if ($store) {
            $this->store = $store;
        } elseif ($batch) {
            $this->batch = $batch;
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
        if ($this->store) {
            return Order::where('dropshipper_store_id', $this->store->id);
        } elseif ($this->batch) {
            return Order::where('order_batch_id', $this->batch->id);
        } else {
            return null;
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

        $this->totalOrders = $currentQuery->count();
        $this->totalRevenue = $currentQuery->sum('total');
        $this->pendingOrders = $currentQuery->clone()->where('status', 'pending')->count();
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

    public function viewOrder($orderId): void
    {
        $this->selectedOrder = Order::with('items')->findOrFail($orderId);
        $this->showOrderModal = true;
    }

    public function closeOrderModal(): void
    {
        $this->showOrderModal = false;
        $this->selectedOrder = null;
        $this->showBatchedOrdersModal = false;
    }

    public function updateStatus($orderId, $status): void
    {
        $order = Order::findOrFail($orderId);
        $this->authorizeOrderAccess($order);

        if ($status === '') {
            $status = null;
        }

        $order->update(['dropshipper_status' => $status]);

        // Add to status history
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'new_status' => $status ?? 'Ready',
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

    public function showBatchOrders(): void
    {
        $this->getUnbatchedOrders();
        $this->showBatchedOrdersModal = true;
    }

    public function batchOrders(): void
    {
        $unbatchedOrders = $this->getUnbatchedOrders();
        $buildDto = [
            'id' => $this->store->id,
            'items' => $unbatchedOrders,
        ];
        $dto = GeneralDTO::fromArray($buildDto);
        try {
            OrderAction::batch($dto);
            $this->toast('success', 'Order batched successfully.');
        } catch (\Throwable $e) {
            $this->toast('error', $e->getMessage());
        }

        $this->showBatchedOrdersModal = false;
    }

    private function getUnbatchedOrders(): Collection
    {
        $unbatchedOrders = Order::where('dropshipper_store_id', $this->store->id)
            ->where('dropshipper_status', null)
            ->where('order_batch_id', null)
            ->get();

        if ($unbatchedOrders->count() > 0) {
            $this->batchedOrderCount = $unbatchedOrders->count();
            $this->batchedOrderSum = number_format($unbatchedOrders->sum('total') - $unbatchedOrders->sum('dropshipper_profit'), 2);
        } else {
            $this->batchedOrderCount = 0;
            $this->batchedOrderSum = '0';
        }

        return $unbatchedOrders;
    }

    private function authorizeOrderAccess($order): void
    {
        $user = auth()->user();
        if (! $user->dropshipper && $order->dropshipper_store_id !== $this->store->id) {
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
        if($this->store) {
            $this->getUnbatchedOrders();
        }
        return view('livewire.dropshipper.orders', [
            'orders' => $this->orders,
        ])->layout('layouts.auth')
            ->title('Orders');
    }
}
