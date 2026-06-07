{{-- resources/views/livewire/checkout/success.blade.php --}}
<div class="min-h-screen bg-[var(--store-bg)] py-12 antialiased">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Premium Success Manifest -->
        <div class="bg-white rounded-3xl p-8 lg:p-12 border border-stone-100 shadow-sm shadow-stone-100">

            <!-- Icon Node -->
            <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-8 border border-emerald-100">
                <i class="fa-solid fa-check text-2xl text-emerald-600"></i>
            </div>

            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-2xl font-medium text-stone-950 mb-2 tracking-tight">Order Confirmed</h1>
                <p class="text-sm text-stone-500 font-light">Thank you for your purchase. Your order is now being processed.</p>
            </div>

            <!-- Order Identification -->
            <div class="bg-stone-50 rounded-2xl p-6 text-center mb-10 border border-stone-100">
                <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400 block mb-1">Order Reference</span>
                <span class="text-xl font-semibold text-stone-950 tracking-tight">{{ $order->order_number }}</span>
            </div>

            <!-- Details Section -->
            <div class="space-y-8">

                <!-- Items Manifest -->
                <div>
                    <h2 class="text-xs font-bold uppercase tracking-widest text-stone-950 mb-4 border-b border-stone-100 pb-2">Items Purchased</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-stone-100 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $item->product->primary_image_url ?? '' }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-stone-900 truncate">{{ $item->product_name }}</p>
                                    <p class="text-[11px] text-stone-500">Qty: {{ $item->quantity }}</p>
                                </div>
                                <span class="text-sm font-semibold text-stone-950">₦{{ number_format($item->total) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Financial Breakdown -->
                <div class="space-y-3 pt-6 border-t border-stone-100 text-xs">
                    <div class="flex justify-between text-stone-500">
                        <span>Subtotal</span>
                        <span class="text-stone-900 font-medium">₦{{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-stone-500">
                        <span>Shipping</span>
                        <span class="text-stone-900 font-medium">₦{{ number_format($order->shipping) }}</span>
                    </div>
                    <div class="flex justify-between items-baseline pt-4 border-t border-stone-100">
                        <span class="text-sm font-semibold text-stone-950">Total Amount</span>
                        <span class="text-lg font-bold text-stone-950">₦{{ number_format($order->total) }}</span>
                    </div>
                </div>

                <!-- Logistics & Meta -->
                <div class="flex items-center justify-between gap-8 pt-6 border-t border-stone-100">
                    <div>
                        <h3 class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-3">Delivery To</h3>
                        <p class="text-xs text-stone-600 leading-relaxed font-medium">{{ $order->customer_name }}</p>
                        <p class="text-xs text-stone-500">{{ $order->delivery_address }}, {{ $order->delivery_city }}</p>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-3">Status</h3>
                        <div class="inline-block px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wide">
                            {{ $order->payment_status }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action -->
            <div class="mt-10">
                <flux:button variant="primary" href="{{ $order->dropshipper_store_id ? route('dropshipper-store', ['store' => $store->slug]) : route('shop', ['brand' => $brand->slug]) }}" class="w-full !py-3">
                    Continue Shopping
                </flux:button>
            </div>
        </div>
    </div>
</div>
