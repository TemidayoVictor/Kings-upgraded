<section class="w-full">
    @include('partials.products-heading')

    <flux:heading class="sr-only">{{ __('Manage Products') }}</flux:heading>
    <x-products.layout :heading="__('Manage Products')" :subheading="__('Edit or delete your products')">
        <form wire:submit="submit">
            <flux:fieldset>
                <div class="space-y-4">
                    <flux:input
                        label="Search Products"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search"
                        class="max-full" />
                    <flux:separator />
                </div>
            </flux:fieldset>
        </form>

        <div class="min-h-screen">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 my-3">
                    <flux:heading class="sr-only">{{ __('Product List') }}</flux:heading>
                </div>

                <!-- Sections List -->
                <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    @if($products->count() > 0)
                        <!-- Desktop Table View (hidden on mobile) -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-500">
                                <thead class="bg-[#3d3d40]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 tracking-wider">
                                        <button class="flex items-center uppercase space-x-1 hover:text-gray-200">
                                            <span>Products</span>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                                @foreach($products as $product)
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($product->images->count() > 0)
                                                    <img src="{{ $product->primary_image_url }}"
                                                         alt="{{ $product->name }}"
                                                         class="w-10 h-10 object-cover rounded-full">
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                        <span class="text-gray-300 font-medium">{{ substr($product->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-200">
                                                        {{ $product->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $product->created_at->format('M d, Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
{{--                                                <button--}}
{{--                                                    wire:click="popup('edit', {{ $product->id }})"--}}
{{--                                                    class="text-gray-400 hover:text-gray-200 transition-colors"--}}
{{--                                                    title="View product"--}}
{{--                                                    type="button"--}}
{{--                                                >--}}
{{--                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />--}}
{{--                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />--}}
{{--                                                    </svg>--}}
{{--                                                </button>--}}
                                                <a
                                                    class="text-gray-400 hover:text-gray-200 transition-colors"
                                                    title="Edit product"
                                                    href="{{ route('brand-edit-product', ['product' => $product]) }}"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>

                                                <button
                                                    wire:click="confirmDelete({{ $product }})"
                                                    class="text-gray-400 hover:text-red-400 transition-colors"
                                                    title="Delete product"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View (visible only on mobile) -->
                        <div class="sm:hidden divide-y divide-gray-500">
                            @foreach($products as $product)
                                <div class="p-4 hover:bg-gray-750 transition-colors">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center space-x-3">

                                            @if($product->images->count() > 0)
                                                <img src="{{ $product->primary_image_url }}"
                                                     alt="{{ $product->name }}"
                                                     class="object-cover h-10 w-10 rounded-full">
                                            @else
                                                <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                    <span class="text-gray-300 font-medium">{{ substr($product->name, 0, 1) }}</span>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="font-medium text-gray-200">{{ Str::limit($product->name, 20) }}</div>
                                                <div class="text-xs text-gray-500">{{ $product->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
{{--                                            <button--}}
{{--                                                wire:click="popup('edit', {{ $product->id }})"--}}
{{--                                                class="text-gray-400 hover:text-gray-200 transition-colors"--}}
{{--                                                type="button"--}}
{{--                                            >--}}
{{--                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />--}}
{{--                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />--}}
{{--                                                </svg>--}}
{{--                                            </button>--}}
                                            <a
                                                class="text-gray-400 hover:text-gray-200 transition-colors"
                                                title="Edit product"
                                                href="{{ route('brand-edit-product', ['product' => $product]) }}"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <button
                                                wire:click="confirmDelete({{ $product }})"
                                                class="p-2 text-gray-400 hover:text-red-400 transition-colors"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-4">
                            <svg class="mx-auto h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No Product Found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding a new product.</p>
                            <a href="{{ route('brand-add-product')  }}" variant="primary">
                                <flux:button type="button" size="sm" class="mt-2" variant="primary">
                                    <span>{{ __('Add Product') }}</span>
                                </flux:button>
                            </a>
                        </div>
                    @endif
                </div>

                @if($products->hasPages())
                    <div class="mt-6">
                        <flux:pagination :paginator="$products" />
                    </div>
                @endif

                <!-- Delete Modal -->
                @if($showDeleteModal)
                    <div class="fixed inset-0 bg-black/70 bg-opacity-20 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <form wire:submit="delete">
                                <flux:fieldset>
                                    <div class="space-y-4">
                                        <p class="text-white mb-4"> Are you sure you want to delete "{{ $selectedProduct->name }}"? </p>
                                        <div class="flex justify-end items-center">
                                            <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                                Cancel
                                            </flux:button>
                                            <flux:button type="submit" size="sm" variant="danger" class="ml-2">
                                                <flux:icon.loading wire:loading wire:target="save" />
                                                <span wire:loading.remove wire:target="save">{{ __('Delete') }}</span>
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
    </x-products.layout>
</section>
