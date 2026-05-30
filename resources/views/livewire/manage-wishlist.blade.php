{{-- resources/views/livewire/shop/user-wishlist.blade.php --}}
<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('My Saved Wishlist Items') }}</flux:heading>

    <x-settings.layout :heading="__('My Wishlist')" :subheading="__('Manage your saved curated items and product collections across brands.')">
        <div class="space-y-6">
            @if(!$wishlistItems)
                <!-- Minimalist Balanced Empty State Placeholder Box -->
                <div class="text-center py-12 px-4">
                    <svg class="mx-auto h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-300">No Items in Wishlist</h3>
                    <p class="mt-1 text-sm text-gray-500">Items added to your wishlist will be available here</p>
                </div>
            @else
                <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    @if($wishlistItems->count() > 0)
                        <!-- Desktop Table View (hidden on mobile) -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-500">
                                <thead class="bg-[#3d3d40]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 tracking-wider">
                                        <button class="flex items-center uppercase space-x-1 hover:text-gray-200">
                                            <span>Items</span>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Store
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                                @foreach($wishlistItems as $item)
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-start">
                                                @if($item->product->images->count() > 0)
                                                    <img src="{{ $item->product->primary_image_url }}"
                                                         alt="{{ $item->product->name }}"
                                                         class="w-10 h-10 object-cover rounded-full">
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                        <span class="text-gray-300 font-medium">{{ substr($item->product->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-200">
                                                        {{ $item->product->name }}
                                                    </div>
                                                    <div class="text-[.9rem] font-medium text-gray-200">
                                                        ₦{{ number_format($item->product->price, 0, 2) }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $item->created_at->format('M d, Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                <flux:button size="sm" variant="primary" href="{{route('shop', ['brand' => $item->product->brand, 'search' => $item->product->name])}}">
                                                    View item
                                                </flux:button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View (visible only on mobile) -->
                        <div class="sm:hidden divide-y divide-gray-500">
                            @foreach($wishlistItems as $item)
                                <div class="p-4 hover:bg-gray-750 transition-colors">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-start space-x-3">

                                            @if($item->product->images->count() > 0)
                                                <img src="{{ $item->product->primary_image_url }}"
                                                     alt="{{ $item->product->name }}"
                                                     class="object-cover h-10 w-10 rounded-full">
                                            @else
                                                <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                    <span class="text-gray-300 font-medium">{{ substr($item->product->name, 0, 1) }}</span>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="font-medium text-gray-200">{{ Str::limit($item->product->name, 20) }}</div>
                                                <div class="text-[.9rem] font-medium text-gray-200">
                                                    ₦{{ number_format($item->product->price, 0, 2) }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $item->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <flux:button size="sm" variant="primary" href="{{route('shop', $item->product->brand)}}">
                                                Visit store
                                            </flux:button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </x-settings.layout>
</section>
