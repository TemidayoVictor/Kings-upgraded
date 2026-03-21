
<section class="w-full">
    @include('partials.products-settings-heading')
    <x-brands.dropshippers :heading="__('Dropshippers')" :subheading="__('Manage your dropshippers')">
        <flux:heading class="sr-only">{{ __('Manage Dropshippers') }}</flux:heading>

        <div class="flex justify-end mb-4">
            <flux:button href="{{ route('brand-pending-applications') }}" size="sm" variant="primary">
                View Pending Applications
            </flux:button>
        </div>

        <flux:separator/>

        <div class="min-h-screen">
            <div class="max-w-7xl mx-auto">
                <!-- Header with Filters -->
                <div class="my-4">
                    <div class="flex items-center space-x-2">
                        <flux:input type="search"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search dropshippers..."
                            class="w-64"
                        />
                    </div>
                </div>

                <!-- Approved Dropshippers Grid -->
                <div class="grid grid-cols-1 gap-6">
                    @forelse($approvedDropshippers as $item)
                        <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow flex flex-col h-full">
                            <!-- Header with gradient -->
                            <div class="h-24 bg-gradient-to-r from-green-900/40 to-[#3d3d40] relative flex-shrink-0">
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-green-500/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>

                                <!-- Dropshipper Avatar -->
                                <div class="absolute -bottom-8 left-4">
                                    <div class="h-16 w-16 bg-[#27272a] rounded-full border-4 border-[#3d3d40] overflow-hidden">
                                        @if($item['dropshipper']->image)
                                            <img src="{{ Storage::url($item['dropshipper']->image) }}"
                                                 alt="{{ $item['dropshipper']->user->name }}"
                                                 class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-2xl font-bold text-green-400">
                                                {{ substr($item['dropshipper']->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="pt-10 p-4 flex flex-col flex-grow">
                                <!-- Top section -->
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">{{ $item['dropshipper']->user->name }}</h3>
                                        <p class="text-sm text-gray-400">@ {{ $item['dropshipper']->username }}</p>
                                    </div>

                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                        Approved
                                    </span>
                                </div>

                                <!-- Stats -->
                                <div class="grid grid-cols-2 gap-2 mb-4">
                                    <div class="bg-[#27272a] rounded-lg p-2 text-center">
                                        <div class="text-xl font-bold text-white">{{ $item['stores_count'] }}</div>
                                        <div class="text-xs text-gray-500">Stores</div>
                                    </div>
                                    <div class="bg-[#27272a] rounded-lg p-2 text-center">
                                        <div class="text-xl font-bold text-white">{{ $item['total_products'] }}</div>
                                        <div class="text-xs text-gray-500">Products</div>
                                    </div>
                                </div>

                                <!-- Stores List -->
                                @if(count($item['stores']) > 0)
                                    <div class="mb-4 flex-grow">
                                        <h4 class="text-xs font-medium text-gray-500 mb-2">ACTIVE STORES</h4>
                                        <div class="space-y-2">
                                            @foreach($item['stores'] as $store)
                                                <div class="flex items-center justify-between bg-[#27272a] rounded-lg p-2">
                                                    <div class="flex items-center space-x-2">
                                                        <div class="w-6 h-6 bg-[#3d3d40] rounded flex items-center justify-center">
                                                            <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="text-xs text-gray-300 truncate max-w-[120px]">{{ $store->store_name }}</span>
                                                    </div>
                                                    <span class="text-xs {{ $store->status === 'active' ? 'text-green-400' : 'text-gray-500' }}">
                                                        {{ ucfirst($store->status) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="mt-auto pt-4 flex space-x-2">
                                    <flux:button wire:click="viewDetails({{ $item['dropshipper']->id }})"
                                                 class="flex-1 justify-center"
                                                 size="sm"
                                                 variant="primary">
                                        View Details
                                    </flux:button>

                                    <flux:button wire:click="revokeAccess({{ $item['dropshipper']->id }}, {{ $item['brand']->id }})"
                                                 class="flex-1 justify-center"
                                                 size="sm"
                                                 variant="danger">
                                        Revoke
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 px-4">
                            <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No approved dropshippers</h3>
                            <p class="mt-1 text-sm text-gray-500">When you approve applications, they'll appear here.</p>
                            <div class="mt-6">
                                <flux:button href="{{ route('brand-pending-applications') }}" size="sm" variant="primary">
                                    Review Applications
                                </flux:button>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if(method_exists($approvedDropshippers, 'links'))
                    <div class="mt-6">
                        {{ $approvedDropshippers->links() }}
                    </div>
                @endif

                <!-- Dropshipper Details Modal -->
                @if($showDetailsModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                            <div class="px-6 py-4 border-b border-gray-600 flex items-center justify-between">
                                <h3 class="text-lg font-medium text-white">Dropshipper Details</h3>
                                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            @if($selectedDropshipper)
                                <div class="p-6 space-y-6">
                                    <!-- Profile -->
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-20 w-20 bg-[#3d3d40] rounded-full overflow-hidden">
                                            @if($selectedDropshipper->image)
                                                <img src="{{ Storage::url($selectedDropshipper->image) }}"
                                                     alt="{{ $selectedDropshipper->user->name }}"
                                                     class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-3xl font-bold text-gray-400">
                                                    {{ substr($selectedDropshipper->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-xl font-bold text-white">{{ $selectedDropshipper->user->name }}</h4>
                                            <p class="text-gray-400">@ {{ $selectedDropshipper->username }}</p>
                                            <p class="text-sm text-gray-500">{{ $selectedDropshipper->user->email }}</p>
                                        </div>
                                    </div>

                                    <!-- Stats Grid -->
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="bg-[#3d3d40] rounded-lg p-4 text-center">
                                            <div class="text-2xl font-bold text-white">{{ $dropshipperStats['total_stores'] }}</div>
                                            <div class="text-xs text-gray-400">Total Stores</div>
                                        </div>
                                        <div class="bg-[#3d3d40] rounded-lg p-4 text-center">
                                            <div class="text-2xl font-bold text-white">{{ $dropshipperStats['active_stores'] }}</div>
                                            <div class="text-xs text-gray-400">Active Stores</div>
                                        </div>
                                        <div class="bg-[#3d3d40] rounded-lg p-4 text-center">
                                            <div class="text-2xl font-bold text-white">{{ $dropshipperStats['total_products'] }}</div>
                                            <div class="text-xs text-gray-400">Products</div>
                                        </div>
                                    </div>

                                    <!-- Bank Details -->
                                    @if($selectedDropshipper->account_name)
                                        <div class="bg-[#3d3d40] rounded-lg p-4">
                                            <h5 class="text-sm font-medium text-gray-400 mb-2">Payment Details</h5>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <div class="text-xs text-gray-500">Account Name</div>
                                                    <div class="text-sm text-white">{{ $selectedDropshipper->account_name }}</div>
                                                </div>
                                                <div>
                                                    <div class="text-xs text-gray-500">Account Number</div>
                                                    <div class="text-sm text-white">{{ $selectedDropshipper->account_number }}</div>
                                                </div>
                                                <div>
                                                    <div class="text-xs text-gray-500">Bank Name</div>
                                                    <div class="text-sm text-white">{{ $selectedDropshipper->bank_name }}</div>
                                                </div>
                                                <div>
                                                    <div class="text-xs text-gray-500">Total Revenue</div>
                                                    <div class="text-sm text-white">${{ number_format($selectedDropshipper->revenue ?? 0, 2) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Stores List -->
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-400 mb-3">Stores ({{ count($dropshipperStores) }})</h5>
                                        <div class="space-y-3">
                                            @foreach($dropshipperStores as $store)
                                                <div class="bg-[#3d3d40] rounded-lg p-4">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <h6 class="text-white font-medium">{{ $store->store_name }}</h6>
                                                            <p class="text-xs text-gray-500">Created {{ $store->created_at->format('M d, Y') }}</p>
                                                        </div>
                                                        <span class="px-2 py-1 text-xs rounded-full {{ $store->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                                            {{ ucfirst($store->status) }}
                                                        </span>
                                                    </div>
                                                    <div class="mt-2 flex items-center justify-between text-sm">
                                                        <span class="text-gray-400">{{ $store->products_count ?? 0 }} products</span>
                                                        <a href="#" class="text-blue-400 hover:text-blue-300 text-xs">View Store →</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="px-6 py-4 border-t border-gray-600 flex justify-end">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Close
                                </flux:button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Revoke Access Modal -->
                @if($showRevokeModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-medium text-white mb-4">Revoke Access</h3>

                            <p class="text-gray-300 mb-4">
                                Are you sure you want to revoke access for this dropshipper?
                                This will deactivate all their stores for your brand.
                            </p>

                            <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-3 mb-4">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-yellow-500 font-medium">Warning</p>
                                        <p class="text-xs text-yellow-500/80">This action cannot be undone. The dropshipper will need to reapply if you change your mind.</p>
                                    </div>
                                </div>
                            </div>

                            <form wire:submit="confirmRevoke">
                                <div class="space-y-4">
                                    <div>
                                        <flux:label>Reason for revoking <span class="text-red-400">*</span></flux:label>
                                        <textarea
                                            wire:model.defer="revokeReason"
                                            rows="3"
                                            class="w-full rounded-md border-gray-600 bg-[#3d3d40] text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 mt-3 p-2 text-[.9rem]"
                                            placeholder="Please provide a reason..."
                                            required
                                        ></textarea>
                                        <flux:error name="revokeReason" />
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                            Cancel
                                        </flux:button>
                                        <flux:button type="submit" size="sm" variant="danger">
                                            <flux:icon.loading wire:loading wire:target="confirmRevoke" />
                                            <span wire:loading.remove wire:target="confirmRevoke">Yes, Revoke Access</span>
                                        </flux:button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </x-brands.dropshippers>
</section>
