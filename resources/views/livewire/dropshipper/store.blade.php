{{-- resources/views/livewire/dropshipper/store.blade.php --}}
<div class="min-h-screen bg-[var(--store-bg)]">

    {{-- ===================================================================== --}}
    {{-- STORE UNAVAILABLE (preserved verbatim from old logic) --}}
    {{-- ===================================================================== --}}
    @if($store->status !== \App\Enums\Status::CLONED)
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-32">
            <div class="bg-white rounded-3xl p-8 sm:p-12 text-center border border-stone-200/80 shadow-sm relative overflow-hidden">

                <div class="absolute -right-12 -top-12 w-48 h-48 bg-rose-500/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px] pointer-events-none"></div>

                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl mb-6 border border-rose-100 shadow-sm">
                        <i class="fa-solid fa-store-slash"></i>
                    </div>

                    <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-600 text-[10px] uppercase tracking-widest font-bold px-3 py-1 rounded-md mb-3 border border-rose-100">
                        Store Temporarily Unavailable
                    </span>

                    <h1 class="text-2xl sm:text-3xl font-light tracking-tight text-stone-900 mb-3">
                        <span class="font-semibold text-stone-950">{{ $store->store_name }}</span> is currently inactive
                    </h1>

                    <p class="text-xs sm:text-sm text-stone-500 leading-relaxed max-w-md mb-8">
                        This store has been suspended by the administrator or the owner. Please reach out directly to
                        <span class="font-semibold text-stone-800">{{ $store->dropshipper->user->name ?? 'the store owner' }}</span>
                        for more information.
                    </p>

                    @php
                        $rawPhone = $store->dropshipper->user->phone ?? '';
                        $cleanPhone = '234'.ltrim($rawPhone, '0');
                        $whatsappMessage = urlencode("Hello {$store->dropshipper->user->name}, I tried visiting your store '{$store->store_name}' but noticed it is currently inactive.");
                        $whatsappUrl = $cleanPhone ? "https://wa.me/{$cleanPhone}?text={$whatsappMessage}" : '#';
                    @endphp

                    <div class="flex items-center justify-center gap-3 w-full">
                        @if($cleanPhone)
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer"
                               class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-3 rounded-xl font-medium text-xs transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                                <span>Chat on WhatsApp</span>
                            </a>
                        @else
                            <span class="text-xs text-stone-400 italic">No contact phone number available.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else

        {{-- ================================================================= --}}
        {{-- HERO --}}
        {{-- ================================================================= --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-5">
            <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-10 lg:p-12 relative overflow-hidden border border-stone-200/80 shadow-sm">
                <div class="absolute -right-12 -top-12 w-48 h-48 bg-[var(--store-primary)]/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px] pointer-events-none [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>

                <div class="relative max-w-2xl">
                    <div class="inline-flex items-center gap-1.5 bg-[var(--store-primary)]/10 text-[var(--store-primary)] text-[10px] uppercase tracking-widest font-bold px-2.5 py-1 rounded-md mb-3 sm:mb-4 border border-[var(--store-primary)]/10">
                        <i class="fa-solid fa-store text-[9px]"></i>
                        {{ $store->store_name }} Official Store
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-light tracking-tight text-stone-900 leading-tight">
                        Welcome to
                        <span class="text-[var(--store-primary)] font-semibold">{{ $store->store_name }}</span>
                    </h1>

                    <div class="mt-3 sm:mt-4 max-w-md border-l-2 border-stone-200 pl-3 sm:pl-4">
                        <p class="text-xs sm:text-sm text-stone-500 leading-relaxed">
                            Curated collections handpicked just for you by
                            <span class="font-semibold text-stone-800">{{ $store->dropshipper->user->name }}</span>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================================================================= --}}
        {{-- MAIN CONTENT --}}
        {{-- ================================================================= --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 sm:pb-14">

            {{-- FILTER BAR --}}
            <div class="bg-white rounded-xl p-3 sm:p-4 border border-stone-200/80 shadow-sm mb-6 sm:mb-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2.5 sm:gap-3 items-center">

                    {{-- Search --}}
                    <div class="md:col-span-5 relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 text-xs"></i>
                        <input type="search"
                               wire:model.live.debounce.300ms="search"
                               placeholder="Search products..."
                               class="w-full bg-stone-50 text-stone-900 rounded-lg border border-stone-200 focus:border-[var(--store-primary)] focus:ring-1 focus:ring-[var(--store-primary)]/20 pl-9 pr-3 py-2.5 text-xs sm:text-sm outline-none transition placeholder:text-stone-400">
                    </div>

                    {{-- Sort --}}
                    <div class="md:col-span-3 relative">
                        <select wire:model.live="sortBy"
                                class="w-full bg-stone-50 text-stone-800 px-3 py-2.5 rounded-lg border border-stone-200 text-xs sm:text-sm outline-none appearance-none cursor-pointer font-medium focus:border-[var(--store-primary)]">
                            <option value="newest">Sort: Newest</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="popular">Most Popular</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 pointer-events-none text-[10px]"></i>
                    </div>

                    {{-- Price Range (preserved from old design) --}}
                    <div class="md:col-span-4 flex items-center justify-between gap-2 bg-stone-50 px-3 py-2 rounded-lg border border-stone-200">
                        <div class="flex flex-col w-1/2">
                            <span class="text-[9px] uppercase font-bold tracking-wider text-stone-400">Min Price</span>
                            <div class="flex items-center gap-1">
                                <span class="text-xs text-stone-400">₦</span>
                                <input type="number"
                                       wire:model.live.debounce.500ms="priceRange.0"
                                       min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                       class="w-full bg-transparent text-xs font-semibold text-stone-800 focus:outline-none">
                            </div>
                        </div>
                        <div class="h-5 w-px bg-stone-200 shrink-0"></div>
                        <div class="flex flex-col w-1/2 items-end">
                            <span class="text-[9px] uppercase font-bold tracking-wider text-stone-400">Max Price</span>
                            <div class="flex items-center gap-1 justify-end">
                                <span class="text-xs text-stone-400">₦</span>
                                <input type="number"
                                       wire:model.live.debounce.500ms="priceRange.1"
                                       min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                       class="w-full bg-transparent text-xs font-semibold text-stone-800 text-right focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Category Pills --}}
                <div class="mt-3 pt-3 border-t border-stone-100 flex items-center gap-2 overflow-x-auto pb-1">
                    <button type="button"
                            wire:click="$set('selectedSection', 'all')"
                            class="shrink-0 px-3.5 py-1.5 rounded-full text-xs font-semibold transition-colors {{ $selectedSection === 'all' ? 'bg-[var(--store-primary)] text-white shadow-sm' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}">
                        All Products
                    </button>

                    @foreach($sections as $section)
                        <button type="button"
                                wire:key="section-pill-{{ $section->id }}"
                                wire:click="$set('selectedSection', {{ $section->id }})"
                                class="shrink-0 px-3.5 py-1.5 rounded-full text-xs font-semibold transition-colors {{ $selectedSection == $section->id ? 'bg-[var(--store-primary)] text-white shadow-sm' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}">
                            {{ $section->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- PRODUCTS GRID --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2.5 sm:gap-3 lg:gap-4">
                @forelse($products as $product)
                    @php $originalProduct = $product->originalProduct; @endphp

                    <div wire:key="product-{{ $product->id }}"
                         class="group bg-white rounded-xl overflow-hidden border border-stone-200/80 flex flex-col justify-between transition-all duration-200 hover:shadow-md">

                        {{-- Image --}}
                        <div class="relative aspect-[4/5] sm:aspect-square bg-stone-100 overflow-hidden">
                            @if($originalProduct->primary_image_url)
                                <img src="{{ $originalProduct->primary_image_url }}"
                                     alt="{{ $originalProduct->name }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-stone-50 text-stone-300">
                                    <i class="fa-solid fa-image text-3xl"></i>
                                    <span class="text-[10px] text-stone-400 uppercase tracking-wider font-semibold">No Image</span>
                                </div>
                            @endif

                            {{-- Desktop hover quick view --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-stone-950/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200 hidden sm:flex items-center justify-center">
                                <button type="button"
                                        wire:click="quickView({{ $product->id }})"
                                        class="bg-white text-stone-900 px-4 py-2 rounded-xl text-xs font-semibold shadow-xl hover:bg-[var(--store-primary)] hover:text-white transition-colors transform translate-y-2 group-hover:translate-y-0">
                                    Quick View
                                </button>
                            </div>

                            {{-- Mobile floating quick view --}}
                            <button type="button"
                                    wire:click="quickView({{ $product->id }})"
                                    class="sm:hidden absolute bottom-2 right-2 w-8 h-8 bg-white/90 backdrop-blur-md rounded-lg flex items-center justify-center text-stone-800 shadow-md border border-white/40 active:scale-95 transition-transform">
                                <i class="fa-solid fa-expand text-[11px]"></i>
                            </button>
                        </div>

                        {{-- Info --}}
                        <div class="p-2.5 sm:p-3 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-[9px] uppercase font-bold tracking-wider text-[var(--store-primary)] mb-0.5 truncate">
                                    {{ $originalProduct->section->name ?? 'Uncategorized' }}
                                </div>
                                <h3 class="text-xs sm:text-sm font-semibold text-stone-900 mb-1 line-clamp-2 min-h-[32px] sm:min-h-[38px] leading-tight">
                                    {{ $originalProduct->name }}
                                </h3>
                            </div>

                            <div class="mt-1.5">
                                <div class="flex items-baseline gap-1.5 mb-2">
                                    <span class="text-sm sm:text-base font-bold text-stone-900">₦{{ number_format($product->effective_price) }}</span>
                                    @if($originalProduct->sales_price && $originalProduct->price > $product->effective_price)
                                        <span class="text-[10px] text-stone-400 line-through">₦{{ number_format($originalProduct->price) }}</span>
                                    @endif
                                </div>

                                <button wire:click="addToCart({{ $product->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="addToCart({{ $product->id }})"
                                        class="w-full bg-[var(--store-primary)] hover:bg-[var(--store-primary-hover)] text-white py-1.5 sm:py-2 rounded-lg font-semibold text-[11px] sm:text-xs transition-colors flex items-center justify-center gap-1.5 disabled:opacity-50 active:scale-[0.98]">
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})" class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-plus text-[10px]"></i> Add
                                    </span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})" class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-spinner animate-spin text-[10px]"></i> Adding...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white border border-stone-200 rounded-xl max-w-md mx-auto p-8">
                        <div class="w-14 h-14 rounded-2xl bg-stone-50 mx-auto flex items-center justify-center mb-4">
                            <i class="fa-regular fa-face-frown text-2xl text-stone-400"></i>
                        </div>
                        <h3 class="text-base font-semibold text-stone-900 mb-1">No products found</h3>
                        <p class="text-xs text-stone-500">Try adjusting your filters or search terms.</p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION (preserved from old) --}}
            @if($products->hasPages())
                <div class="mt-10 border-t border-stone-200 pt-6">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        {{-- ================================================================= --}}
        {{-- OTHER STORES (sister stores) --}}
        {{-- ================================================================= --}}
        @if($otherStores->isNotEmpty())
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6 sm:mb-7">
                    <div>
                        <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-[var(--store-primary)]">Discover More</span>
                        <h2 class="text-2xl sm:text-3xl font-light text-stone-900 mt-1">
                            Explore More <span class="font-semibold">Stores</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-stone-500 mt-1.5">
                            More collections curated by {{ $store->dropshipper->user->name }}.
                        </p>
                    </div>
                    <span class="text-[11px] text-stone-400 font-medium">
                        {{ $otherStores->count() }} {{ Str::plural('store', $otherStores->count()) }} to explore
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                    @foreach($otherStores as $otherStore)
                        <div wire:key="other-store-{{ $otherStore->id }}"
                             class="bg-white border border-stone-200 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 group">

                            <div class="p-4 sm:p-5 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <span class="text-[9px] uppercase tracking-widest font-bold text-[var(--store-primary)]">
                                        {{ $otherStore->brand?->brand_name ?? 'Curated Collection' }}
                                    </span>
                                    <h3 class="text-lg sm:text-xl font-semibold text-stone-900 mt-0.5 truncate">
                                        {{ $otherStore->store_name }}
                                    </h3>
                                    <p class="text-[11px] text-stone-400 mt-0.5">
                                        {{ $otherStore->dropshipperProducts->count() }} featured
                                        {{ Str::plural('product', $otherStore->dropshipperProducts->count()) }}
                                    </p>
                                </div>
                                <a href="{{ $otherStore->slug }}"
                                   class="shrink-0 inline-flex items-center gap-1.5 bg-stone-900 hover:bg-[var(--store-primary)] text-white px-3.5 py-2 rounded-lg text-[11px] font-semibold transition-colors">
                                    Visit Store
                                    <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-0.5 transition-transform"></i>
                                </a>
                            </div>

                            <div class="grid grid-cols-3 gap-1.5 px-4 sm:px-5 pb-4 sm:pb-5">
                                @forelse($otherStore->dropshipperProducts as $previewProduct)
                                    @php $original = $previewProduct->originalProduct; @endphp
                                    <div class="min-w-0">
                                        <div class="aspect-square rounded-lg overflow-hidden bg-stone-100 border border-stone-100">
                                            @if($original?->primary_image_url)
                                                <img src="{{ $original->primary_image_url }}"
                                                     alt="{{ $original->name }}"
                                                     loading="lazy"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-stone-300">
                                                    <i class="fa-solid fa-image text-lg"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <h4 class="text-[10px] sm:text-xs text-stone-700 font-medium mt-1.5 truncate">
                                            {{ $original?->name ?? 'Product' }}
                                        </h4>
                                        <p class="text-[10px] sm:text-xs font-semibold text-stone-900">
                                            ₦{{ number_format($previewProduct->effective_price) }}
                                        </p>
                                    </div>
                                @empty
                                    <div class="col-span-3 py-4 text-center text-xs text-stone-400">
                                        No products available for preview.
                                    </div>
                                @endforelse
                            </div>

                            <div class="h-1 w-full bg-gradient-to-r from-[var(--store-primary)]/20 via-[var(--store-primary)] to-[var(--store-primary)]/20 opacity-60"></div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ================================================================= --}}
        {{-- TRUST STRIP --}}
        {{-- ================================================================= --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3 bg-[var(--store-surface)]/60 border border-stone-200 p-3 sm:p-5 rounded-xl">
                <div class="flex items-center gap-2.5 p-1">
                    <div class="text-[var(--store-primary)] bg-white rounded-lg w-9 h-9 flex items-center justify-center shrink-0 shadow-sm border border-stone-200/40">
                        <i class="fa-solid fa-truck text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[10px] sm:text-[11px] uppercase font-bold tracking-wider text-stone-900 truncate">Fast Shipping</h4>
                        <p class="text-[10px] text-stone-500 hidden sm:block truncate">Dispatched within 24h</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 p-1">
                    <div class="text-[var(--store-primary)] bg-white rounded-lg w-9 h-9 flex items-center justify-center shrink-0 shadow-sm border border-stone-200/40">
                        <i class="fa-solid fa-shield-halved text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[10px] sm:text-[11px] uppercase font-bold tracking-wider text-stone-900 truncate">Secure Vault</h4>
                        <p class="text-[10px] text-stone-500 hidden sm:block truncate">100% Protected links</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 p-1">
                    <div class="text-[var(--store-primary)] bg-white rounded-lg w-9 h-9 flex items-center justify-center shrink-0 shadow-sm border border-stone-200/40">
                        <i class="fa-solid fa-arrow-rotate-left text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[10px] sm:text-[11px] uppercase font-bold tracking-wider text-stone-900 truncate">Easy Returns</h4>
                        <p class="text-[10px] text-stone-500 hidden sm:block truncate">30 Day active term</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 p-1">
                    <div class="text-[var(--store-primary)] bg-white rounded-lg w-9 h-9 flex items-center justify-center shrink-0 shadow-sm border border-stone-200/40">
                        <i class="fa-solid fa-headset text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[10px] sm:text-[11px] uppercase font-bold tracking-wider text-stone-900 truncate">Help Desk</h4>
                        <p class="text-[10px] text-stone-500 hidden sm:block truncate">24/7 Support line</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================================================================= --}}
        {{-- QUICK VIEW MODAL --}}
        {{-- ================================================================= --}}
        @if($showQuickView && $quickViewProduct)
            @php $original = $quickViewProduct->originalProduct; @endphp
            <div
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                x-data
                x-show="$wire.showQuickView"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @keydown.escape.window="$wire.closeQuickView()"
            >
                <div class="fixed inset-0 bg-stone-950/50 backdrop-blur-sm" @click="$wire.closeQuickView()"></div>

                <div class="relative bg-white rounded-2xl max-w-2xl w-full shadow-xl border border-stone-200 overflow-hidden z-10 max-h-[90vh] flex flex-col">
                    <div class="flex justify-between items-center px-4 sm:px-5 py-3 border-b border-stone-100 bg-stone-50">
                        <span class="text-[10px] uppercase tracking-wider font-bold text-stone-500">Quick Product View</span>
                        <button wire:click="closeQuickView" class="text-stone-400 hover:text-stone-600 w-7 h-7 rounded-lg flex items-center justify-center bg-stone-200/60 hover:bg-stone-200 transition-colors">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>

                    <div class="overflow-y-auto p-4 sm:p-6 flex-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                            <div class="aspect-square bg-stone-50 rounded-xl overflow-hidden p-4 border border-stone-100 flex items-center justify-center">
                                @if($original->primary_image_url)
                                    <img src="{{ $original->primary_image_url }}" alt="{{ $original->name }}" class="w-full h-full object-contain mix-blend-multiply">
                                @endif
                            </div>

                            <div class="flex flex-col justify-between">
                                <div>
                                    <span class="text-[9px] font-bold uppercase tracking-wider text-[var(--store-primary)] bg-[var(--store-primary)]/10 px-2 py-0.5 rounded inline-block mb-2">
                                        {{ $original->section->name ?? 'Uncategorized' }}
                                    </span>
                                    <h2 class="text-base sm:text-lg font-semibold text-stone-900 leading-tight mb-2">{{ $original->name }}</h2>

                                    <div class="flex items-baseline gap-2 mb-3">
                                        <span class="text-xl font-bold text-stone-950">₦{{ number_format($quickViewProduct->effective_price) }}</span>
                                        @if($original->sales_price && $original->price > $quickViewProduct->effective_price)
                                            <span class="text-xs text-stone-400 line-through">₦{{ number_format($original->price) }}</span>
                                        @endif
                                    </div>

                                    <div class="text-stone-600 text-xs leading-relaxed mb-4 border-t border-stone-100 pt-3 max-h-[120px] overflow-y-auto">
                                        {{ $original->description }}
                                    </div>
                                </div>

                                <div>
                                    <div class="mb-3">
                                        @if($quickViewProduct->in_stock)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <span class="w-1.5 h-1.5 bg-emerald-600 rounded-full"></span>In Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium bg-rose-50 text-rose-700 border border-rose-100">
                                                <span class="w-1.5 h-1.5 bg-rose-600 rounded-full"></span>Out of Stock
                                            </span>
                                        @endif
                                    </div>

                                    <button
                                        wire:click="addToCart({{ $quickViewProduct->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="addToCart({{ $quickViewProduct->id }})"
                                        class="w-full bg-[var(--store-primary)] hover:bg-[var(--store-primary-hover)] text-white py-2.5 rounded-lg font-semibold text-xs transition-colors flex items-center justify-center gap-2 shadow-sm disabled:opacity-50">
                                        <span wire:loading.remove wire:target="addToCart({{ $quickViewProduct->id }})">Add to Cart</span>
                                        <span wire:loading wire:target="addToCart({{ $quickViewProduct->id }})">Processing...</span>
                                        <i class="fa-solid fa-bag-shopping text-[11px]"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @endif
</div>
