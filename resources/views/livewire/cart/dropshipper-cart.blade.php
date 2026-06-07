<div class="min-h-screen bg-[var(--store-bg)] py-8 sm:py-12 text-stone-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8 bg-white p-6 rounded-2xl border border-stone-200/60 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-light text-stone-950 tracking-tight">Shopping Cart</h1>
                <p class="text-xs sm:text-sm text-stone-500 mt-1">
                    You have <span class="font-medium text-[var(--store-primary)]">{{ $itemCount }} {{ Str::plural('item', $itemCount) }}</span> reserved in your temporary batch session.
                </p>
            </div>
            <a href="{{ route('dropshipper-store', ['store' => $store]) }}" class="inline-flex items-center justify-center gap-2 text-xs font-medium text-stone-600 hover:text-[var(--store-primary)] bg-stone-50 hover:bg-stone-100 border border-stone-200 px-4 py-2.5 rounded-xl transition-colors shrink-0">
                <i class="fa-solid fa-arrow-left-long text-[10px]"></i>
                Continue Shopping
            </a>
        </div>

        @if(count($cartItems) > 0)
            <div class="flex flex-col lg:flex-row gap-6 items-start">

                <div class="flex-1 w-full">
                    <div class="bg-white rounded-2xl border border-stone-200/80 shadow-sm overflow-hidden">

                        <div class="hidden md:block">
                            <table class="w-full border-collapse text-left">
                                <thead class="bg-stone-50/70 border-b border-stone-200 text-stone-400 text-[10px] uppercase tracking-wider font-bold">
                                <tr>
                                    <th class="px-6 py-4 font-bold">Product Summary</th>
                                    <th class="px-6 py-4 font-bold">Unit Price</th>
                                    <th class="px-6 py-4 font-bold text-center">Quantity</th>
                                    <th class="px-6 py-4 font-bold">Subtotal Line</th>
                                    <th class="px-6 py-4 font-bold text-right"><span class="sr-only">Actions</span></th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100">
                                @foreach($cartItems as $item)
                                    <tr class="hover:bg-stone-50/40 transition-colors align-middle" wire:key="desktop-item-{{ $item->id }}">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-20 h-24 bg-stone-50 border border-stone-200 rounded-xl overflow-hidden shrink-0 flex items-center justify-center">
                                                    @if($item->dropshipperProduct->originalProduct && $item->dropshipperProduct->originalProduct->primary_image_url)
                                                        <img src="{{ $item->dropshipperProduct->originalProduct->primary_image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="text-stone-300 text-center"><i class="fa-solid fa-image text-xl"></i></div>
                                                    @endif
                                                </div>
                                                <div class="max-w-xs">
                                                    <h3 class="text-sm font-medium text-stone-900 leading-tight line-clamp-2 mb-1">{{ $item->product_name }}</h3>
                                                    @if($item->options)
                                                        <div class="flex flex-wrap gap-1.5 mt-1.5">
                                                            @foreach($item->options as $key => $value)
                                                                <span class="inline-flex bg-stone-100 text-stone-600 text-[10px] px-2 py-0.5 rounded-md font-medium border border-stone-200/40">
                                                                        <span class="capitalize text-stone-400 mr-1">{{ $key }}:</span> {{ $value }}
                                                                    </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    @if($item->sku)
                                                        <div class="text-[10px] text-stone-400 font-mono tracking-wider mt-1">SKU: {{ $item->sku }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm">
                                                @if($item->discount_price)
                                                    <div class="font-semibold text-stone-900">₦{{ number_format($item->discount_price) }}</div>
                                                    <div class="text-xs text-stone-400 line-through mt-0.5">₦{{ number_format($item->unit_price) }}</div>
                                                @else
                                                    <div class="font-semibold text-stone-900">₦{{ number_format($item->unit_price) }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center justify-center space-x-1.5 bg-stone-50 border border-stone-200 rounded-xl p-1 max-w-[110px] mx-auto">
                                                <button type="button" wire:click="decrement({{ $item->id }})" class="w-7 h-7 rounded-lg hover:bg-white text-stone-500 hover:text-stone-900 flex items-center justify-center transition-colors disabled:opacity-30 disabled:pointer-events-none" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                                </button>
                                                <span class="w-8 text-center text-xs font-semibold text-stone-800">{{ $item->quantity }}</span>
                                                <button type="button" wire:click="increment({{ $item->id }})" class="w-7 h-7 rounded-lg hover:bg-white text-stone-500 hover:text-stone-900 flex items-center justify-center transition-colors">
                                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="text-base font-medium text-stone-950 tracking-tight">₦{{ number_format($item->total) }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-right whitespace-nowrap">
                                            <button type="button" wire:click="removeItem({{ $item->id }})" wire:confirm="Remove this item from cart?" class="w-8 h-8 rounded-lg text-stone-400 hover:text-rose-600 hover:bg-rose-50 transition-colors inline-flex items-center justify-center">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="md:hidden divide-y divide-stone-100">
                            @foreach($cartItems as $item)
                                <div class="p-4 space-y-4" wire:key="mobile-item-{{ $item->id }}">
                                    <div class="flex gap-4">
                                        <div class="w-20 h-24 bg-stone-50 border border-stone-200 rounded-xl overflow-hidden shrink-0 flex items-center justify-center">
                                            @if($item->dropshipperProduct->originalProduct && $item->dropshipperProduct->originalProduct->primary_image_url)
                                                <img src="{{ $item->dropshipperProduct->originalProduct->primary_image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="text-stone-300 text-center"><i class="fa-solid fa-image text-lg"></i></div>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between gap-2">
                                                <h3 class="text-xs sm:text-sm font-medium text-stone-900 line-clamp-2 leading-tight">{{ $item->product_name }}</h3>
                                                <button type="button" wire:click="removeItem({{ $item->id }})" wire:confirm="Remove item?" class="text-stone-400 hover:text-rose-600 shrink-0 p-1">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </div>

                                            @if($item->options)
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    @foreach($item->options as $key => $value)
                                                        <span class="text-[9px] bg-stone-100 text-stone-500 rounded px-1.5 py-0.5"><span class="capitalize text-stone-400">{{ $key }}:</span> {{ $value }}</span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="text-xs font-semibold text-stone-900 mt-2.5">
                                                @if($item->discount_price)
                                                    <span>₦{{ number_format($item->discount_price) }}</span>
                                                    <span class="text-[10px] text-stone-400 line-through ml-1.5 font-normal">₦{{ number_format($item->unit_price) }}</span>
                                                @else
                                                    <span>₦{{ number_format($item->unit_price) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-2 border-t border-stone-50">
                                        <div class="flex items-center space-x-1.5 bg-stone-50 border border-stone-200 rounded-lg p-0.5">
                                            <button type="button" wire:click="decrement({{ $item->id }})" class="w-7 h-7 rounded-md hover:bg-white text-stone-500 flex items-center justify-center transition-colors disabled:opacity-30" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                <i class="fa-solid fa-minus text-[9px]"></i>
                                            </button>
                                            <span class="w-6 text-center text-xs font-medium text-stone-800">{{ $item->quantity }}</span>
                                            <button type="button" wire:click="increment({{ $item->id }})" class="w-7 h-7 rounded-md hover:bg-white text-stone-500 flex items-center justify-center transition-colors">
                                                <i class="fa-solid fa-plus text-[9px]"></i>
                                            </button>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-[10px] uppercase font-bold tracking-wider text-stone-400 block mb-0.5">Line Total</span>
                                            <span class="text-sm font-semibold text-stone-950">₦{{ number_format($item->total) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="w-full lg:w-96 shrink-0 lg:sticky lg:top-24">
                    <div class="bg-white rounded-2xl p-6 border border-stone-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-stone-950 tracking-tight pb-3 border-b border-stone-100 mb-5">Order Summary</h2>

                            <div class="space-y-3.5 mb-6 text-xs sm:text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-stone-500">Cart Subtotal</span>
                                    <span class="font-medium text-stone-800">₦{{ number_format($subtotal) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-stone-500">Estimated VAT (7.5%)</span>
                                    <span class="font-medium text-stone-800">₦{{ number_format($tax) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-stone-500">Shipping Delivery fees</span>
                                    <span class="font-medium text-stone-800">₦{{ number_format($shipping) }}</span>
                                </div>
                                @if($discount > 0)
                                    <div class="flex justify-between items-center bg-emerald-50/60 text-emerald-700 px-2 py-1.5 rounded-lg border border-emerald-100">
                                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-ticket text-xs"></i> Promotional Adjustments</span>
                                        <span class="font-bold">-₦{{ number_format($discount) }}</span>
                                    </div>
                                @endif
                                <div class="border-t border-stone-200 pt-4 mt-4">
                                    <div class="flex justify-between items-baseline">
                                        <span class="text-base font-semibold text-stone-950">Grand Total</span>
                                        <span class="text-xl font-bold text-[var(--store-primary)] tracking-tight">₦{{ number_format($total) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="button" wire:click="proceedToCheckout" class="w-full bg-[var(--store-primary)] hover:bg-[var(--store-primary-hover)] text-white py-3 rounded-xl font-medium text-xs sm:text-sm shadow-md shadow-[var(--store-primary)]/10 transition-colors flex items-center justify-center gap-2">
                                <span>Proceed to Secure Checkout</span>
                                <i class="fa-solid fa-shield-check text-sm opacity-80"></i>
                            </button>
                            <div class="mt-4 flex items-center justify-center gap-4 text-[11px] text-stone-400 font-medium">
                                <span><i class="fa-solid fa-lock text-[10px] mr-1"></i> SSL Encrypted</span>
                                <span>•</span>
                                <span><i class="fa-solid fa-truck-fast text-[10px] mr-1"></i> Trackable Dispatch</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="bg-white rounded-3xl p-12 text-center max-w-md mx-auto border border-stone-200 shadow-sm mt-8">
                <div class="w-20 h-20 bg-[var(--store-bg)] text-stone-300 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-stone-200/40">
                    <i class="fa-solid fa-bag-shopping text-3xl text-[var(--store-primary)]/60"></i>
                </div>
                <h2 class="text-xl font-semibold text-stone-900 tracking-tight">Your cart is empty</h2>
                <p class="text-xs text-stone-500 mt-1 mb-6 max-w-xs mx-auto">Looks like you haven't assigned items to your collection grid terminal yet.</p>
                <a href="{{ route('dropshipper-store', ['store' => $store->slug]) }}" class="inline-flex bg-[var(--store-primary)] hover:bg-[var(--store-primary-hover)] text-white text-xs font-semibold px-6 py-2.5 rounded-xl shadow-xs transition-colors">
                    Start Product Discovery
                </a>
            </div>
        @endif
    </div>
</div>
