<section class="w-full">
    @include('partials.partnerships')

    <flux:heading class="sr-only">{{ __('Partnered Brands') }}</flux:heading>

    <x-dropshippers.layout :heading="__('Partnered Brands')" :subheading="__('Manage Partnered Brands')">
        <div class="flex justify-end mb-4">
            <flux:button href=" {{ route('dropshipper-browse-brands')  }} " size="sm" variant="primary">
                Browse Brands
            </flux:button>
        </div>

        <flux:separator/>

        <div class="min-h-screen">
            <div class="max-w-7xl mx-auto">
                <!-- Search and Filter Section -->
                <div class="grid grid-cols-1 my-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <flux:input type="search"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search brands by name or category..."
                            class="w-full" />
                    </div>
                </div>
                <!-- Brands Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($stores as $store)
                        <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow flex flex-col h-full">
                            <!-- Brand Header - Fixed height, stays at top -->
                            <div class="h-32 bg-gradient-to-r from-[#27272a] to-[#3d3d40] relative flex-shrink-0">
                                @if($store->brand->image)
                                    <img src="{{ Storage::url($store->brand->image) }}"
                                         alt="{{ $store->brand->brand_name }}"
                                         class="w-full h-full object-cover opacity-50">
                                @endif
                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                    @if(!$store->brand->image)
                                        <img src="{{ asset('images/Logo-Crown.svg') }}" alt="Logo" class="w-16 h-16">
                                    @endif
                                </div>

                                <!-- Brand Avatar -->
                                <div class="absolute -bottom-8 left-4">
                                    <div class="h-16 w-16 bg-[#27272a] rounded-xl border-4 border-[#3d3d40] overflow-hidden">
                                        @if($store->brand->image)
                                            <img src="{{ Storage::url($store->brand->image) }}"
                                                 alt="{{ $store->brand->brand_name }}"
                                                 class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-2xl font-bold text-gray-400">
                                                {{ substr($store->brand->brand_name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Brand Content - Takes remaining space and pushes button to bottom -->
                            <div class="pt-10 p-4 flex flex-col flex-grow">
                                <!-- Top section: Title and badge -->
                                <div>
                                    <!-- Application Status Badge -->
                                    @if($store->status === App\Enums\Status::CLONED)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30 whitespace-nowrap flex-shrink-0">
                                            Cloned
                                        </span>
                                    @else()
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 whitespace-nowrap flex-shrink-0">
                                            Not cloned
                                        </span>
                                    @endif

                                    <div class="mt-2">
                                        <h3 class="text-lg font-semibold text-white">{{ $store->brand->brand_name }}</h3>
                                        <p class="text-sm text-gray-400">by {{ $store->brand->user->name }}</p>
                                    </div>
                                </div>

                                <!-- Middle section: Details - Takes available space -->
                                <div class="space-y-2 mb-4 flex-grow mt-2">
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                        </svg>
                                        <span class="truncate">{{ $store->brand->category }} @if($store->brand->sub_category) / {{ $store->brand->sub_category }} @endif</span>
                                    </div>

                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <span>{{ $store->brand->products->count() ?? 0 }} product{{$store->brand->products->count() != 1 ? 's' : ''}}</span>
                                    </div>

                                    @if($store->brand->city || $store->brand->state)
                                        <div class="flex items-center text-sm text-gray-400">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="truncate">{{ $store->brand->city }}{{ $store->brand->state ? ', ' . $store->brand->state : '' }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Bottom section: Action Button - Always at bottom -->
                                <div class="mt-auto pt-4">
                                    <div class="flex gap-2">
                                        <flux:button href="{{ route('dropshipper-manage-store', $store) }}" size="sm" variant="primary" class="w-full">
                                            Manage store
                                        </flux:button>
                                        <flux:button href="{{ route('dropshipper-orders', $store) }}" size="sm" variant="primary" class="w-full">
                                            Orders
                                        </flux:button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 px-4">
                            <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No brands found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                        </div>
                    @endforelse
                </div>

                @if($stores->hasPages())
                    <div class="mt-6">
                        <flux:pagination :paginator="$brands" />
                    </div>
                @endif
            </div>
        </div>
    </x-dropshippers.layout>
</section>
