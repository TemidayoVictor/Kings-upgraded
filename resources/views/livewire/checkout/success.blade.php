{{-- resources/views/livewire/checkout/success.blade.php --}}
<div class="min-h-screen bg-[#1a1a1c] py-12 antialiased">
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
            <h1 class="text-3xl font-light text-white mb-2 font-serif tracking-tight">Thank You for Your Order!</h1>
            <p class="text-xs text-gray-400 font-light mb-8">
                Your order has been placed successfully.
            </p>

            <!-- Order Number -->
            <div class="bg-[#1a1a1c] rounded-xl p-4 mb-8 inline-block mx-auto">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-1">Order Number</span>
                <span class="text-2xl font-semibold tracking-tight text-white">{{ $order->order_number }}</span>
            </div>

            <!-- Order Details -->
            <div class="text-left border-t border-gray-700 pt-8 mt-4">
                <h2 class="text-base font-medium text-white tracking-tight font-serif mb-4">Order Details</h2>

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
                                            <span class="text-gray-300 font-medium text-xs uppercase">{{ substr($item->product_name, 0, 1) }}</span>
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
                                            <span class="text-gray-300 font-medium text-xs uppercase">{{ substr($item->product_name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <div class="flex-1 min-w-0 space-y-0.5">
                                <p class="text-xs font-medium text-white truncate">{{ $item->product_name }}</p>
                                <p class="text-[11px] text-gray-400 font-light">Qty: <span class="text-gray-300 font-medium">{{ $item->quantity }}</span></p>
                            </div>
                            <span class="text-xs font-semibold text-white shrink-0">₦{{ number_format($item->total) }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Totals -->
                <div class="space-y-3.5 pt-5 border-t border-gray-700 text-xs text-gray-400 font-light">
                    <div class="flex justify-between items-center">
                        <span>Subtotal</span>
                        <span class="text-white font-medium">₦{{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Tax</span>
                        <span class="text-white font-medium">₦{{ number_format($order->tax) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Shipping</span>
                        <span class="text-white font-medium">₦{{ number_format($order->shipping) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between items-center text-green-400 font-medium bg-green-950/20 p-2.5 rounded-xl border border-green-900/30">
                            <span>Discount</span>
                            <span>-₦{{ number_format($order->discount) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-baseline pt-4 border-t border-gray-700 mt-2">
                        <span class="text-sm font-medium text-white">Total</span>
                        <span class="text-2xl font-semibold text-white tracking-tight">₦{{ number_format($order->total) }}</span>
                    </div>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="text-left border-t border-gray-700 pt-8 mt-6">
                <h2 class="text-base font-medium text-white tracking-tight font-serif mb-4">Delivery Information</h2>

                <div class="space-y-2 text-xs text-gray-300 font-light leading-relaxed">
                    <p class="font-medium text-white">{{ $order->customer_name }}</p>
                    <p>{{ $order->customer_phone }}</p>
                    <p>{{ $order->delivery_address }}</p>
                    <p>{{ $order->delivery_city }}, {{ $order->delivery_state }} {{ $order->delivery_zip }}</p>
                    @if($order->deliveryLocation)
                        <p class="text-[11px] text-gray-400 mt-3">Delivery Location: {{ $order->deliveryLocation->full_path }}</p>
                    @endif
                    @if($order->delivery_instructions)
                        <p class="text-[11px] text-gray-400 italic mt-2">"{{ $order->delivery_instructions }}"</p>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="text-left border-t border-gray-700 pt-8 mt-6">
                <h2 class="text-base font-medium text-white tracking-tight font-serif mb-4">Payment Information</h2>

                <div class="space-y-3.5 text-xs text-gray-400 font-light">
                    <div class="flex justify-between items-center">
                        <span>Payment Method</span>
                        <span class="text-white font-medium capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Payment Status</span>
                        @if($order->payment_status == App\Enums\Status::PAID)
                            <span class="text-green-400 font-medium capitalize">{{ $order->payment_status }}</span>
                        @else
                            <span class="text-yellow-400 font-medium capitalize">{{ $order->payment_status }}</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Order Status</span>
                        @if($order->status == App\Enums\Status::DELIVERED)
                            <span class="text-green-400 font-medium capitalize">{{ $order->status }}</span>
                        @elseif($order->status == App\Enums\Status::CANCELLED)
                            <span class="text-red-400 font-medium capitalize">{{ $order->status }}</span>
                        @else
                            <span class="text-yellow-400 font-medium capitalize">{{ $order->status }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-10 pt-6 border-t border-gray-700">
                @if($order->dropshipper_store_id)
                    <flux:button type="button" href="{{ route('dropshipper-store', ['store' => $store->slug]) }}" variant="primary" class="w-full text-xs font-semibold tracking-wide">
                        <span>Continue Shopping</span>
                    </flux:button>
                @else
                    <flux:button type="button" href="{{ route('shop', ['brand' => $brand->slug]) }}" variant="primary" class="w-full text-xs font-semibold tracking-wide">
                        <span>Continue Shopping</span>
                    </flux:button>
                @endif
            </div>
        </div>
    </div>
</div>
