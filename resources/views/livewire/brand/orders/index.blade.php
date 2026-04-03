{{-- resources/views/livewire/orders/index.blade.php --}}
<div>
    <flux:header sticky container class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-600">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" />

        <flux:navbar class="max-lg:hidden -mb-px">
            <flux:navbar.item href="{{ route('dashboard') }}">Dashboard</flux:navbar.item>
            <flux:navbar.item href="" data-current>Orders</flux:navbar.item>
            <flux:navbar.item href="">Catalog</flux:navbar.item>
            <flux:navbar.item href="">Configuration</flux:navbar.item>
        </flux:navbar>
    </flux:header>

    <flux:sidebar collapsible="mobile" class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:sidebar.nav>
            <flux:sidebar.item href="{{ route('dashboard') }}">Dashboard</flux:sidebar.item>
            <flux:sidebar.item href="" data-current>Orders</flux:sidebar.item>
            <flux:sidebar.item href="">Catalog</flux:sidebar.item>
            <flux:sidebar.item href="">Configuration</flux:sidebar.item>
        </flux:sidebar.nav>
    </flux:sidebar>

    <flux:main container>
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2">
                    <flux:select wire:model.live="dateRange" size="sm">
                        <flux:select.option value="7">Last 7 days</flux:select.option>
                        <flux:select.option value="14">Last 14 days</flux:select.option>
                        <flux:select.option value="30" selected>Last 30 days</flux:select.option>
                        <flux:select.option value="60">Last 60 days</flux:select.option>
                        <flux:select.option value="90">Last 90 days</flux:select.option>
                    </flux:select>

                    <flux:subheading class="max-md:hidden whitespace-nowrap">compared to</flux:subheading>

                    <flux:select wire:model.live="comparePeriod" size="sm" class="max-md:hidden">
                        <flux:select.option value="previous">Previous period</flux:select.option>
                        <flux:select.option value="last_year">Same period last year</flux:select.option>
                        <flux:select.option value="last_month">Last month</flux:select.option>
                        <flux:select.option value="last_quarter">Last quarter</flux:select.option>
                        <flux:select.option value="last_6_months">Last 6 months</flux:select.option>
                        <flux:select.option value="last_12_months">Last 12 months</flux:select.option>
                    </flux:select>
                </div>

                <flux:separator vertical class="max-lg:hidden mx-2 my-2" />

                <div class="max-lg:hidden flex justify-start items-center gap-2">
                    <flux:subheading class="whitespace-nowrap">Filter by:</flux:subheading>

                    <flux:badge as="button" rounded color="zinc" icon="plus" size="lg" wire:click="$set('showAmountFilter', true)">
                        Amount
                    </flux:badge>
                    <flux:badge as="button" rounded color="zinc" icon="plus" size="lg" wire:click="$set('showStatusFilter', true)">
                        Status
                    </flux:badge>
                    <flux:badge as="button" rounded color="zinc" icon="plus" size="lg" wire:click="$set('showPaymentFilter', true)">
                        Payment
                    </flux:badge>
                    <flux:badge as="button" rounded color="zinc" icon="plus" size="lg" wire:click="$set('showMoreFilters', true)">
                        More filters...
                    </flux:badge>
                </div>
            </div>

            <div class="flex gap-2">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search orders..."
                    icon="magnifying-glass"
                    size="sm"
                    class="w-64"
                />
{{--                <flux:tabs variant="segmented" class="w-auto! ml-2" size="sm">--}}
{{--                    <flux:tab wire:click="$set('viewMode', 'list')" icon="list-bullet" :active="$viewMode === 'list'" />--}}
{{--                    <flux:tab wire:click="$set('viewMode', 'grid')" icon="squares-2x2" :active="$viewMode === 'grid'" />--}}
{{--                </flux:tabs>--}}
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="flex gap-6 mb-6">
{{--            @foreach ($stats as $stat)--}}
{{--                <div class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 {{ $loop->iteration > 1 ? 'max-md:hidden' : '' }} {{ $loop->iteration > 3 ? 'max-lg:hidden' : '' }}">--}}
{{--                    <flux:subheading>{{ $stat['title'] }}</flux:subheading>--}}

{{--                    <flux:heading size="xl" class="mb-2">{{ $stat['value'] }}</flux:heading>--}}

{{--                    <div class="flex items-center gap-1 font-medium text-sm @if ($stat['trendUp']) text-green-600 dark:text-green-400 @else text-red-500 dark:text-red-400 @endif">--}}
{{--                        <flux:icon :icon="$stat['trendUp'] ? 'arrow-trending-up' : 'arrow-trending-down'" variant="micro" /> {{ $stat['trend'] }}--}}
{{--                    </div>--}}

{{--                    <div class="absolute top-0 right-0 pr-2 pt-2">--}}
{{--                        <flux:dropdown position="bottom" align="end">--}}
{{--                            <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />--}}
{{--                            <flux:menu>--}}
{{--                                <flux:menu.item icon="chart-bar">View detailed stats</flux:menu.item>--}}
{{--                                <flux:menu.item icon="document-arrow-down">Export report</flux:menu.item>--}}
{{--                                <flux:menu.item icon="bell">Set alert</flux:menu.item>--}}
{{--                            </flux:menu>--}}
{{--                        </flux:dropdown>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
        </div>

        <!-- List View -->
        @if($viewMode === 'list')
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>
                        <flux:checkbox wire:model.live="selectAll" />
                    </flux:table.column>
                    <flux:table.column class="max-md:hidden">Order #</flux:table.column>
                    <flux:table.column class="max-md:hidden">Date</flux:table.column>
                    <flux:table.column class="max-md:hidden">Status</flux:table.column>
                    <flux:table.column>
                        <span class="max-md:hidden">Customer</span>
                        <div class="md:hidden w-6"></div>
                    </flux:table.column>
                    <flux:table.column>Items</flux:table.column>
                    <flux:table.column>Total</flux:table.column>
                    <flux:table.column>Payment</flux:table.column>
                    <flux:table.column></flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($orders as $order)
                        <flux:table.row :key="$order->id" class="cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50" wire:click="viewOrder({{ $order->id }})">
                            <flux:table.cell class="pr-2" wire:click.stop>
                                <flux:checkbox wire:model.live="selectedOrders" value="{{ $order->id }}" />
                            </flux:table.cell>
                            <flux:table.cell class="max-md:hidden font-mono text-xs">#{{ $order->order_number }}</flux:table.cell>
                            <flux:table.cell class="max-md:hidden whitespace-nowrap">
                                {{ $order->created_at->format('M d, Y') }}
                                <div class="text-xs text-zinc-500">{{ $order->created_at->format('h:i A') }}</div>
                            </flux:table.cell>
                            <flux:table.cell class="max-md:hidden">
                                <flux:badge :color="$order->status_color" size="sm" inset="top bottom">
                                    {{ ucfirst($order->status) }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="min-w-6">
                                <div class="flex items-center gap-2">
                                    <flux:avatar src="https://ui-avatars.com/api/?background=6366f1&color=fff&name={{ urlencode($order->customer_name) }}" size="xs" />
                                    <span class="max-md:hidden text-sm">{{ $order->customer_name }}</span>
                                </div>
                            </flux:table.cell>
                            <flux:table.cell class="max-w-32 truncate text-sm">
                                {{ $order->items->sum('quantity') }} items
                            </flux:table.cell>
                            <flux:table.cell variant="strong" class="whitespace-nowrap">
                                ₦{{ number_format($order->total) }}
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:badge :color="$order->payment_status === 'paid' ? 'green' : ($order->payment_status === 'pending' ? 'yellow' : 'red')" size="sm">
                                    {{ ucfirst($order->payment_status) }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell wire:click.stop>
                                <flux:dropdown position="bottom" align="end" offset="-15">
                                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                    <flux:menu>
                                        <flux:menu.item icon="eye" wire:click="viewOrder({{ $order->id }})">View details</flux:menu.item>
                                        <flux:menu.item icon="document-text">View invoice</flux:menu.item>
                                        <flux:menu.item icon="truck">Update shipping</flux:menu.item>
                                        @if($order->status === 'pending')
                                            <flux:menu.item icon="check-badge" wire:click="updateStatus({{ $order->id }}, 'processing')">Process order</flux:menu.item>
                                        @endif
                                        <flux:menu.item icon="receipt-refund">Process refund</flux:menu.item>
                                        <flux:menu.separator />
                                        <flux:menu.item icon="archive-box" variant="danger">Archive</flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="9" class="text-center py-12">
                                <div class="flex flex-col items-center gap-2">
                                    <flux:icon.inbox class="w-12 h-12 text-zinc-400" />
                                    <flux:subheading>No orders found</flux:subheading>
                                    <flux:text size="sm" class="text-zinc-500">Try adjusting your filters or search criteria</flux:text>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        @else
            <!-- Grid View -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($orders as $order)
                    <div class="bg-zinc-50 dark:bg-zinc-700 rounded-lg p-4 hover:shadow-lg transition cursor-pointer" wire:click="viewOrder({{ $order->id }})">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <div class="font-mono text-xs text-zinc-500">#{{ $order->order_number }}</div>
                                <div class="text-sm text-zinc-600 dark:text-zinc-400">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                            </div>
                            <flux:dropdown position="bottom" align="end" wire:click.stop>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"></flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="eye" wire:click="viewOrder({{ $order->id }})">View details</flux:menu.item>
                                    <flux:menu.item icon="document-text">View invoice</flux:menu.item>
                                    <flux:menu.item icon="truck">Update shipping</flux:menu.item>
                                    @if($order->status === 'pending')
                                        <flux:menu.item icon="check-badge" wire:click="updateStatus({{ $order->id }}, 'processing')">Process order</flux:menu.item>
                                    @endif
                                </flux:menu>
                            </flux:dropdown>
                        </div>

                        <div class="flex items-center gap-2 mb-3">
                            <flux:avatar src="https://ui-avatars.com/api/?background=6366f1&color=fff&name={{ urlencode($order->customer_name) }}" size="sm" />
                            <div>
                                <div class="text-sm font-medium">{{ $order->customer_name }}</div>
                                <div class="text-xs text-zinc-500">{{ $order->customer_phone }}</div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <div class="text-xs text-zinc-500">Items</div>
                                <div class="text-sm">{{ $order->items->sum('quantity') }} products</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-zinc-500">Total</div>
                                <div class="text-lg font-semibold">₦{{ number_format($order->total) }}</div>
                            </div>
                        </div>

                        <div class="flex gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-600">
                            <flux:badge :color="$order->status_color" size="sm">
                                {{ ucfirst($order->status) }}
                            </flux:badge>
                            <flux:badge :color="$order->payment_status === 'paid' ? 'green' : ($order->payment_status === 'pending' ? 'yellow' : 'red')" size="sm">
                                {{ ucfirst($order->payment_status) }}
                            </flux:badge>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="flex flex-col items-center gap-2">
                            <flux:icon.inbox class="w-12 h-12 text-zinc-400" />
                            <flux:subheading>No orders found</flux:subheading>
                        </div>
                    </div>
                @endforelse
            </div>
        @endif

        <!-- Bulk Actions -->
        @if($selectedOrders && count($selectedOrders) > 0)
            <div class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-zinc-800 dark:bg-zinc-700 rounded-lg shadow-lg p-3 flex items-center gap-4 z-50">
                <span class="text-white text-sm">{{ count($selectedOrders) }} order(s) selected</span>
                <flux:button size="sm" variant="primary" wire:click="bulkUpdateStatus('processing')">Process Selected</flux:button>
                <flux:button size="sm" variant="danger" wire:click="bulkUpdateStatus('cancelled')">Cancel Selected</flux:button>
                <flux:button size="sm" variant="subtle" wire:click="$set('selectedOrders', [])">Cancel</flux:button>
            </div>
        @endif

        <!-- Pagination -->
        <div class="mt-6">
            <flux:pagination :paginator="$orders" />
        </div>
    </flux:main>

    <!-- Status Filter Modal -->
    @if($showStatusFilter)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" wire:click.self="$set('showStatusFilter', false)">
            <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 max-w-md w-full mx-4">
                <flux:heading size="lg" class="mb-4">Filter by Status</flux:heading>
                <div class="space-y-2">
                    @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                        <label class="flex items-center gap-3 p-2 hover:bg-zinc-50 dark:hover:bg-zinc-700 rounded cursor-pointer">
                            <input type="checkbox" wire:model.live="statusFilters" value="{{ $status }}" class="rounded border-zinc-300">
                            <span class="capitalize">{{ $status }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <flux:button variant="subtle" wire:click="$set('showStatusFilter', false)">Close</flux:button>
                    <flux:button wire:click="$set('showStatusFilter', false)" variant="primary">Apply</flux:button>
                </div>
            </div>
        </div>
    @endif

    <!-- Payment Filter Modal -->
    @if($showPaymentFilter)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" wire:click.self="$set('showPaymentFilter', false)">
            <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 max-w-md w-full mx-4">
                <flux:heading size="lg" class="mb-4">Filter by Payment Status</flux:heading>
                <div class="space-y-2">
                    @foreach(['pending', 'paid', 'failed', 'refunded'] as $status)
                        <label class="flex items-center gap-3 p-2 hover:bg-zinc-50 dark:hover:bg-zinc-700 rounded cursor-pointer">
                            <input type="checkbox" wire:model.live="paymentFilters" value="{{ $status }}" class="rounded border-zinc-300">
                            <span class="capitalize">{{ $status }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <flux:button variant="subtle" wire:click="$set('showPaymentFilter', false)">Close</flux:button>
                    <flux:button wire:click="$set('showPaymentFilter', false)" variant="primary">Apply</flux:button>
                </div>
            </div>
        </div>
    @endif
</div>
