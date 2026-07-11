{{-- resources/views/livewire/admin/product-manager.blade.php --}}

<section class="w-full">
    @include('partials.admin-heading')

    <flux:heading class="sr-only">
        {{ __('Manage Products') }}
    </flux:heading>

    <div class="flex justify-between items-center mb-4 gap-4">
        <div class="flex-1 max-w-md">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search products..."
                type="search"
            />
        </div>
    </div>

    <flux:separator />

    <div class="min-h-screen mt-3">
        <div class="max-w-7xl mx-auto">

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

                {{-- Total --}}
                <div
                    wire:click="setFilter('all')"
                    class="rounded-lg p-4 cursor-pointer transition-all border
                    {{ $filter === 'all'
                        ? 'bg-blue-500/20 border-blue-500'
                        : 'bg-[#3d3d40] border-transparent hover:bg-[#4a4a4d]'
                    }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Total Products</p>
                            <p class="text-2xl font-bold text-blue-500">
                                {{ $totalProducts }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Active --}}
                <div
                    wire:click="setFilter('active')"
                    class="rounded-lg p-4 cursor-pointer transition-all border
                    {{ $filter === 'active'
                        ? 'bg-green-500/20 border-green-500'
                        : 'bg-[#3d3d40] border-transparent hover:bg-[#4a4a4d]'
                    }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Active Products</p>
                            <p class="text-2xl font-bold text-green-400">
                                {{ $activeProducts }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Featured --}}
                <div
                    wire:click="setFilter('featured')"
                    class="rounded-lg p-4 cursor-pointer transition-all border
                    {{ $filter === 'featured'
                        ? 'bg-purple-500/20 border-purple-500'
                        : 'bg-[#3d3d40] border-transparent hover:bg-[#4a4a4d]'
                    }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Featured Products</p>
                            <p class="text-2xl font-bold text-purple-400">
                                {{ $featuredProducts }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Inactive --}}
                <div
                    wire:click="setFilter('inactive')"
                    class="rounded-lg p-4 cursor-pointer transition-all border
                    {{ $filter === 'inactive'
                        ? 'bg-yellow-500/20 border-yellow-500'
                        : 'bg-[#3d3d40] border-transparent hover:bg-[#4a4a4d]'
                    }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Inactive Products</p>
                            <p class="text-2xl font-bold text-yellow-400">
                                {{ $inactiveProducts }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Out of Stock --}}
                <div
                    wire:click="setFilter('out_of_stock')"
                    class="rounded-lg p-4 cursor-pointer transition-all border
                    {{ $filter === 'out_of_stock'
                        ? 'bg-red-500/20 border-red-500'
                        : 'bg-[#3d3d40] border-transparent hover:bg-[#4a4a4d]'
                    }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Out of Stock</p>
                            <p class="text-2xl font-bold text-red-400">
                                {{ $outOfStockProducts }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">

                @if($products->count() > 0)

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-500">

                            <thead class="bg-[#3d3d40]">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Product
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Brand
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Price
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Stock
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Featured
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase">
                                    Actions
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Added
                                </th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-500">

                            @foreach($products as $product)

                                <tr class="hover:bg-[#4a4a4d] transition-colors">

                                    {{-- Product --}}
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-200">
                                                {{ $product->name }}
                                            </div>

                                            <div class="text-xs text-gray-500 line-clamp-1">
                                                {{ Str::limit($product->description, 50) }}
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Brand --}}
                                    <td class="px-6 py-4 text-sm text-gray-300 whitespace-nowrap">
                                        {{ $product->brand?->brand_name ?? 'N/A' }}
                                    </td>

                                    {{-- Price --}}
                                    <td class="px-6 py-4 text-sm text-gray-300 whitespace-nowrap">
                                        <div>
                                            <div>₦{{ number_format($product->price) }}</div>
                                            @if($product->sales_price)
                                                <div class="text-xs text-green-400">
                                                    Sale: ₦{{ number_format($product->sales_price) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Stock --}}
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        <span class="{{ $product->stock > 0 ? 'text-green-400' : 'text-red-400' }}">
                                            {{ number_format($product->stock) }}
                                        </span>
                                    </td>

                                    {{-- Featured --}}
                                    <td class="px-6 py-4">
                                        @if($product->is_featured)
                                            <span class="px-2 py-1 text-xs rounded-full bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                                <flux:icon.star class="w-3 h-3 inline mr-1" />
                                                Featured
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                                Not Featured
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">
                                        @if($product->is_active)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-1" wire:click.stop>
                                            <flux:dropdown position="bottom" align="end" offset="-15">
                                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                                <flux:menu>
                                                    <flux:menu.item wire:click="openModal({{ $product->id }}, 'feature')" wire:key="feature">
                                                        @if($product->is_featured)
                                                            Remove Featured
                                                        @else
                                                            Make Featured
                                                        @endif
                                                    </flux:menu.item>

                                                    <flux:menu.item wire:click="toggleActive({{ $product->id }})" wire:confirm="Are you sure you want to {{ $product->is_active ? 'deactivate' : 'activate' }} this product?">
                                                        {{ $product->is_active ? 'Deactivate' : 'Activate' }}
                                                    </flux:menu.item>

                                                    @if($product->brand)
                                                        <flux:menu.item href="{{ route('shop', $product->brand) }}">
                                                            View Brand
                                                        </flux:menu.item>
                                                    @endif
                                                </flux:menu>
                                            </flux:dropdown>
                                        </div>
                                    </td>

                                    {{-- Added --}}
                                    <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">
                                        {{ $product->created_at?->format('M d, Y') }}
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>

                @else

                    <div class="text-center py-12">
                        <h3 class="text-sm font-medium text-gray-300">
                            No products found
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            No products match this filter.
                        </p>
                    </div>

                @endif
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    {{-- Modal --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
            <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                @if($type == 'feature')

                    <h3 class="text-lg font-medium text-white mb-4">
                        {{ $selectedProduct->featured ? 'Remove Featured' : 'Make Featured' }}
                    </h3>

                    <div class="space-y-4">
                        <div class="bg-[#3d3d40] rounded-lg p-4">
                            <p class="text-sm text-gray-300">
                                <span class="font-medium text-white">{{ $selectedProduct->name }}</span>
                            </p>

                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-sm text-gray-400">Brand:</span>
                                <span class="text-sm text-white">{{ $selectedProduct->brand?->brand_name ?? 'N/A' }}</span>
                            </div>

                            <div class="mt-1 flex items-center gap-2">
                                <span class="text-sm text-gray-400">Current Status:</span>
                                <span class="text-sm text-purple-400">
                                    {{ $selectedProduct->is_featured ? 'Featured' : 'Not Featured' }}
                                </span>
                            </div>
                        </div>

                        <p class="text-sm text-gray-400">
                            {{ $selectedProduct->featured
                                ? 'This product will no longer appear in the featured products section.'
                                : 'This product will appear in the featured products section.'
                            }}
                        </p>

                        <div class="flex justify-end space-x-2">
                            <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                Cancel
                            </flux:button>

                            <flux:button type="button" size="sm" variant="primary" wire:click="toggleFeature">
                                <flux:icon.loading wire:loading wire:target="toggleFeature" />

                                <span wire:loading.remove wire:target="toggleFeature">
                                    {{ $selectedProduct->is_featured ? 'Remove' : 'Make Featured' }}
                                </span>
                            </flux:button>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    @endif
</section>
