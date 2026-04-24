{{-- resources/views/livewire/orders/index.blade.php --}}
<section class="w-full">
    @include('partials.orders-heading')

    <flux:heading class="sr-only">{{ __('Manage Orders') }}</flux:heading>
    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-[#3d3d40] rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Total Orders</p>
                            <p class="text-2xl font-light text-white">{{ $totalOrders }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                    @if($orderTrend)
                        <div class="mt-2 text-xs {{ $orderTrend >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $orderTrend >= 0 ? '↑' : '↓' }} {{ abs($orderTrend) }}% from last period
                        </div>
                    @endif
                </div>

                <div class="bg-[#3d3d40] rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Total Revenue</p>
                            <p class="text-2xl font-light text-white">₦{{ number_format($totalRevenue, 2) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    @if($revenueTrend)
                        <div class="mt-2 text-xs {{ $revenueTrend >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $revenueTrend >= 0 ? '↑' : '↓' }} {{ abs($revenueTrend) }}% from last period
                        </div>
                    @endif
                </div>

                <div class="bg-[#3d3d40] rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Pending Orders</p>
                            <p class="text-2xl font-light text-yellow-400">{{ $pendingOrders }}</p>
                        </div>
                        <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-[#3d3d40] rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Average Order Value</p>
                            <p class="text-2xl font-light text-white">₦{{ number_format($avgOrderValue, 2) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header with Filters -->
            <div>
                <!-- Toggle Button (Mobile only) -->
                <div class="inline-flex justify-between items-center sm:hidden">
                    <button
                        id="toggleFiltersBtn"
                        class="flex items-center gap-2 px-4 py-2 text-sm bg-[#3d3d40] hover:bg-[#4a4a4e] text-gray-300 rounded-lg transition-all duration-200 w-full"
                    >
                        <svg id="iconOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>

                        <svg id="iconClose" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>

                        <span id="toggleText">Show Filters</span>
                    </button>
                </div>

                <div class="flex flex-col gap-4 my-3">
                    <flux:heading class="sr-only">{{ __('Orders List') }}</flux:heading>

                    <!-- Filters -->
                    <div id="filtersContainer" class="hidden sm:grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <!-- Status -->
                        <flux:select wire:model.live="statusFilter" class="w-full">
                            <flux:select.option value="all">All Status</flux:select.option>
                            <flux:select.option value="pending">Pending</flux:select.option>
                            <flux:select.option value="processing">Processing</flux:select.option>
                            <flux:select.option value="delivered">Delivered</flux:select.option>
                            <flux:select.option value="cancelled">Cancelled</flux:select.option>
                        </flux:select>

                        <!-- Payment -->
                        <flux:select wire:model.live="paymentFilter" class="w-full">
                            <flux:select.option value="all">All Payment</flux:select.option>
                            <flux:select.option value="pending">Pending</flux:select.option>
                            <flux:select.option value="paid">Paid</flux:select.option>
                            <flux:select.option value="failed">Failed</flux:select.option>
                            <flux:select.option value="refunded">Refunded</flux:select.option>
                        </flux:select>

                        <!-- Date -->
                        <flux:select wire:model.live="dateRange" class="w-full">
                            <flux:select.option value="7">Last 7 days</flux:select.option>
                            <flux:select.option value="14">Last 14 days</flux:select.option>
                            <flux:select.option value="30" selected>Last 30 days</flux:select.option>
                            <flux:select.option value="60">Last 60 days</flux:select.option>
                            <flux:select.option value="90">Last 90 days</flux:select.option>
                            <flux:select.option value="all">All time</flux:select.option>
                        </flux:select>
                    </div>

                    <!-- Search -->
                    <div>
                        <flux:input
                            type="search"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search orders..."
                            class="w-full"
                        >
                            <flux:icon.magnifying-glass
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                slot="prefix"
                            />
                        </flux:input>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-3">
                @if($orders->count() > 0 && ($search || $statusFilter !== 'all' || $paymentFilter !== 'all' || $dateRange !== '30'))
                    <flux:button wire:click="resetFilters" size="sm" variant="primary">
                        Clear Filters
                    </flux:button>
                @endif
                @if($store)
                    <flux:button href="{{route('dropshipper-batched-orders', ['store' => $store])}}" size="sm" variant="primary">
                        View Batched Orders
                    </flux:button>
                @endif
            </div>

            @if($batchedOrderCount != 0)
                <flux:callout icon="clock" class="mb-5" color="yellow">
                    <flux:callout.heading><strong class="text-[1rem]">You have unbatched orders</strong></flux:callout.heading>
                    <flux:callout.text>
                        You have some unbatched orders. Click the button below, to batch this orders and send to the brand.
                    </flux:callout.text>
                    <flux:button size="sm" variant="primary" class="mt-2" wire:click="showBatchOrders">Batch Orders</flux:button>
                </flux:callout>
            @endif

            <!-- Orders List -->
            <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                @if($orders->count() > 0)
                    <div class="divide-y divide-gray-500">
                        @foreach($orders as $order)
                            <div class="p-4 hover:bg-gray-750 transition-colors cursor-pointer" wire:click="viewOrder({{ $order->id }})">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <!-- Order Icon/Avatar -->
                                        <div class="flex-shrink-0 h-12 w-12 bg-[#27272a] rounded-lg flex items-center justify-center">
                                            <span class="text-gray-300 font-medium text-lg">
                                                {{ substr($order->customer_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-200">
                                                Order #{{ $order->order_number }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $order->created_at->format('M d, Y h:i A') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="items-center space-x-2 hidden sm:block">
                                        <!-- Payment Status Badge -->
                                        @if($order->dropshipper_status === App\Enums\Status::APPROVED)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                Batched
                                            </span>
                                        @elseif($order->dropshipper_status === App\Enums\Status::PENDING)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                Not Ready
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                Pending Approval
                                            </span>
                                        @endif

                                        <!-- Order Status Badge -->
                                        @if($order->status === App\Enums\Status::PENDING)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                Pending
                                            </span>
                                        @elseif($order->status === App\Enums\Status::PROCESSING)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                                Processing
                                            </span>
                                        @elseif($order->status === App\Enums\Status::SHIPPED)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                                Shipped
                                            </span>
                                        @elseif($order->status === App\Enums\Status::DELIVERED)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                Delivered
                                            </span>
                                        @elseif($order->status === App\Enums\Status::CANCELLED)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                Cancelled
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Customer Info -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                                    <div class="text-sm">
                                        <span class="text-gray-400">Customer:</span>
                                        <span class="text-gray-200 ml-2">{{ $order->customer_name }}</span>
                                    </div>
                                    <div class="text-sm">
                                        <span class="text-gray-400">Phone:</span>
                                        <span class="text-gray-200 ml-2">{{ $order->customer_phone }}</span>
                                    </div>
                                    <div class="text-sm">
                                        <span class="text-gray-400">Items:</span>
                                        <span class="text-gray-200 ml-2">{{ $order->items->sum('quantity') }} products</span>
                                    </div>
                                </div>

                                <!-- Order Summary -->
                                <div class="flex flex-wrap items-center justify-between mt-2">
                                    <div class="text-sm text-gray-400">
                                        Delivery: {{ $order->delivery_city }}, {{ $order->delivery_state }}
                                    </div>

                                    <div class="flex items-center space-x-3">
                                        <div class="text-lg font-semibold text-white">
                                            ₦{{ number_format($order->total, 2) }}
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center space-x-1" wire:click.stop>
                                            <flux:dropdown position="bottom" align="end" offset="-15">
                                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                                <flux:menu>
                                                    <flux:menu.item wire:click="viewOrder({{ $order->id }})">View Details</flux:menu.item>
                                                    @if(!$order->dropshipper_status)
                                                        <flux:menu.item wire:click="updateStatus({{ $order->id }}, 'pending')" wire:key="not-ready">Mark as not ready</flux:menu.item>
                                                    @elseif($order->dropshipper_status ===  App\Enums\Status::PENDING)
                                                        <flux:menu.item wire:click="updateStatus({{ $order->id }}, '')" wire:key="ready">Mark as ready</flux:menu.item>
                                                    @endif

                                                    @if(!in_array($order->status, ['delivered', 'cancelled']))
                                                        <flux:menu.item variant="danger" wire:click="updateStatus({{ $order->id }}, 'cancelled')" wire:key="cancelled">Cancel Order</flux:menu.item>
                                                    @endif
                                                </flux:menu>
                                            </flux:dropdown>
                                        </div>
                                    </div>
                                </div>

                                <!-- Items Preview (for larger screens) -->
                                @if($order->items->count() > 0)
                                    <div class="mt-3 pt-3 border-t border-gray-600">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($order->items->take(3) as $item)
                                                <span class="text-xs text-gray-400 bg-[#27272a] px-2 py-1 rounded">
                                                    {{ $item->quantity }}x {{ Str::limit($item->product_name, 30) }}
                                                </span>
                                            @endforeach
                                            @if($order->items->count() > 3)
                                                <span class="text-xs text-gray-500">
                                                    +{{ $order->items->count() - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="items-center space-x-2 block sm:hidden border-t border-gray-600 mt-3 pt-3">
                                    <!-- Payment Status Badge -->
                                    @if($order->dropshipper_status === App\Enums\Status::APPROVED)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                            Approved
                                        </span>
                                    @elseif($order->dropshipper_status === App\Enums\Status::PENDING)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                            Not Ready
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                            Pending Approval
                                        </span>
                                    @endif

                                    <!-- Order Status Badge -->
                                    @if($order->status === App\Enums\Status::PENDING)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                Pending
                                            </span>
                                    @elseif($order->status === App\Enums\Status::PROCESSING)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                                Processing
                                            </span>
                                    @elseif($order->status === App\Enums\Status::SHIPPED)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                                Shipped
                                            </span>
                                    @elseif($order->status === App\Enums\Status::DELIVERED)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                Delivered
                                            </span>
                                    @elseif($order->status === App\Enums\Status::CANCELLED)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                Cancelled
                                            </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 px-4">
                        <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-300">No orders found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if($search || $statusFilter !== 'all' || $paymentFilter !== 'all')
                                Try adjusting your filters or search criteria.
                            @else
                                No orders have been placed yet.
                            @endif
                        </p>
                        @if($search || $statusFilter !== 'all' || $paymentFilter !== 'all')
                            <div class="mt-6">
                                <flux:button wire:click="resetFilters" size="sm" variant="primary">
                                    Clear Filters
                                </flux:button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @if($orders->hasPages())
                <div class="mt-6">
                    <flux:pagination :paginator="$orders" />
                </div>
            @endif

            <!-- Order Details Modal -->
            @if($showOrderModal)
                <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50 overflow-y-auto">
                    <div class="bg-[#27272a] rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                        <div class="sticky top-0 bg-[#27272a] border-b border-gray-700 px-6 py-4 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-white">
                                Order #{{ $selectedOrder->order_number ?? '' }}
                            </h3>
                            <button wire:click="closeOrderModal" class="text-gray-400 hover:text-gray-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        @if($selectedOrder)
                            <div class="p-6">
                                <!-- Order details content here -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        @if($selectedOrder->dropshipper_store_id)
                                            <div class="mb-2">
                                                <h4 class="text-sm font-medium text-gray-400 mb-2">Dropshipper</h4>
                                                <div class="bg-[#3d3d40] rounded-lg p-4 space-y-2">
                                                    <p class="text-white">{{ $selectedOrder->store->store_name }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        <div>
                                            <h4 class="text-sm font-medium text-gray-400 mb-2">Customer Information</h4>
                                            <div class="bg-[#3d3d40] rounded-lg p-4 space-y-2">
                                                <p class="text-white">{{ $selectedOrder->customer_name }}</p>
                                                <p class="text-gray-300">{{ $selectedOrder->customer_phone }}</p>
                                                @if($selectedOrder->customer_email)
                                                    <p class="text-gray-300">{{ $selectedOrder->customer_email }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-400 mb-2">Delivery Information</h4>
                                            <div class="bg-[#3d3d40] rounded-lg p-4 space-y-2">
                                                <p class="text-white">{{ $selectedOrder->delivery_address }}</p>
                                                <p class="text-gray-300">{{ $selectedOrder->delivery_city }}, {{ $selectedOrder->delivery_state }}</p>
                                                @if($selectedOrder->delivery_zip)
                                                    <p class="text-gray-300">ZIP: {{ $selectedOrder->delivery_zip }}</p>
                                                @endif
                                                @if($selectedOrder->delivery_instructions)
                                                    <p class="text-gray-400 italic">"{{ $selectedOrder->delivery_instructions }}"</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class=" mt-2">
                                            <h4 class="text-sm font-medium text-gray-400 mb-2">Delivery Route</h4>
                                            <div class="bg-[#3d3d40] rounded-lg p-4 space-y-2">
                                                <p class="text-white">{{ $selectedOrder->deliveryLocation->name}}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-400 mb-2">Order Items</h4>
                                    <div class="bg-[#3d3d40] rounded-lg overflow-hidden">
                                        <div class="divide-y divide-gray-600">
                                            @foreach($selectedOrder->items as $item)
                                                <div class="p-4 flex items-start gap-4">
                                                    <!-- Product Image Placeholder -->
                                                    <div class="w-12 h-12 bg-[#1a1a1c] rounded-lg overflow-hidden flex-shrink-0">
                                                        @if($selectedOrder->dropshipper_store_id)
                                                            @if($item->dropshipperProduct->originalProduct && $item->dropshipperProduct->originalProduct->images->count() > 0)
                                                                <img
                                                                    src="{{ $item->dropshipperProduct->originalProduct->primary_image_url }}"
                                                                    alt="{{ $item->product_name }}"
                                                                    class="w-20 h-20 object-cover object-bottom rounded-lg mx-auto block"
                                                                >
                                                            @else
                                                                <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                                    <span class="text-gray-300 font-medium">{{ substr($item->product_name, 0, 1) }}</span>
                                                                </div>
                                                            @endif
                                                        @else
                                                            @if($item->product && $item->product->images->count() > 0)
                                                                <img
                                                                    src="{{ $item->product->primary_image_url }}"
                                                                    alt="{{ $item->product->name }}"
                                                                    class="w-20 h-20 object-cover object-bottom rounded-lg mx-auto block"
                                                                >
                                                            @else
                                                                <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                                    <span class="text-gray-300 font-medium">{{ substr($item->product_name, 0, 1) }}</span>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>

                                                    <!-- Product Details -->
                                                    <div class="flex-1">
                                                        <div class="flex flex-col flex-wrap justify-between items-start gap-2 sm:flex-row">
                                                            <div>
                                                                <p class="text-white font-medium">{{ $item->product_name }}</p>
                                                                <p class="text-xs text-gray-400">Qty: {{ $item->quantity }}</p>
                                                            </div>
                                                            <div class="sm:text-right">
                                                                <p class="text-white font-medium">₦{{ number_format($item->total) }}</p>
                                                                <p class="text-xs text-gray-400">₦{{ number_format($item->unit_price) }} each</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Order Summary -->
                                        <div class="bg-[#27272a] px-4 py-3 space-y-2">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-400">Subtotal</span>
                                                <span class="text-white">₦{{ number_format($selectedOrder->subtotal) }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-400">Shipping</span>
                                                <span class="text-white">₦{{ number_format($selectedOrder->shipping) }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-400">Tax</span>
                                                <span class="text-white">₦{{ number_format($selectedOrder->tax) }}</span>
                                            </div>
                                            @if($selectedOrder->discount > 0)
                                                <div class="flex justify-between text-sm text-green-400">
                                                    <span>Discount</span>
                                                    <span>-₦{{ number_format($selectedOrder->discount) }}</span>
                                                </div>
                                            @endif
                                            <div class="flex justify-between pt-2 border-t border-gray-600">
                                                <span class="text-white font-medium">Total:</span>
                                                <span class="text-white font-bold text-[1rem]">₦{{ number_format($selectedOrder->total) }}</span>
                                            </div>
                                            <div class="flex justify-between pt-2 border-t border-gray-600">
                                                <span class="text-white font-medium">Your Profit:</span>
                                                <span class="text-white font-bold text-[1rem]">₦{{ number_format($selectedOrder->dropshipper_profit) }}</span>
                                            </div>
                                            <div class="flex justify-between pt-2 border-t border-gray-600">
                                                <span class="text-white font-medium">Amount to send:</span>
                                                <span class="text-white font-bold text-[1rem]">₦{{ number_format($selectedOrder->total - $selectedOrder->dropshipper_profit) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Modals --}}

            @if($showBatchedOrdersModal)
                <div class="fixed inset-0 bg-black/70 bg-opacity-20 flex items-center justify-center p-4" style="z-index: 50;">
                    <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                        <div class="mb-2">
                            <h3 class="text-[1.2rem]">Batch Orders</h3>
                            <flux:text class="m">To exclude any order, click on 'Mark as not ready' for that order </flux:text>
                        </div>
                        <flux:separator />
                        <div class="mt-2 flex flex-col gap-y-3 mb-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-white font-medium">Total Orders: </p>
                                </div>
                                <div class="sm:text-right">
                                    <p class="text-white font-medium">{{number_format($batchedOrderCount)}}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-white font-medium">Amount to send:</p>
                                </div>
                                <div class="sm:text-right">
                                    <p class="text-white font-medium">₦ {{$batchedOrderSum}}</p>
                                </div>
                            </div>
                        </div>
                        <flux:separator />
                        <div class="flex justify-end items-center my-3">
                            <flux:button type="button" variant="subtle" size="sm" wire:click="closeOrderModal">
                                Cancel
                            </flux:button>
                            <flux:button type="submit" size="sm" variant="primary" class="ml-2" wire:click="batchOrders">
                                <flux:icon.loading wire:loading wire:target="batchOrders" />
                                <span wire:loading.remove wire:target="batchOrders">Send Orders</span>
                            </flux:button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('toggleFiltersBtn');
            const container = document.getElementById('filtersContainer');
            const text = document.getElementById('toggleText');
            const iconOpen = document.getElementById('iconOpen');
            const iconClose = document.getElementById('iconClose');

            let visible = false;

            btn.addEventListener('click', function () {
                // 🚨 Only run toggle on mobile
                if (window.innerWidth >= 640) return;

                visible = !visible;

                if (visible) {
                    container.classList.remove('hidden');
                    container.classList.add('grid');
                    text.textContent = 'Hide Filters';
                    iconOpen.classList.add('hidden');
                    iconClose.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                    text.textContent = 'Show Filters';
                    iconOpen.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                }
            });
        });
    </script>
@endpush

