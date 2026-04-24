<section class="w-full">
    @include('partials.partnerships')

    <flux:heading class="sr-only">{{$store->store_name}}</flux:heading>
    <x-dropshippers.layout :heading="__('Manage Store')" :subheading="__('Edit or delete your products')">

        <div class="flex justify-end mb-4 gap-x-2">
            <flux:button size="sm" variant="primary" wire:click="editStore">
                Edit Store Details
            </flux:button>
            <flux:button href="{{route('dropshipper-store', $store)}}" size="sm" variant="primary">
                Visit Store
            </flux:button>
        </div>

        <flux:separator/>

        <form wire:submit="submit" class="mt-2">
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
                                                @if($product->originalProduct->images->count() > 0)
                                                    <img src="{{ $product->originalProduct->primary_image_url }}"
                                                         alt="{{ $product->originalProduct->name }}"
                                                         class="w-10 h-10 object-cover rounded-full">
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                        <span class="text-gray-300 font-medium">{{ substr($product->originalProduct->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-200">
                                                        {{ $product->originalProduct->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $product->created_at->format('M d, Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                <button
                                                    wire:click="editProduct({{ $product }})"
                                                    class="text-gray-400 transition-colors"
                                                    title="Edit selling price"
                                                    wire:key="edit-product{{$product}}"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
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

                                            @if($product->originalProduct->images->count() > 0)
                                                <img src="{{ $product->originalProduct->primary_image_url }}"
                                                     alt="{{ $product->originalProduct->name }}"
                                                     class="object-cover h-10 w-10 rounded-full">
                                            @else
                                                <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                    <span class="text-gray-300 font-medium">{{ substr($product->originalProduct->name, 0, 1) }}</span>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="font-medium text-gray-200">{{ Str::limit($product->originalProduct->name, 20) }}</div>
                                                <div class="text-xs text-gray-500">{{ $product->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button
                                                wire:click="editProduct({{ $product }})"
                                                class="p-2 text-gray-400 transition-colors"
                                                wire:key="editProduct{{$product}}"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
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
                        </div>
                    @endif
                </div>

                @if($products->hasPages())
                    <div class="mt-6">
                        <flux:pagination :paginator="$products" />
                    </div>
                @endif

                <!-- Delete Modal -->
                @if($showEditModal)
                    <div class="fixed inset-0 bg-black/70 bg-opacity-20 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-[1.2rem] mb-2">{{ $selectedProduct->originalProduct->name}}</h3>
                            <flux:separator />
                            <div class="mt-2 flex flex-col gap-y-3 mb-2">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-white font-medium">Dropship Price</p>
                                    </div>
                                    <div class="sm:text-right">
                                        <p class="text-white font-medium">₦{{number_format($selectedProduct->originalProduct->dropship_price)}}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-white font-medium">Selling Price</p>
                                    </div>
                                    <div class="sm:text-right">
                                        <p class="text-white font-medium">₦{{number_format($selectedProduct->custom_price)}}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-white font-medium">Profit</p>
                                    </div>
                                    <div class="sm:text-right">
                                        <p class="text-white font-medium">₦{{number_format($selectedProduct->profit)}}</p>
                                    </div>
                                </div>
                            </div>
                            <flux:separator />
                            <form wire:submit="updateProduct" class="mt-2">
                                <flux:fieldset>
                                    <div class="space-y-4">
                                        <flux:input
                                            label="Selling Price"
                                            wire:model="price"
                                            placeholder="price"
                                            class="max-full"
                                        />
                                        <div class="flex justify-end items-center">
                                            <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                                Cancel
                                            </flux:button>
                                            <flux:button type="submit" size="sm" variant="primary" class="ml-2">
                                                <flux:icon.loading wire:loading wire:target="save" />
                                                <span wire:loading.remove wire:target="save">Update</span>
                                            </flux:button>
                                        </div>
                                    </div>
                                </flux:fieldset>
                            </form>
                        </div>
                    </div>
                @endif

                @if($showEditStoreModal)
                    <div class="fixed inset-0 bg-black/70 bg-opacity-20 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">

                            <form wire:submit="updateStore" class="mt-2">
                                <flux:fieldset>
                                    <div>
                                        <flux:label class="mb-2">Store Name</flux:label>
                                        <flux:input
                                            wire:model.live="storeName"
                                            placeholder="e.g., John's Nike Store"
                                            class="w-full"
                                            :class="$errors->has('storeName') ? 'border-red-500' : ''"
                                        />
                                        <div class="flex justify-between mt-1">
                                            <flux:error name="storeName" />
                                            <span class="text-xs text-gray-500">{{ strlen($storeName ?? '') }}/100</span>
                                        </div>
                                    </div>

                                    <!-- Store URL / Slug -->
                                    <div>
                                        @if(strlen($storeSlug ?? '') > 0)
                                            <div class="mt-2 flex items-center space-x-2">
                                                @if($isCheckingSlug)
                                                    <svg class="animate-spin h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    <span class="text-sm text-gray-400">Checking availability...</span>
                                                @elseif($slugAvailable && !$errors->has('storeSlug'))
                                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="text-sm text-green-400">URL is available!</span>
                                                @elseif(!$slugAvailable)
                                                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"></circle>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 8l8 8M16 8l-8 8"></path>
                                                    </svg>
                                                    <span class="text-sm text-red-500">URL is NOT available!</span>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- URL preview -->
                                        @if(strlen($storeSlug ?? '') > 0 && !$errors->has('storeSlug'))
                                            <div class="mt-2 text-xs text-gray-500">
                                                Full URL: <span class="text-blue-400">www.knkings.com/store/{{ $storeSlug }}</span>
                                            </div>
                                        @endif

                                        <flux:error name="storeSlug" class="mt-1" />
                                    </div>

                                    <!-- Tips Box -->
                                    <div class="bg-[#27272a] rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-300 mb-2 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            URL Tips
                                        </h4>
                                        <ul class="text-xs text-gray-400 space-y-1 ml-6 list-disc">
                                            <li>Use only lowercase letters, numbers, and hyphens</li>
                                            <li>Keep it short and memorable</li>
                                            <li>Avoid special characters and spaces</li>
                                            <li>Minimum 3 characters</li>
                                        </ul>
                                    </div>

                                    <flux:separator />

                                    <div class="space-y-4 mt-2">
                                        <div class="flex justify-end items-center">
                                            <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                                Cancel
                                            </flux:button>
                                            <flux:button type="submit" size="sm" variant="primary" class="ml-2">
                                                <flux:icon.loading wire:loading wire:target="updateStore" />
                                                <span wire:loading.remove wire:target="updateStore">Update</span>
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
