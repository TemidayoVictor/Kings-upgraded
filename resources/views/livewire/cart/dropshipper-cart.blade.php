
<div class="min-h-screen bg-[#1a1a1c] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-light text-white mb-2">Shopping Cart</h1>
            <p class="text-gray-400">{{ $itemCount }} {{ Str::plural('item', $itemCount) }} in your cart</p>
        </div>

        @if(count($cartItems) > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="flex-1">
                    <div class="bg-[#252528] rounded-2xl overflow-hidden">
                        <!-- Desktop Table -->
                        <div class="hidden md:block">
                            <table class="w-full">
                                <thead class="bg-[#1a1a1c] border-b border-gray-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                @foreach($cartItems as $item)
                                    <tr class="hover:bg-[#2a2a2d] transition-colors" wire:key="item-{{ $item->id }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($item->dropshipperProduct->originalProduct && $item->dropshipperProduct->originalProduct->images->count() > 0)
                                                    <img src="{{ $item->dropshipperProduct->originalProduct->primary_image_url }}"
                                                         alt="{{ $item->product_name }}"
                                                         class="w-20 h-20 object-cover rounded-lg">
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
{{--                                                        <span class="text-gray-300 font-medium">{{ substr($item->product->name, 0, 1) }}</span>--}}
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-white">{{ $item->product_name }}</div>
                                                    @if($item->options)
                                                        <div class="text-xs text-gray-400 mt-1">
                                                            @foreach($item->options as $key => $value)
                                                                <span class="capitalize">{{ $key }}: {{ $value }}</span>{{ !$loop->last ? ' | ' : '' }}
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    @if($item->sku)
                                                        <div class="text-xs text-gray-500 mt-1">SKU: {{ $item->sku }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm">
                                                @if($item->discount_price)
                                                    <span class="text-gray-400 line-through">₦{{ number_format($item->unit_price) }}</span>
                                                    <span class="text-green-400 ml-2">₦{{ number_format($item->discount_price) }}</span>
                                                @else
                                                    <span class="text-white">₦{{ number_format($item->unit_price) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <button
                                                    wire:click="decrement({{ $item->id }})"
                                                    class="w-8 h-8 rounded-full bg-[#1a1a1c] hover:bg-[#3a3a3d] text-gray-400 hover:text-white flex items-center justify-center transition-colors"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                </button>
                                                <span class="w-12 text-center text-white">{{ $item->quantity }}</span>
                                                <button
                                                    wire:click="increment({{ $item->id }})"
                                                    class="w-8 h-8 rounded-full bg-[#1a1a1c] hover:bg-[#3a3a3d] text-gray-400 hover:text-white flex items-center justify-center transition-colors"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-lg font-light text-white">₦{{ number_format($item->total) }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button
                                                wire:click="removeItem({{ $item->id }})"
                                                wire:confirm="Remove this item from cart?"
                                                class="text-gray-400 hover:text-red-400 transition-colors"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="md:hidden divide-y divide-gray-800">
                            @foreach($cartItems as $item)
                                <div class="p-4 space-y-3" wire:key="mobile-item-{{ $item->id }}">
                                    <div class="flex items-start space-x-3">
                                        @if($item->dropshipperProduct->originalProduct && $item->dropshipperProduct->originalProduct->images->count() > 0)
                                            <img src="{{ $item->dropshipperProduct->originalProduct->primary_image_url }}"
                                                 alt="{{ $item->product_name }}"
                                                 class="w-20 h-20 object-cover rounded-lg">
                                        @else
                                            <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                <span class="text-gray-300 font-medium">{{ substr($item->product_name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <div class="font-medium text-white">{{ $item->product_name }}</div>
                                            @if($item->options)
                                                <div class="text-xs text-gray-400 mt-1">
                                                    @foreach($item->options as $key => $value)
                                                        <span class="capitalize">{{ $key }}: {{ $value }}</span>{{ !$loop->last ? ' | ' : '' }}
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="text-sm mt-2">
                                                @if($item->discount_price)
                                                    <span class="text-gray-400 line-through">₦{{ number_format($item->unit_price) }}</span>
                                                    <span class="text-green-400 ml-2">₦{{ number_format($item->discount_price) }}</span>
                                                @else
                                                    <span class="text-white">₦{{ number_format($item->unit_price) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <button
                                                wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                class="w-8 h-8 rounded-full bg-[#1a1a1c] hover:bg-[#3a3a3d] text-gray-400 hover:text-white flex items-center justify-center"
                                                {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <span class="w-12 text-center text-white">{{ $item->quantity }}</span>
                                            <button
                                                wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                class="w-8 h-8 rounded-full bg-[#1a1a1c] hover:bg-[#3a3a3d] text-gray-400 hover:text-white flex items-center justify-center"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="font-light text-white">₦{{ number_format($item->total) }}</span>
                                            <button
                                                wire:click="removeItem({{ $item->id }})"
                                                wire:confirm="Remove item?"
                                                class="text-gray-400 hover:text-red-400"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-96">
                    <div class="bg-[#252528] rounded-2xl p-6 sticky top-24">
                        <h2 class="text-xl font-light text-white mb-6">Order Summary</h2>

                        <!-- Coupon Code -->
{{--                        <div class="mb-6">--}}
{{--                            @if($couponCode && !$couponError)--}}
{{--                                <div class="flex items-center justify-between bg-green-500/10 border border-green-500/30 rounded-xl p-3 mb-3">--}}
{{--                                    <div>--}}
{{--                                        <span class="text-sm text-green-400 block">Coupon applied</span>--}}
{{--                                        <span class="text-sm text-white">{{ $couponCode }}</span>--}}
{{--                                    </div>--}}
{{--                                    <button wire:click="removeCoupon" class="text-gray-400 hover:text-white" wire:key="remove-coupon">--}}
{{--                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>--}}
{{--                                        </svg>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            @else--}}
{{--                                <div class="flex gap-2">--}}
{{--                                    <flux:input wire:model="couponCode" placeholder="Coupon code" size="sm" />--}}
{{--                                    <flux:button type="submit" variant="primary" size="sm" wire:click="applyCoupon" wire:key="apply-coupon">--}}
{{--                                        <flux:icon.loading wire:loading wire:target="applyCoupon" />--}}
{{--                                        <span wire:loading.remove wire:target="applyCoupon">Apply</span>--}}
{{--                                    </flux:button>--}}
{{--                                </div>--}}
{{--                                @if($couponError)--}}
{{--                                    <p class="text-red-400 text-xs mt-2">{{ $couponError }}</p>--}}
{{--                                @endif--}}
{{--                                @if($couponMessage)--}}
{{--                                    <p class="text-green-400 text-xs mt-2">{{ $couponMessage }}</p>--}}
{{--                                @endif--}}
{{--                            @endif--}}
{{--                        </div>--}}

                        <!-- Totals -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Subtotal</span>
                                <span class="text-white">₦{{ number_format($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Tax (7.5%)</span>
                                <span class="text-white">₦{{ number_format($tax) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Shipping</span>
                                <span class="text-white">₦{{ number_format($shipping) }}</span>
                            </div>
                            @if($discount > 0)
                                <div class="flex justify-between text-sm text-green-400">
                                    <span>Discount</span>
                                    <span>-₦{{ number_format($discount) }}</span>
                                </div>
                            @endif
                            <div class="border-t border-gray-700 pt-3 mt-3">
                                <div class="flex justify-between">
                                    <span class="text-base font-medium text-white">Total</span>
                                    <span class="text-xl font-light text-white">₦{{ number_format($total) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <flux:button type="submit" variant="primary" size="sm" wire:click="proceedToCheckout" class="w-full">
                            <span>Proceed to Checkout</span>
                        </flux:button>

                        <!-- Continue Shopping -->
                        <a href="{{ route('dropshipper-store', ['store' => $store]) }}" class="block text-center text-sm text-gray-400 hover:text-white mt-4 transition-colors">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="bg-[#252528] rounded-2xl p-12 text-center max-w-md mx-auto">
                <div class="w-24 h-24 bg-[#1a1a1c] rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-light text-white mb-2">Your cart is empty</h2>
                <p class="text-gray-400 mb-6">Looks like you haven't added anything yet</p>
                <flux:button type="button" variant="primary" size="sm" href="{{ route('dropshipper-store', ['store' => $store->slug]) }}">
                    <span>Start Shopping</span>
                </flux:button>
            </div>
        @endif
    </div>
</div>
