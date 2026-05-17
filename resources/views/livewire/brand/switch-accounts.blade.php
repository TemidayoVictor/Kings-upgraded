<section class="w-full">
    @include('partials.switch-accounts-heading')

    <flux:heading class="sr-only">{{ __('Switch Accounts') }}</flux:heading>
    <section class="w-full">

        <flux:heading class="sr-only">{{ __('Accounts') }}</flux:heading>

        <div class="">
            <div class="max-w-7xl mx-auto">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($brands as $brand)
                        <div class="h-full">
                            <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow h-full flex flex-col">
                                <!-- Brand Header - Fixed height, stays at top -->
                                <div class="h-32 bg-gradient-to-r from-[#27272a] to-[#3d3d40] relative flex-shrink-0">
                                    @if($brand->image)
                                        <img src="{{ Storage::url($brand->image) }}"
                                             alt="{{ $brand->brand_name }}"
                                             class="w-full h-full object-cover opacity-50">
                                    @endif
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        @if(!$brand->image)
                                            <img src="{{ asset('images/Logo-Crown.svg') }}" alt="Logo" class="w-16 h-16">
                                        @endif
                                    </div>

                                    <!-- Brand Avatar -->
                                    <div class="absolute -bottom-8 left-4">
                                        <div class="h-16 w-16 bg-[#27272a] rounded-xl border-4 border-[#3d3d40] overflow-hidden">
                                            @if($brand->image)
                                                <img src="{{ Storage::url($brand->image) }}"
                                                     alt="{{ $brand->brand_name }}"
                                                     class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-2xl font-bold text-gray-400">
                                                    {{ substr($brand->brand_name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Current Brand Indicator -->
                                    @if(auth()->user()->current_brand_id === $brand->id)
                                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                Currently Active
                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Brand Content -->
                                <div class="pt-10 p-4 flex flex-col flex-grow">
                                    <!-- Top section: Title and badge -->
                                    <div class="flex items-start justify-between mb-2 flex-shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-semibold text-white truncate">{{ $brand->brand_name ? $brand->brand_name : 'Unnamed Brand' }}</h3>
                                            <p class="text-sm text-gray-400 truncate">by {{ $brand->user->name }}</p>
                                        </div>
                                    </div>

                                    <!-- Middle section: Details - Takes available space -->
                                    <div class="space-y-2 mb-4 flex-grow">
                                        @if($brand->category)
                                            <div class="flex items-center text-sm text-gray-400">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                                </svg>
                                                <span class="truncate">{{ $brand->category }} @if($brand->sub_category) / {{ $brand->sub_category }} @endif</span>
                                            </div>
                                            @else
                                            <div class="flex items-center text-sm text-gray-400">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                                </svg>
                                                <span class="truncate">Uncategorized</span>
                                            </div>
                                        @endif

                                        <div class="flex items-center text-sm text-gray-400">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <span>{{ $brand->products->count() ?? 0 }} product{{ $brand->products->count() != 1 ? 's' : '' }}</span>
                                        </div>

                                        @if($brand->city || $brand->state)
                                            <div class="flex items-center text-sm text-gray-400">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span class="truncate">{{ $brand->city }}{{ $brand->state ? ', ' . $brand->state : '' }}</span>
                                            </div>
                                            @else
                                                <div class="flex items-center text-sm text-gray-400">
                                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <span class="truncate">Location not specified</span>
                                                </div>
                                        @endif
                                    </div>

                                    <!-- Bottom section: Switch Button - Always at bottom -->
                                    <div class="mt-auto pt-4">
                                        @if(auth()->user()->current_brand_id === $brand->id)
                                            <button disabled
                                                    class="w-full px-4 py-2 bg-green-600/50 text-green-200 rounded-md cursor-not-allowed text-sm font-medium">
                                                Currently Active
                                            </button>
                                        @else
                                            <flux:button wire:click="switch({{ $brand->id }})"
                                                class="w-full justify-center"
                                                size="sm"
                                                variant="primary">
                                                Switch to this Brand
                                            </flux:button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Empty State - Full width -->
                        <div class="col-span-1 md:col-span-2 lg:col-span-3">
                            <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                                <div class="text-center py-16">
                                    <div class="inline-flex items-center justify-center w-24 h-24 bg-[#27272a] rounded-full mb-6">
                                        <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-4H7v4"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-white mb-2">No Brands Yet</h3>
                                    <p class="text-gray-400 mb-6">You haven't created any brands.</p>
                                    <a href="{{ route('brands.create') }}"
                                       class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Create Your First Brand
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</section>
