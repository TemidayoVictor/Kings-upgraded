<div class="min-h-screen bg-[#faf9f6] py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="border-b border-neutral-200/60 pb-8 mb-12 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-[3px] text-neutral-400 block mb-2">Your Curated Selection</span>
                <h1 class="text-3xl sm:text-5xl font-light tracking-tight text-neutral-900 serif-display">Shopping Bag</h1>
            </div>
            <p class="text-xs sm:text-sm text-neutral-500 font-light tracking-wide">
                You have added <span class="text-neutral-900 font-medium">{{ $itemCount }} {{ Str::plural('item', $itemCount) }}</span>
            </p>
        </div>

        @if(count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                <div class="lg:col-span-8 space-y-6">

                    <div class="hidden md:block bg-white rounded-[24px] border border-neutral-100 shadow-xs overflow-hidden">
                        <table class="w-full border-collapse">
                            <thead>
                            <tr class="bg-neutral-50/70 border-b border-neutral-100 text-[10px] font-bold uppercase tracking-widest text-neutral-400">
                                <th class="px-8 py-5 text-left font-semibold">Product Details</th>
                                <th class="px-6 py-5 text-left font-semibold">Price</th>
                                <th class="px-6 py-5 text-center font-semibold">Quantity</th>
                                <th class="px-6 py-5 text-left font-semibold">Subtotal</th>
                                <th class="px-8 py-5 text-right font-semibold"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-100">
                            @foreach($cartItems as $item)
                                <tr class="hover:bg-neutral-50/40 transition-colors group" wire:key="desktop-item-{{ $item->id }}">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-5">
                                            <div class="w-20 h-24 bg-neutral-50 rounded-xl overflow-hidden shrink-0 border border-neutral-100 p-2 flex items-center justify-center">
                                                @if($item->product && $item->product->images->count() > 0)
                                                    <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain mix-blend-multiply">
                                                @else
                                                    <span class="text-neutral-400 text-xs font-semibold uppercase">{{ substr($item->product_name, 0, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="space-y-1">
                                                <h4 class="text-sm font-medium text-neutral-800 group-hover:text-[var(--primary)] transition-colors">{{ $item->product_name }}</h4>
                                                @if($item->options)
                                                    <div class="flex flex-wrap gap-x-2 text-[11px] text-neutral-400 font-light">
                                                        @foreach($item->options as $key => $value)
                                                            <span class="capitalize">{{ $key }}: <strong class="text-neutral-600 font-medium">{{ $value }}</strong></span>{{ !$loop->last ? ' • ' : '' }}
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @if($item->sku)
                                                    <span class="inline-block text-[10px] text-neutral-400 bg-neutral-100 px-2 py-0.5 rounded font-mono">SKU: {{ $item->sku }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="text-sm font-medium text-neutral-600">₦{{ number_format($item->unit_price) }}</span>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center justify-center">
                                            <div class="inline-flex items-center bg-neutral-50 border border-neutral-200 rounded-full p-1 shadow-inner">
                                                <button
                                                    wire:click="decrement({{ $item->id }})"
                                                    class="w-7 h-7 rounded-full bg-white text-neutral-500 hover:text-neutral-900 flex items-center justify-center transition-all disabled:opacity-30 disabled:pointer-events-none border border-neutral-100 hover:shadow-xs"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                                >
                                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                                </button>
                                                <span class="w-9 text-center text-xs font-semibold text-neutral-800">{{ $item->quantity }}</span>
                                                <button
                                                    wire:click="increment({{ $item->id }})"
                                                    class="w-7 h-7 rounded-full bg-white text-neutral-500 hover:text-neutral-900 flex items-center justify-center transition-all border border-neutral-100 hover:shadow-xs"
                                                >
                                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="text-sm font-semibold text-neutral-900">₦{{ number_format($item->total) }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <button
                                            wire:click="removeItem({{ $item->id }})"
                                            wire:confirm="Remove this item from your shopping ritual?"
                                            class="w-8 h-8 rounded-full bg-neutral-50 hover:bg-rose-50 text-neutral-400 hover:text-rose-600 flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 focus:opacity-100"
                                            title="Delete product out of array stack"
                                        >
                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="md:hidden space-y-4">
                        @foreach($cartItems as $item)
                            <div class="bg-white rounded-2xl border border-neutral-100 p-4 space-y-4 shadow-xs" wire:key="mobile-item-{{ $item->id }}">
                                <div class="flex gap-4">
                                    <div class="w-20 h-24 bg-neutral-50 rounded-xl overflow-hidden shrink-0 border border-neutral-100 p-2 flex items-center justify-center">
                                        @if($item->product && $item->product->images->count() > 0)
                                            <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain mix-blend-multiply">
                                        @else
                                            <span class="text-neutral-400 text-xs font-semibold uppercase">{{ substr($item->product_name, 0, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 space-y-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <h4 class="text-xs font-medium text-neutral-800 line-clamp-2 leading-tight">{{ $item->product_name }}</h4>
                                            <button
                                                wire:click="removeItem({{ $item->id }})"
                                                wire:confirm="Remove this item?"
                                                class="text-neutral-400 hover:text-rose-600 p-1 shrink-0"
                                            >
                                                <i class="fa-regular fa-trash-can text-xs"></i>
                                            </button>
                                        </div>

                                        @if($item->options)
                                            <div class="text-[10px] text-neutral-400 font-light leading-relaxed">
                                                @foreach($item->options as $key => $value)
                                                    <span class="capitalize">{{ $key }}: <strong class="text-neutral-600 font-medium">{{ $value }}</strong></span>{{ !$loop->last ? ' | ' : '' }}
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="text-xs font-semibold text-neutral-900 pt-1">
                                            ₦{{ number_format($item->unit_price) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-3 border-t border-neutral-50">
                                    <div class="inline-flex items-center bg-neutral-50 border border-neutral-200 rounded-full p-0.5">
                                        <button
                                            wire:click="decrement({{ $item->id }})"
                                            class="w-6 h-6 rounded-full bg-white text-neutral-500 flex items-center justify-center disabled:opacity-30 border border-neutral-100"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                        >
                                            <i class="fa-solid fa-minus text-[8px]"></i>
                                        </button>
                                        <span class="w-7 text-center text-[11px] font-bold text-neutral-800">{{ $item->quantity }}</span>
                                        <button
                                            wire:click="increment({{ $item->id }})"
                                            class="w-6 h-6 rounded-full bg-white text-neutral-500 flex items-center justify-center border border-neutral-100"
                                        >
                                            <i class="fa-solid fa-plus text-[8px]"></i>
                                        </button>
                                    </div>

                                    <div class="text-sm font-bold text-neutral-900">
                                        ₦{{ number_format($item->total) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="bg-white rounded-[28px] p-6 sm:p-8 border border-neutral-100 shadow-xl shadow-neutral-100/40 sticky top-28 space-y-6">
                        <h3 class="text-lg font-medium text-neutral-900 tracking-tight serif-display">Order Summary</h3>

                        <div class="pt-2">
                            @if($couponCode && !$couponError)
                                <div class="flex items-center justify-between bg-emerald-50/60 border border-emerald-100 rounded-2xl p-4 animate-fade-in">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-tag"></i>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-emerald-600 uppercase font-bold tracking-wider block">Coupon active</span>
                                            <span class="text-xs font-mono text-neutral-800 font-medium">{{ $couponCode }}</span>
                                        </div>
                                    </div>
                                    <button wire:click="removeCoupon" class="w-7 h-7 rounded-full hover:bg-emerald-100/50 flex items-center justify-center text-neutral-400 hover:text-neutral-700 transition-colors">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </button>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-1">
                                        <input
                                            type="text"
                                            wire:model="couponCode"
                                            placeholder="Enter promotional code"
                                            class="w-full bg-neutral-50 text-neutral-800 text-xs rounded-xl border border-neutral-200 focus:border-[var(--primary)] focus:ring-1 focus:ring-[var(--primary)] px-4 py-3.5 pl-9 outline-none transition-all"
                                        />
                                        <i class="fa-solid fa-percent absolute left-3.5 top-1/2 -translate-y-1/2 text-neutral-400 text-[10px]"></i>
                                    </div>
                                    <button
                                        type="button"
                                        wire:click="applyCoupon"
                                        class="bg-neutral-950 hover:bg-[var(--primary)] text-white text-xs font-semibold px-5 py-3.5 rounded-xl transition-all shadow-md active:scale-98 flex items-center justify-center shrink-0 min-w-[70px]"
                                    >
                                        <i wire:loading wire:target="applyCoupon" class="fa-solid fa-spinner animate-spin text-xs"></i>
                                        <span wire:loading.remove wire:target="applyCoupon">Apply</span>
                                    </button>
                                </div>
                                @if($couponError)
                                    <p class="text-rose-600 text-[11px] mt-2 pl-1 font-medium flex items-center gap-1.5 animate-head-shake">
                                        <i class="fa-solid fa-circle-exclamation text-[9px]"></i> {{ $couponError }}
                                    </p>
                                @endif
                                @if($couponMessage)
                                    <p class="text-emerald-600 text-[11px] mt-2 pl-1 font-medium flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-check text-[9px]"></i> {{ $couponMessage }}
                                    </p>
                                @endif
                            @endif
                        </div>

                        <div class="space-y-4 pt-4 border-t border-neutral-100 text-xs text-neutral-500 font-light">
                            <div class="flex justify-between items-center">
                                <span>Bag Subtotal</span>
                                <span class="text-neutral-900 font-medium">₦{{ number_format($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Vat Metrics (7.5%)</span>
                                <span class="text-neutral-900 font-medium">₦{{ number_format($tax) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Premium Logistics Care</span>
                                <span class="text-neutral-900 font-medium">₦{{ number_format($shipping) }}</span>
                            </div>

                            @if($discount > 0)
                                <div class="flex justify-between items-center text-emerald-600 font-medium bg-emerald-50/40 p-2.5 rounded-xl border border-emerald-100/50">
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-gift text-[10px]"></i> Reward Discount</span>
                                    <span>-₦{{ number_format($discount) }}</span>
                                </div>
                            @endif

                            <div class="border-t border-neutral-100 pt-4 mt-2">
                                <div class="flex justify-between items-baseline">
                                    <span class="text-sm font-medium text-neutral-900">Total Due</span>
                                    <span class="text-2xl font-semibold text-neutral-900 tracking-tight">₦{{ number_format($total) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 space-y-3">
                            <button
                                type="submit"
                                wire:click="proceedToCheckout"
                                class="w-full bg-neutral-950 hover:bg-[var(--primary)] text-white text-xs font-semibold tracking-widest uppercase py-4.5 rounded-xl transition-all duration-300 shadow-xl shadow-neutral-950/10 flex items-center justify-center gap-2 group"
                            >
                                <span>Proceed to Secure Checkout</span>
                                <i class="fa-solid fa-shield-holes text-[10px] opacity-60 transition-transform group-hover:translate-x-0.5"></i>
                            </button>

                            <a
                                href="{{ route('shop', ['brand' => $brand->slug]) }}"
                                class="block text-center text-xs font-medium text-neutral-400 hover:text-[var(--primary)] py-2 transition-colors tracking-wide"
                            >
                                <i class="fa-solid fa-arrow-left-long text-[9px] mr-1"></i> Return to Catalog Store
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="max-w-md mx-auto text-center py-16 px-6 bg-white rounded-[32px] border border-neutral-100 shadow-xs">
                <div class="w-16 h-20 bg-neutral-50 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-neutral-100 text-neutral-300 relative">
                    <i class="fa-solid fa-bag-shopping text-2xl"></i>
                    <div class="w-5 h-5 rounded-full bg-neutral-200 text-neutral-400 flex items-center justify-center absolute -bottom-1.5 -right-1.5 border-2 border-white">
                        <i class="fa-solid fa-plus text-[8px]"></i>
                    </div>
                </div>
                <h3 class="text-xl font-medium text-neutral-900 serif-display">Your shopping bag is clean</h3>
                <p class="text-xs text-neutral-400 font-light mt-2 max-w-xs mx-auto leading-relaxed">
                    You haven’t added anything yet.
                </p>
                <div class="pt-8">
                    <a
                        href="{{ route('shop', ['brand' => $brand->slug]) }}"
                        class="inline-flex bg-neutral-950 hover:bg-[var(--primary)] text-white text-xs font-semibold tracking-widest uppercase px-8 py-4 rounded-full transition-all duration-300 shadow-lg"
                    >
                        Start Shopping
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
