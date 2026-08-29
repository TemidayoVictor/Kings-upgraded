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
                <p class="text-sm text-stone-500 font-light">Thank you for your purchase. Kindly proceed below.</p>
            </div>

            <!-- Order Identification -->
            <div class="bg-stone-50 rounded-2xl p-6 text-center mb-10 border border-stone-100">
                <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400 block mb-1">Order Reference</span>
                <span class="text-xl font-semibold text-stone-950 tracking-tight">{{ $order->order_number }}</span>
            </div>

            {{-- Bank Account Details --}}
            <div class="mb-10">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50/50 overflow-hidden mb-3">
                    {{-- Card Header --}}
                    <div class="px-5 py-4 border-b border-neutral-200 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-neutral-900 text-white flex items-center justify-center">
                                <i class="fa-solid fa-building-columns text-xs"></i>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-neutral-900">
                                    Payment Account
                                </h3>

                                <p class="text-[11px] text-neutral-400 font-light mt-0.5">
                                    Please make your transfer to this account
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Account Details --}}
                    <div class="p-5 space-y-4">

                        {{-- Account Name --}}
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-neutral-400 font-medium">
                                    Account Name
                                </p>

                                <p class="text-sm text-neutral-900 font-medium mt-1">
                                    {{ $accountName }}
                                </p>
                            </div>
                        </div>


                        {{-- Account Number --}}
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-neutral-400 font-medium">
                                    Account Number
                                </p>

                                <p class="text-lg text-neutral-900 font-semibold tracking-wide mt-1">
                                    {{ $accountNumber }}
                                </p>
                            </div>

                            <div x-data="{ copied: false }">
                                <button
                                    type="button"
                                    onclick="copyAccountNumber('{{ $accountNumber }}')"
                                    @click="copied = true; setTimeout(() => copied = false, 2000)"
                                    class="shrink-0 w-9 h-9 rounded-lg border border-neutral-200 bg-white text-neutral-500 hover:text-neutral-900 hover:border-neutral-300 transition"
                                    :title="copied ? 'Copied!' : 'Copy account number'"
                                >
                                    <i
                                        class="text-xs"
                                        :class="copied ? 'fa-solid fa-check text-green-600' : 'fa-regular fa-copy'"
                                    ></i>
                                </button>
                            </div>
                        </div>


                        {{-- Bank --}}
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-neutral-400 font-medium">
                                Bank
                            </p>

                            <p class="text-sm text-neutral-900 font-medium mt-1">
                                {{ $bank }}
                            </p>
                        </div>
                    </div>


                    {{-- Notice --}}
                    <div class="px-5 py-4 bg-neutral-100/70 border-t border-neutral-200">
                        <div class="flex gap-3">
                            <i class="fa-solid fa-circle-info text-neutral-400 text-xs mt-0.5"></i>

                            <p class="text-[11px] leading-relaxed text-neutral-500 font-light">
                                Please ensure that the account name and number are correct before making your transfer.
                                Your order will be processed once your payment has been confirmed.
                            </p>
                        </div>
                    </div>
                </div>
                <a
                    href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode(
                        "Hello, my name is {$order->customer_name}, I just placed an order on your KING'S store.\n\n" .
                        "Order Number: #{$order->order_number}\n" .
                        "Amount: ₦" . number_format($order->total, 2) . "\n\n" .
                        "I have made payment. Thank you." . "\n\n" .
                        "Link: {$link}"
                    ) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="block w-full items-center gap-2 text-center bg-neutral-950 hover:bg-[var(--primary)] text-white text-xs font-semibold tracking-widest uppercase px-8 py-4 rounded-xl transition-all shadow-lg active:scale-98"
                >
                    <i wire:loading wire:target="placeOrder" class="fa-solid fa-spinner animate-spin text-[11px]"></i>
                    <span wire:loading.remove wire:target="placeOrder">{{ __('I have made payment') }}</span>
                </a>
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

<script>
    function copyAccountNumber(accountNumber) {
        const input = document.createElement('textarea');

        input.value = accountNumber;
        input.style.position = 'fixed';
        input.style.opacity = '0';

        document.body.appendChild(input);

        input.focus();
        input.select();

        try {
            document.execCommand('copy');
            console.log('Account number copied!');
        } catch (error) {
            console.error('Failed to copy:', error);
        }

        document.body.removeChild(input);
    }
</script>
