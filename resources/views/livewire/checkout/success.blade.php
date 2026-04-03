{{-- resources/views/livewire/checkout/success.blade.php --}}
<div class="min-h-screen bg-[#1a1a1c] py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Card -->
        <div class="bg-[#252528] rounded-2xl p-8 lg:p-12 text-center">
            <!-- Success Icon -->
            <div class="w-24 h-24 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <!-- Thank You Message -->
            <h1 class="text-3xl font-light text-white mb-2">Thank You for Your Order!</h1>
            <p class="text-gray-400 mb-8">
                Your order has been placed successfully.
            </p>

            <!-- Order Number -->
            <div class="bg-[#1a1a1c] rounded-xl p-4 mb-8 inline-block mx-auto">
                <span class="text-sm text-gray-400 block mb-1">Order Number</span>
                <span class="text-2xl font-light text-white">{{ $order->order_number }}</span>
            </div>

            <!-- Order Details -->
            <div class="text-left border-t border-gray-700 pt-8 mt-4">
                <h2 class="text-lg font-medium text-white mb-4">Order Details</h2>

                <!-- Items -->
                <div class="space-y-3 mb-6 max-h-60 overflow-y-auto">
                    @foreach($order->items as $item)
                        <div class="flex items-start gap-3 mt-2">
                            @if($order->dropshipper_store_id)
                                <div class="w-12 h-12 bg-[#1a1a1c] rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->dropshipperProduct->originalProduct && $item->dropshipperProduct->originalProduct->images->count() > 0)
                                        <img src="{{ $item->dropshipperProduct->originalProduct->primary_image_url }}"
                                             alt="{{ $item->product_name }}"
                                             class="w-20 h-20 object-cover rounded-lg">
                                    @else
                                        <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                            <span class="text-gray-300 font-medium">{{ substr($item->product_name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="w-12 h-12 bg-[#1a1a1c] rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->product && $item->product->images->count() > 0)
                                        <img src="{{ $item->product->primary_image_url }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-20 h-20 object-cover rounded-lg">
                                    @else
                                        <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                            <span class="text-gray-300 font-medium">{{ substr($item->product_name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-white">{{ $item->product_name }}</p>
                                <p class="text-sm text-gray-400">Qty: {{ $item->quantity }}</p>
                            </div>
                            <span class="text-white">₦{{ number_format($item->total) }}</span>
                        </div>
                    @endforeach
                </div>

{{--                <div class="space-y-3 mb-6">--}}
{{--                    @foreach($order->items as $item)--}}
{{--                        <div class="flex justify-between items-center">--}}
{{--                            <div>--}}
{{--                                <span class="text-white">{{ $item->product_name }}</span>--}}
{{--                                <span class="text-sm text-gray-400 ml-2">x{{ $item->quantity }}</span>--}}
{{--                            </div>--}}
{{--                            <span class="text-white">₦{{ number_format($item->total) }}</span>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}

                <!-- Totals -->
                <div class="space-y-2 pt-4 border-t border-gray-700">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="text-white">₦{{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Tax</span>
                        <span class="text-white">₦{{ number_format($order->tax) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Shipping</span>
                        <span class="text-white">₦{{ number_format($order->shipping) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-sm text-green-400">
                            <span>Discount</span>
                            <span>-₦{{ number_format($order->discount) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between pt-2 text-lg">
                        <span class="text-white">Total</span>
                        <span class="text-white font-light">₦{{ number_format($order->total) }}</span>
                    </div>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="text-left border-t border-gray-700 pt-8 mt-4">
                <h2 class="text-lg font-medium text-white mb-4">Delivery Information</h2>

                <div class="space-y-2">
                    <p class="text-gray-300">{{ $order->customer_name }}</p>
                    <p class="text-gray-300">{{ $order->customer_phone }}</p>
                    <p class="text-gray-300">{{ $order->delivery_address }}</p>
                    <p class="text-gray-300">{{ $order->delivery_city }}, {{ $order->delivery_state }} {{ $order->delivery_zip }}</p>
                    @if($order->deliveryLocation)
                        <p class="text-gray-400 text-sm mt-2">Delivery Location: {{ $order->deliveryLocation->full_path }}</p>
                    @endif
                    @if($order->delivery_instructions)
                        <p class="text-gray-400 text-sm italic mt-2">"{{ $order->delivery_instructions }}"</p>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="text-left border-t border-gray-700 pt-8 mt-4">
                <h2 class="text-lg font-medium text-white mb-4">Payment Information</h2>

                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Payment Method</span>
                        <span class="text-white capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Payment Status</span>
                        <span class="text-yellow-400 capitalize">{{ $order->payment_status }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                @if($order->dropshipper_store_id)
                    <flux:button type="button" href="{{ route('dropshipper-store', ['store' => $store->slug]) }}" variant="primary" class="w-full">
                        <span>Continue Shopping</span>
                    </flux:button>
                @else
                    <flux:button type="button" href="{{ route('shop', ['brand' => $brand->slug]) }}" variant="primary" class="w-full">
                        <span>Continue Shopping</span>
                    </flux:button>
                @endif
            </div>
        </div>
    </div>
</div>
