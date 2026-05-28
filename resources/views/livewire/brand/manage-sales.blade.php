{{-- resources/views/livewire/brand/sales-index.blade.php --}}
<section class="w-full">
    @include('partials.sales-heading')

    <flux:heading class="sr-only">{{ __('Manage Sales') }}</flux:heading>
    <x-brands.sales :heading="__('Manage Sales')" :subheading="__('Manage all your sales')">
        <div class="min-h-screen">
            <div class="max-w-7xl mx-auto">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="bg-[#3d3d40] rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400 mb-1">Total Sales</p>
                                <p class="text-2xl font-light text-white">{{ $this->statusCounts['all'] }}</p>
                            </div>
                            <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#3d3d40] rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400 mb-1">Active Sales</p>
                                <p class="text-2xl font-light text-green-400">{{ $this->statusCounts['active'] }}</p>
                            </div>
                            <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#3d3d40] rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400 mb-1">Scheduled</p>
                                <p class="text-2xl font-light text-yellow-400">{{ $this->statusCounts['scheduled'] }}</p>
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
                                <p class="text-sm text-gray-400 mb-1">Total Revenue</p>
                                <p class="text-2xl font-light text-white">₦{{ number_format($this->totalRevenue ?? 0, 2) }}</p>
                            </div>
                            <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                        <flux:heading class="sr-only">{{ __('Sales List') }}</flux:heading>

                        <!-- Filters -->
                        <div id="filtersContainer" class="hidden sm:grid grid-cols-2 gap-3">
                            <!-- Status -->
                            <flux:select wire:model.live="status_filter" class="w-full" wire:key="status_filter">
                                <flux:select.option value="">All Status</flux:select.option>
                                <flux:select.option value="active">Active</flux:select.option>
                                <flux:select.option value="scheduled">Scheduled</flux:select.option>
                                <flux:select.option value="ended">Ended</flux:select.option>
                                <flux:select.option value="inactive">Inactive</flux:select.option>
                            </flux:select>

                            <!-- Sort By -->
{{--                            <flux:select wire:model.live="sort_by" class="w-full" wire:key="sort_by">--}}
{{--                                <flux:select.option value="created_at">Sort by: Created Date</flux:select.option>--}}
{{--                                <flux:select.option value="name">Sort by: Name</flux:select.option>--}}
{{--                                <flux:select.option value="starts_at">Sort by: Start Date</flux:select.option>--}}
{{--                                <flux:select.option value="ends_at">Sort by: End Date</flux:select.option>--}}
{{--                            </flux:select>--}}

                            <!-- Per Page -->
                            <flux:select wire:model.live="per_page" class="w-full" wire:click="per_page">
                                <flux:select.option value="10">10 per page</flux:select.option>
                                <flux:select.option value="25">25 per page</flux:select.option>
                                <flux:select.option value="50">50 per page</flux:select.option>
                                <flux:select.option value="100">100 per page</flux:select.option>
                            </flux:select>
                        </div>

                        <!-- Search -->
                        <div>
                            <flux:input
                                type="search"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search sales..."
                                class="w-full"
                                wire:key="search"
                            >
                                <flux:icon.magnifying-glass
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                    slot="prefix"
                                />
                            </flux:input>
                        </div>
                    </div>
                </div>

                @if($search || $status_filter)
                    <flux:button wire:click="resetFilters" size="sm" variant="primary" class="mb-3">
                        Clear Filters
                    </flux:button>
                @endif

                <!-- Sales List -->
                <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    @if($this->sales->count() > 0)
                        <div class="divide-y divide-gray-500">
                            @foreach($this->sales as $sale)
                                <div class="p-4 hover:bg-gray-750 transition-colors">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <!-- Sale Icon/Avatar -->
                                            <div class="flex-shrink-0 h-12 w-12 bg-[#27272a] rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-200">
                                                    {{ $sale->name }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    Created {{ $sale->created_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="items-center space-x-2 hidden sm:block">
                                            <!-- Status Badge -->
                                            @if($sale->ongoing)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full inline-block mr-1 animate-pulse"></span>
                                                    Active
                                                </span>
                                            @elseif($sale->is_active && $sale->starts_at > now())
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                    Scheduled
                                                </span>
                                            @elseif(!$sale->is_active)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                                    Inactive
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                    Ended
                                                </span>
                                            @endif

                                            <!-- Discount Badge -->
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                                @if($sale->sale_mode == App\Enums\Status::DYNAMIC )
                                                    Customized
                                                @else
                                                    @if($sale->discount_type === 'percentage')
                                                        {{ $sale->discount_value }}% OFF
                                                    @else
                                                        ₦{{ number_format($sale->discount_value, 2) }} OFF
                                                    @endif
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Sale Description -->
                                    @if($sale->description)
                                        <div class="text-sm text-gray-400 mb-3">
                                            {{ Str::limit($sale->description, 100) }}
                                        </div>
                                    @endif

                                    <!-- Sale Details -->
                                    <div class="gap-3 mb-3">
                                        <div class="text-sm">
                                            <span class="text-gray-400">Section:</span>
                                            <span class="text-gray-200 ml-2"> {{$sale->section_id == 0 ? 'All Products' : $sale->section->name}} </span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-start gap-[1em] sm:flex-row sm:items-center justify-between mb-3">
                                        <div class="text-sm">
                                            <span class="text-gray-400">Starts:</span>
                                            <span class="text-gray-200 ml-2">{{ $sale->starts_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                        <div class="text-sm">
                                            <span class="text-gray-400">Ends:</span>
                                            <span class="text-gray-200 ml-2">{{ $sale->ends_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                    </div>

                                    <!-- Order Summary -->
                                    <div class="flex flex-wrap items-center justify-between mt-2">
                                        <div class="text-sm text-gray-400">
                                            {{ number_format($sale->total_orders) }} purchase{{ $sale->total_orders > 1 ? 's' : '' }}
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <div class="text-lg font-semibold text-white">
                                                ₦{{ number_format($sale->total_amount ?? 0, 2) }}
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="flex items-center space-x-1">
                                                <flux:dropdown position="bottom" align="end" offset="-15">
                                                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                                    <flux:menu>
                                                        <flux:menu.item href="{{route('brand-update-sales', ['sale' => $sale])}}">Update Sale</flux:menu.item>
                                                        <flux:menu.item href="{{route('brand-view-sales-orders', ['sale' => $sale])}}">View Orders</flux:menu.item>
                                                        @if($sale->ongoing)
                                                            <flux:menu.item variant="danger" wire:click="selectSale({{$sale}}, 'end')" wire:key="end">End Sales</flux:menu.item>
                                                        @else
                                                            <flux:menu.item wire:click="selectSale({{$sale}}, 'start')" wire:key="start">Start Sales</flux:menu.item>
                                                        @endif
                                                    </flux:menu>
                                                </flux:dropdown>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Progress Bar for Active Sales -->
                                    @if($sale->ongoing)
                                        @php
                                            $totalDuration = $sale->starts_at->diffInSeconds($sale->ends_at);
                                            $elapsed = $sale->starts_at->diffInSeconds(now());
                                            $percentage = min(100, max(0, ($elapsed / $totalDuration) * 100));
                                        @endphp
                                        <div class="mt-3 pt-3 border-t border-gray-600">
                                            <div class="flex justify-between text-xs text-gray-400 mb-1">
                                                <span>Sale progress</span>
                                                <span>{{ round($percentage) }}% complete</span>
                                            </div>
                                            <div class="w-full bg-gray-700 rounded-full h-1.5">
                                                <div class="bg-green-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Ends {{ $sale->ends_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Mobile Status Badges -->
                                    <div class="items-center space-x-2 block sm:hidden border-t border-gray-600 mt-3 pt-3">
                                        @if($sale->ongoing)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                Active
                                            </span>
                                        @elseif($sale->is_active && $sale->starts_at > now())
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                Scheduled
                                            </span>
                                        @elseif(!$sale->is_active)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                                Inactive
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                Ended
                                            </span>
                                        @endif

                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                            @if($sale->discount_type === 'percentage')
                                                {{ $sale->discount_value }}% OFF
                                            @else
                                                ₦{{ number_format($sale->discount_value, 2) }} OFF
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-4">
                            <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No sales found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if($search || $status_filter)
                                    Try adjusting your filters or search criteria.
                                @else
                                    You haven't created any sales yet.
                                @endif
                            </p>
                            @if($search || $status_filter )
                                <div class="mt-6">
                                    <flux:button wire:click="resetFilters" size="sm" variant="primary">
                                        Clear Filters
                                    </flux:button>
                                </div>
                            @else
                                <div class="mt-6">
                                    <a href="{{ route('brand-run-sales') }}">
                                        <flux:button size="sm" variant="primary">
                                            Create Your First Sale
                                        </flux:button>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @if($this->sales->hasPages())
                    <div class="mt-6">
                        <flux:pagination :paginator="$this->sales" />
                    </div>
                @endif
            </div>
        </div>

        @if($type === 'start')
            <div class="fixed inset-0 bg-black/70 bg-opacity-20 flex items-center justify-center p-4" style="z-index: 50;">
                <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                    <form wire:submit="startSales">
                        <flux:fieldset>
                            <div class="space-y-4">
                                <p class="text-white mb-4"> Are you sure you want to start "{{ $selectedSale->name }}"? </p>
                                <div class="flex justify-end items-center">
                                    <flux:button
                                        type="button"
                                        variant="ghost"
                                        wire:click="closeModal"
                                        size="sm"
                                    >
                                        Cancel
                                    </flux:button>
                                    <flux:button type="submit" size="sm" variant="primary" class="ml-2">
                                        <flux:icon.loading wire:loading wire:target="startSales" />
                                        <span wire:loading.remove wire:target="startSales">{{ __('Start sales') }}</span>
                                    </flux:button>
                                </div>
                            </div>
                        </flux:fieldset>
                    </form>
                </div>
            </div>
        @endif

        @if($type === 'end')
            <div class="fixed inset-0 bg-black/70 bg-opacity-20 flex items-center justify-center p-4" style="z-index: 50;">
                <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                    <form wire:submit="endSales">
                        <flux:fieldset>
                            <div class="space-y-4">
                                <p class="text-white mb-4"> Are you sure you want to end "{{ $selectedSale->name }}"? </p>
                                <div class="flex justify-end items-center">
                                    <flux:button
                                        type="button"
                                        variant="ghost"
                                        wire:click="closeModal"
                                        size="sm"
                                    >
                                        Cancel
                                    </flux:button>
                                    <flux:button type="submit" size="sm" variant="danger" class="ml-2">
                                        <flux:icon.loading wire:loading wire:target="endSales" />
                                        <span wire:loading.remove wire:target="endSales">{{ __('End sales') }}</span>
                                    </flux:button>
                                </div>
                            </div>
                        </flux:fieldset>
                    </form>
                </div>
            </div>
        @endif

    </x-brands.sales>
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

            if (btn) {
                btn.addEventListener('click', function () {
                    // Only run toggle on mobile
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
            }
        });
    </script>
@endpush
