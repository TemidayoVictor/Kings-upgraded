<div class="min-h-screen bg-[var(--surface)] py-8 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Editorial header --}}
        <div class="border-b border-[var(--outline-variant)]/30 pb-8 mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[var(--outline)] block mb-2">
                    Your Items
                </span>
                <h1 class="font-editorial text-3xl sm:text-5xl tracking-tight text-[var(--on-surface)] uppercase">
                    Shopping Bag
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-[var(--on-surface-variant)] font-light tracking-wide">
                You have added
                <span class="text-[var(--on-surface)] font-medium">
                    {{ $itemCount }} {{ Str::plural('item', $itemCount) }}
                </span>
            </p>
        </div>

        @if(count($cartItems) > 0)

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">

                {{-- LEFT: Items --}}
                <div class="lg:col-span-8 space-y-4">

                    {{-- Desktop column headers --}}
                    <div class="hidden md:grid grid-cols-12 gap-4 px-6 pb-3 text-[10px] uppercase tracking-[0.2em] font-semibold text-[var(--outline)]">
                        <div class="col-span-6">Product Details</div>
                        <div class="col-span-2">Price</div>
                        <div class="col-span-2 text-center">Quantity</div>
                        <div class="col-span-2 text-right">Subtotal</div>
                    </div>

                    {{-- Item rows --}}
                    @foreach($cartItems as $item)
                        <div
                            wire:key="cart-item-{{ $item->id }}"
                            class="bg-white rounded-2xl border border-[var(--outline-variant)]/25 shadow-xs hover:shadow-sm transition-shadow"
                        >
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center p-4 sm:p-6">

                                {{-- Product --}}
                                <div class="md:col-span-6 flex items-center gap-4 min-w-0">
                                    {{-- Image: fills container, no padding, no border --}}
                                    <div class="w-20 h-24 sm:w-24 sm:h-28 bg-[var(--surface-low)] rounded-xl overflow-hidden shrink-0 relative">
                                        @if($item->product && $item->product->images->count() > 0)
                                            <img src="{{ $item->product->primary_image_url }}"
                                                 alt="{{ $item->product_name }}"
                                                 class="absolute inset-0 w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="text-[var(--outline)] text-xs font-semibold uppercase">
                                                    {{ substr($item->product_name, 0, 2) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Details --}}
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm font-medium text-[var(--on-surface)] line-clamp-2">
                                            {{ $item->product_name }}
                                        </h4>

                                        @if($item->options)
                                            <div class="flex flex-wrap gap-x-2 text-[11px] text-[var(--outline)] font-light mt-1">
                                                @foreach($item->options as $key => $value)
                                                    <span class="capitalize">
                                                        {{ $key }}:
                                                        <strong class="text-[var(--on-surface)] font-medium">{{ $value }}</strong>
                                                    </span>{{ !$loop->last ? ' • ' : '' }}
                                                @endforeach
                                            </div>
                                        @endif

                                        @if($item->sku)
                                            <span class="inline-block mt-2 text-[10px] text-[var(--outline)] bg-[var(--surface-low)] px-2 py-0.5 rounded font-mono">
                                                SKU: {{ $item->sku }}
                                            </span>
                                        @endif

                                        {{-- Mobile-only unit price (hidden from md upward) --}}
                                        <div class="md:hidden mt-2 text-xs font-medium text-[var(--on-surface-variant)]">
                                            ₦{{ number_format($item->unit_price) }} each
                                        </div>
                                    </div>
                                </div>

                                {{-- Price (desktop only) --}}
                                <div class="hidden md:flex md:col-span-2 items-center text-sm font-medium text-[var(--on-surface-variant)]">
                                    ₦{{ number_format($item->unit_price) }}
                                </div>

                                {{-- Quantity --}}
                                <div class="md:col-span-2 flex items-center md:justify-center justify-between">
                                    <span class="md:hidden text-[10px] uppercase tracking-widest font-semibold text-[var(--outline)]">
                                        Quantity
                                    </span>
                                    <div class="inline-flex items-center bg-[var(--surface-low)] border border-[var(--outline-variant)]/30 rounded-full p-1">
                                        <button
                                            wire:click="decrement({{ $item->id }})"
                                            class="w-7 h-7 rounded-full bg-white text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] flex items-center justify-center transition-all border border-[var(--outline-variant)]/25 disabled:opacity-30 disabled:pointer-events-none"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                            aria-label="Decrease quantity"
                                        >
                                            <i class="fa-solid fa-minus text-[10px]"></i>
                                        </button>
                                        <span class="w-9 text-center text-xs font-semibold text-[var(--on-surface)]">
                                            {{ $item->quantity }}
                                        </span>
                                        <button
                                            wire:click="increment({{ $item->id }})"
                                            class="w-7 h-7 rounded-full bg-white text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] flex items-center justify-center transition-all border border-[var(--outline-variant)]/25"
                                            aria-label="Increase quantity"
                                        >
                                            <i class="fa-solid fa-plus text-[10px]"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Subtotal + Remove --}}
                                <div class="md:col-span-2 flex items-center md:justify-end justify-between gap-3">
                                    <div class="flex flex-col md:items-end">
                                        <span class="md:hidden text-[10px] uppercase tracking-widest font-semibold text-[var(--outline)]">
                                            Subtotal
                                        </span>
                                        <span class="text-sm font-semibold text-[var(--on-surface)]">
                                            ₦{{ number_format($item->total) }}
                                        </span>
                                    </div>
                                    <button
                                        wire:click="removeItem({{ $item->id }})"
                                        wire:confirm="Remove this item from your shopping ritual?"
                                        class="w-8 h-8 rounded-full bg-[var(--surface-low)] hover:bg-rose-50 text-[var(--outline)] hover:text-rose-600 flex items-center justify-center transition-all"
                                        title="Remove item"
                                    >
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Continue shopping --}}
                    <div class="pt-2">
                        <a href="{{ route('shop', ['brand' => $brand->slug]) }}"
                           class="inline-flex items-center gap-2 text-xs font-medium text-[var(--outline)] hover:text-[var(--on-surface)] transition-colors tracking-wide">
                            <i class="fa-solid fa-arrow-left-long text-[10px]"></i>
                            Return to shop
                        </a>
                    </div>
                </div>

                {{-- RIGHT: Sticky Order Summary --}}
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[var(--outline-variant)]/25 shadow-lg shadow-black/[0.02] sticky top-32 space-y-6">

                        <h3 class="font-editorial text-xl text-[var(--on-surface)] tracking-tight">
                            Order Summary
                        </h3>

                        {{-- Coupon --}}
                        <div>
                            @if($couponCode && !$couponError)
                                <div class="flex items-center justify-between bg-emerald-50/60 border border-emerald-100 rounded-2xl p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-tag"></i>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-emerald-600 uppercase font-bold tracking-wider block">
                                                Coupon active
                                            </span>
                                            <span class="text-xs font-mono text-[var(--on-surface)] font-medium">
                                                {{ $couponCode }}
                                            </span>
                                        </div>
                                    </div>
                                    <button wire:click="removeCoupon"
                                            class="w-7 h-7 rounded-full hover:bg-emerald-100/50 flex items-center justify-center text-[var(--outline)] hover:text-[var(--on-surface)] transition-colors">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </button>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-1">
                                        <input
                                            type="text"
                                            wire:model="couponCode"
                                            placeholder="Coupon code"
                                            class="w-full bg-[var(--surface-low)] text-[var(--on-surface)] text-xs rounded-xl border border-[var(--outline-variant)]/30 focus:border-[var(--on-surface)] focus:ring-1 focus:ring-[var(--on-surface)] px-4 py-3.5 pl-9 outline-none transition-all"
                                        />
                                        <i class="fa-solid fa-percent absolute left-3.5 top-1/2 -translate-y-1/2 text-[var(--outline)] text-[10px]"></i>
                                    </div>
                                    <button
                                        type="button"
                                        wire:click="applyCoupon"
                                        class="bg-[var(--on-surface)] hover:bg-[var(--secondary)] text-white text-xs font-semibold px-5 py-3.5 rounded-xl transition-all shadow-md active:scale-[0.98] flex items-center justify-center shrink-0 min-w-[70px]"
                                    >
                                        <i wire:loading wire:target="applyCoupon" class="fa-solid fa-spinner animate-spin text-xs"></i>
                                        <span wire:loading.remove wire:target="applyCoupon">Apply</span>
                                    </button>
                                </div>
                                @if($couponError)
                                    <p class="text-rose-600 text-[11px] mt-2 pl-1 font-medium flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-exclamation text-[9px]"></i>
                                        {{ $couponError }}
                                    </p>
                                @endif
                                @if($couponMessage)
                                    <p class="text-emerald-600 text-[11px] mt-2 pl-1 font-medium flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-check text-[9px]"></i>
                                        {{ $couponMessage }}
                                    </p>
                                @endif
                            @endif
                        </div>

                        {{-- Totals --}}
                        <div class="space-y-4 pt-4 border-t border-[var(--outline-variant)]/20 text-xs text-[var(--on-surface-variant)] font-light">
                            <div class="flex justify-between items-center">
                                <span>Subtotal</span>
                                <span class="text-[var(--on-surface)] font-medium">₦{{ number_format($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Shipping Fee</span>
                                <span class="text-[var(--on-surface)] font-medium">₦{{ number_format($shipping) }}</span>
                            </div>

                            @if($discount > 0)
                                <div class="flex justify-between items-center text-emerald-600 font-medium bg-emerald-50/40 p-2.5 rounded-xl border border-emerald-100/50">
                                    <span class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-gift text-[10px]"></i>
                                        Reward Discount
                                    </span>
                                    <span>-₦{{ number_format($discount) }}</span>
                                </div>
                            @endif

                            <div class="border-t border-[var(--outline-variant)]/20 pt-4 mt-2">
                                <div class="flex justify-between items-baseline">
                                    <span class="text-sm font-medium text-[var(--on-surface)]">Total Amount</span>
                                    <span class="text-2xl font-semibold text-[var(--on-surface)] tracking-tight">
                                        ₦{{ number_format($total) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Checkout button --}}
                        <div class="pt-2 space-y-3">
                            <button
                                type="submit"
                                wire:click="proceedToCheckout"
                                class="w-full bg-[var(--on-surface)] hover:bg-[var(--secondary)] text-white text-xs font-semibold tracking-widest uppercase py-4 rounded-xl transition-all duration-300 shadow-lg flex items-center justify-center gap-2 group"
                            >
                                <span>Proceed to Secure Checkout</span>
                                <i class="fa-solid fa-shield-halved text-[10px] opacity-60 transition-transform group-hover:translate-x-0.5"></i>
                            </button>

                            <a href="{{ route('shop', ['brand' => $brand->slug]) }}"
                               class="block text-center text-xs font-medium text-[var(--outline)] hover:text-[var(--on-surface)] py-2 transition-colors tracking-wide">
                                <i class="fa-solid fa-arrow-left-long text-[9px] mr-1"></i>
                                Return to shop
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile sticky checkout bar --}}
            <div class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-[var(--surface)]/95 backdrop-blur-md border-t border-[var(--outline-variant)]/30 px-4 py-3 shadow-[0_-4px_24px_rgba(22,21,19,0.08)]">
                <div class="flex items-center gap-3 max-w-7xl mx-auto">
                    <div class="flex flex-col flex-shrink-0">
                        <span class="text-[10px] uppercase tracking-wider text-[var(--outline)]">
                            Total ({{ $itemCount }} {{ Str::plural('item', $itemCount) }})
                        </span>
                        <span class="text-sm font-bold text-[var(--on-surface)]">
                            ₦{{ number_format($total) }}
                        </span>
                    </div>
                    <button
                        wire:click="proceedToCheckout"
                        class="flex-1 h-12 bg-[var(--on-surface)] text-white flex items-center justify-between px-4 rounded-lg hover:bg-[var(--secondary)] transition-all"
                    >
                        <span class="text-[10px] uppercase tracking-[0.2em] font-semibold">
                            Proceed to Secure Checkout
                        </span>
                        <i class="fa-solid fa-arrow-right-long text-xs"></i>
                    </button>
                </div>
            </div>
            {{-- Spacer so the fixed mobile bar doesn't hide content --}}
            <div class="lg:hidden h-24"></div>

        @else

            {{-- Empty state --}}
            <div class="max-w-md mx-auto text-center py-16 px-6 bg-white rounded-3xl border border-[var(--outline-variant)]/25 shadow-xs">
                <div class="w-16 h-20 bg-[var(--surface-low)] rounded-2xl flex items-center justify-center mx-auto mb-6 border border-[var(--outline-variant)]/25 text-[var(--outline-variant)] relative">
                    <i class="fa-solid fa-bag-shopping text-2xl"></i>
                    <div class="w-5 h-5 rounded-full bg-[var(--surface-container)] text-[var(--outline)] flex items-center justify-center absolute -bottom-1.5 -right-1.5 border-2 border-white">
                        <i class="fa-solid fa-plus text-[8px]"></i>
                    </div>
                </div>
                <h3 class="font-editorial text-xl text-[var(--on-surface)]">
                    Your shopping bag is clean
                </h3>
                <p class="text-xs text-[var(--outline)] font-light mt-2 max-w-xs mx-auto leading-relaxed">
                    You haven't added anything yet.
                </p>
                <div class="pt-8">
                    <a href="{{ route('shop', ['brand' => $brand->slug]) }}"
                       class="inline-flex bg-[var(--on-surface)] hover:bg-[var(--secondary)] text-white text-xs font-semibold tracking-widest uppercase px-8 py-4 rounded-full transition-all duration-300 shadow-lg">
                        Start Shopping
                    </a>
                </div>
            </div>

        @endif
    </div>
</div>
