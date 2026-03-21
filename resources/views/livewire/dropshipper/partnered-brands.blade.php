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
                    @forelse($brands as $brand)
                        <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow flex flex-col h-full">
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
                            </div>

                            <!-- Brand Content - Takes remaining space and pushes button to bottom -->
                            <div class="pt-10 p-4 flex flex-col flex-grow">
                                <!-- Top section: Title and badge -->
                                <div class="flex items-start justify-between mb-2 flex-shrink-0">
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">{{ $brand->brand_name }}</h3>
                                        <p class="text-sm text-gray-400">by {{ $brand->user->name }}</p>
                                    </div>

                                    <!-- Application Status Badge -->
                                    @if(isset($applicationStatuses[$brand->id]))
                                        @if($applicationStatuses[$brand->id] === 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 whitespace-nowrap flex-shrink-0">
                                                Pending
                                            </span>
                                        @elseif($applicationStatuses[$brand->id] === 'approved')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30 whitespace-nowrap flex-shrink-0">
                                                Approved
                                            </span>
                                        @elseif($applicationStatuses[$brand->id] === 'rejected')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30 whitespace-nowrap flex-shrink-0">
                                                Rejected
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                <!-- Middle section: Details - Takes available space -->
                                <div class="space-y-2 mb-4 flex-grow">
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                        </svg>
                                        <span class="truncate">{{ $brand->category }} @if($brand->sub_category) / {{ $brand->sub_category }} @endif</span>
                                    </div>

                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <span>{{ $brand->no_of_products ?? 0 }} products</span>
                                    </div>

                                    @if($brand->city || $brand->state)
                                        <div class="flex items-center text-sm text-gray-400">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="truncate">{{ $brand->city }}{{ $brand->state ? ', ' . $brand->state : '' }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Bottom section: Action Button - Always at bottom -->
                                <div class="mt-auto pt-4">
                                    @if(!isset($applicationStatuses[$brand->id]))
                                        <flux:button wire:click="apply({{ $brand->id }})"
                                                     class="w-full justify-center"
                                                     size="sm"
                                                     variant="primary">
                                            Apply to Dropship
                                        </flux:button>
                                    @elseif($applicationStatuses[$brand->id] === 'approved')
                                        <a href="{{ route('dropshipper.stores.create', $brand) }}"
                                           class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm">
                                            Create Store
                                        </a>
                                    @elseif($applicationStatuses[$brand->id] === 'pending')
                                        <button disabled
                                                class="w-full px-4 py-2 bg-yellow-600/50 text-yellow-200 rounded-md cursor-not-allowed text-sm">
                                            Application Pending
                                        </button>
                                    @elseif($applicationStatuses[$brand->id] === 'rejected')
                                        <button disabled
                                                class="w-full px-4 py-2 bg-red-600/50 text-red-200 rounded-md cursor-not-allowed text-sm">
                                            Not Approved
                                        </button>
                                    @endif
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

                {{--                @if($brands->hasPages())--}}
                {{--                    <div class="mt-6">--}}
                {{--                        {{ $brands->links() }}--}}
                {{--                    </div>--}}
                {{--                @endif--}}

                @if($brands->hasPages())
                    <div class="mt-6">
                        <flux:pagination :paginator="$brands" />
                    </div>
                @endif

                <!-- Application Modal -->
                @if($showApplicationModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-medium text-white mb-4">Apply to {{ $selectedBrand?->brand_name }}</h3>

                            <form wire:submit="submitApplication">
                                <flux:fieldset>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                                Notes (Optional)
                                            </label>
                                            <textarea
                                                wire:model="applicationNotes"
                                                rows="4"
                                                class="w-full rounded-md border-gray-600 bg-[#3d3d40] text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-[.9rem] p-2"
                                                placeholder="Tell the brand owner why you'd like to dropship their products..."
                                            ></textarea>
                                        </div>

                                        <div class="flex justify-end space-x-2">
                                            <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                                Cancel
                                            </flux:button>
                                            <flux:button type="submit" variant="primary" size="sm">
                                                <flux:icon.loading wire:loading wire:target="submitApplication" />
                                                <span wire:loading.remove wire:target="submitApplication">Submit Application</span>
                                            </flux:button>
                                        </div>
                                    </div>
                                </flux:fieldset>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-dropshippers.layout>
</section>
