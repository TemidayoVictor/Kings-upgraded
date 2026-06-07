{{-- resources/views/livewire/dropshipper-store/products.blade.php --}}
<div class="min-h-screen bg-[var(--store-bg)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-5">
        <div class="bg-white rounded-3xl p-6 sm:p-10 lg:p-14 relative overflow-hidden border border-stone-200/80 shadow-sm group">
            <!-- Abstract Modern Geometric Accents (Blends with your theme color) -->
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-[var(--store-primary)]/5 rounded-full blur-2xl pointer-events-none transition-transform duration-700 group-hover:scale-110"></div>
            <div class="absolute right-12 bottom-0 w-72 h-32 bg-[var(--store-primary)]/[0.03] rounded-t-full pointer-events-none hidden md:block"></div>

            <!-- Background Subtle Grid Structure for Premium Feel -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px] pointer-events-none [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>

            <div class="relative max-w-2xl z-10">
                <!-- Decorative Tag Pill -->
                <div class="inline-flex items-center gap-1.5 bg-[var(--store-primary)]/10 text-[var(--store-primary)] text-[10px] uppercase tracking-widest font-bold px-2.5 py-1 rounded-md mb-4 border border-[var(--store-primary)]/10">
                    <i class="fa-solid fa-sparkles text-[9px]"></i>
                    {{ $store->store_name }} Official Store
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extralight tracking-tight text-stone-900 leading-[1.15]">
                    Welcome to <span class="text-[var(--store-primary)] font-medium block sm:inline relative tracking-normal">{{ $store->store_name }}</span>
                </h1>

                <div class="mt-4 max-w-md border-l-2 border-stone-200 pl-4">
                    <p class="text-xs sm:text-sm text-stone-500 leading-relaxed">
                        Curated collections handpicked just for you by the creative design curators over at <span class="font-semibold text-stone-800">{{ $store->dropshipper->user->name }}</span>.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

        <div class="mb-8">
            <details id="category-matrix-dropdown" class="group/details border border-stone-200/80 bg-white rounded-2xl overflow-hidden [&_summary::-webkit-details-marker]:hidden">

                <summary class="flex items-center justify-between gap-4 p-3 cursor-pointer select-none outline-none list-none hover:bg-stone-50/50 transition-colors">

                    <div class="flex items-center gap-3 pl-1 pointer-events-none">
                        <div class="w-8 h-8 rounded-xl bg-[var(--store-primary)]/10 text-[var(--store-primary)] flex items-center justify-center">
                            @if($selectedSection === 'all')
                                <i class="fa-solid fa-layer-group text-xs"></i>
                            @else
                                <i class="fa-solid fa-tag text-xs"></i>
                            @endif
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 block uppercase tracking-wider font-semibold">Viewing Category</span>
                            <span class="text-sm font-medium text-stone-800">
                        @if($selectedSection === 'all')
                                    All Products
                                @else
                                    {{ $sections->firstWhere('id', $selectedSection)->name ?? 'Selected Collection' }}
                                @endif
                    </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 bg-stone-50 group-hover/details:bg-stone-100 border border-stone-200 text-stone-700 font-medium text-xs px-3 py-2 rounded-xl transition-all duration-200">
                        <span>Browse Categories</span>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200 group-open/details:rotate-180"></i>
                    </div>
                </summary>

                <div class="bg-stone-50/50 border-t border-stone-100 p-4 sm:p-6">

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 max-h-72 overflow-y-auto pr-1">

                        <button
                            type="button"
                            wire:click="$set('selectedSection', 'all')"
                            onclick="document.getElementById('category-matrix-dropdown').removeAttribute('open')"
                            class="w-full text-left p-3 rounded-xl border text-xs font-medium transition-all duration-200 flex flex-col gap-2 {{ $selectedSection === 'all' ? 'border-[var(--store-primary)] bg-[var(--store-primary)] text-white shadow-sm' : 'bg-white border-stone-200 text-stone-600 hover:bg-stone-50 hover:text-stone-900' }}"
                        >
                            <i class="fa-solid fa-layer-group text-sm {{ $selectedSection === 'all' ? 'text-white' : 'opacity-60' }}"></i>
                            <span>All Products</span>
                        </button>

                        @foreach($sections as $section)
                            <button
                                type="button"
                                wire:key="matrix-section-{{ $section->id }}"
                                wire:click="$set('selectedSection', {{ $section->id }})"
                                onclick="document.getElementById('category-matrix-dropdown').removeAttribute('open')"
                                class="w-full text-left p-3 rounded-xl border text-xs font-medium transition-all duration-200 flex flex-col gap-2 {{ $selectedSection == $section->id ? 'border-[var(--store-primary)] bg-[var(--store-primary)] text-white shadow-sm' : 'bg-white border-stone-200 text-stone-600 hover:bg-stone-50 hover:text-stone-900' }}"
                            >
                                <i class="fa-solid fa-tag text-sm {{ $selectedSection == $section->id ? 'text-white' : 'opacity-60' }}"></i>
                                <span class="truncate w-full">{{ $section->name }}</span>
                            </button>
                        @endforeach

                    </div>

                    <div class="mt-4 pt-3 border-t border-stone-200/60 flex justify-between items-center text-[11px] text-stone-400 font-medium px-1">
                        <span>{{ $sections->count() + 1 }} options available</span>
                        <button
                            type="button"
                            onclick="document.getElementById('category-matrix-dropdown').removeAttribute('open')"
                            class="hover:text-stone-600 underline decoration-stone-200 underline-offset-2"
                        >
                            Close Matrix
                        </button>
                    </div>
                </div>
            </details>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center mb-8 bg-white p-3 rounded-xl border border-stone-200 shadow-sm">
            <div class="md:col-span-6 lg:col-span-5 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 text-xs"></i>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search product collection..."
                    class="w-full bg-stone-50 text-stone-900 rounded-lg border border-stone-200 focus:border-[var(--store-primary)] focus:ring-1 focus:ring-[var(--store-primary)] px-4 py-2.5 pl-10 text-xs outline-none placeholder:text-stone-400"
                >
            </div>

            <div class="md:col-span-6 lg:col-span-3">
                <div class="relative">
                    <select
                        wire:model.live="sortBy"
                        class="w-full bg-stone-50 text-stone-800 px-3 py-2.5 rounded-lg border border-stone-200 focus:border-[var(--store-primary)] text-xs outline-none appearance-none cursor-pointer font-medium"
                    >
                        <option value="newest">Sort by: Newest</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="popular">Most Popular</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-stone-400 pointer-events-none text-[10px]"></i>
                </div>
            </div>

            <div class="md:col-span-12 lg:col-span-4 flex items-center justify-between gap-2 bg-stone-50 px-3 py-1.5 rounded-lg border border-stone-200">
                <div class="flex flex-col w-1/2">
                    <span class="text-[9px] uppercase font-bold tracking-wider text-stone-400">Min Price</span>
                    <div class="flex items-center gap-1">
                        <span class="text-xs text-stone-400">₦</span>
                        <input type="number" wire:model.live.debounce.500ms="priceRange.0" min="{{ $minPrice }}" max="{{ $maxPrice }}" class="w-full bg-transparent text-xs font-semibold text-stone-800 focus:outline-none">
                    </div>
                </div>
                <div class="h-5 w-[1px] bg-stone-200 shrink-0"></div>
                <div class="flex flex-col w-1/2 items-end">
                    <span class="text-[9px] uppercase font-bold tracking-wider text-stone-400">Max Price</span>
                    <div class="flex items-center gap-1 justify-end">
                        <span class="text-xs text-stone-400">₦</span>
                        <input type="number" wire:model.live.debounce.500ms="priceRange.1" min="{{ $minPrice }}" max="{{ $maxPrice }}" class="w-full bg-transparent text-xs font-semibold text-stone-800 text-right focus:outline-none">
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
            @forelse($products as $product)
                @php
                    $originalProduct = $product->originalProduct;
                @endphp
                <div
                    wire:key="product-{{ $product->id }}"
                    class="group bg-white rounded-xl overflow-hidden border border-stone-200/80 flex flex-col justify-between transition-all duration-200 hover:shadow-md"
                >
                    <div class="relative aspect-[4/5] sm:aspect-square bg-stone-100 flex items-center justify-center overflow-hidden">
                        @if($originalProduct->primary_image_url)
                            <img
                                src="{{ $originalProduct->primary_image_url }}"
                                alt="{{ $originalProduct->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                            >
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-stone-50 text-stone-300">
                                <i class="fa-solid fa-image text-3xl"></i>
                                <span class="text-[10px] text-stone-400 uppercase tracking-wider font-semibold">No Image Available</span>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-stone-950/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200 hidden sm:flex items-center justify-center">
                            <button
                                type="button"
                                wire:click="quickView({{ $product->id }})"
                                class="bg-white text-stone-900 px-5 py-2 rounded-xl text-xs font-semibold shadow-xl hover:bg-[var(--store-primary)] hover:text-white transition-all duration-150 transform translate-y-2 group-hover:translate-y-0"
                            >
                                Quick View
                            </button>
                        </div>

                        <button
                            type="button"
                            wire:click="quickView({{ $product->id }})"
                            class="sm:hidden absolute bottom-3 right-3 w-8 h-8 bg-white/80 backdrop-blur-md rounded-xl flex items-center justify-center text-stone-800 shadow-md border border-white/40 active:scale-95 transition-transform"
                        >
                            <i class="fa-solid fa-expand text-xs"></i>
                        </button>
                    </div>

                    <div class="p-3 flex-1 flex flex-col justify-between border-t border-stone-50">
                        <div>
                            <div class="text-[9px] uppercase font-bold tracking-wider text-[var(--store-primary)] mb-0.5 truncate">
                                {{ $originalProduct->section->name ?? 'Uncategorized' }}
                            </div>
                            <h3 class="text-xs sm:text-sm font-medium text-stone-900 mb-1 line-clamp-2 min-h-[32px] sm:min-h-[40px] leading-tight">
                                {{ $originalProduct->name }}
                            </h3>
                        </div>

                        <div class="mt-1">
                            <div class="flex items-baseline gap-1.5 mb-2.5">
                                <span class="text-sm sm:text-base font-semibold text-stone-900">₦{{ number_format($product->effective_price) }}</span>
                                @if($originalProduct->sales_price && $originalProduct->price > $product->effective_price)
                                    <span class="text-[10px] text-stone-400 line-through">₦{{ number_format($originalProduct->price) }}</span>
                                @endif
                            </div>

                            <button
                                wire:click="addToCart({{ $product->id }})"
                                wire:loading.attr="disabled"
                                wire:target="addToCart({{ $product->id }})"
                                class="w-full bg-stone-50 hover:bg-[var(--store-primary)] border border-stone-200 hover:border-[var(--store-primary)] text-stone-800 hover:text-white py-2 rounded-lg font-medium text-xs transition-all duration-150 flex items-center justify-center gap-1.5 disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add</span>
                                <span wire:loading wire:target="addToCart({{ $product->id }})"><i class="fa-solid fa-spinner animate-spin text-[10px]"></i></span>
                                <i class="fa-solid fa-cart-plus text-[11px] opacity-80"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white border border-stone-200 rounded-xl shadow-sm max-w-sm mx-auto p-6">
                    <i class="fa-regular fa-face-frown text-3xl text-stone-300 mb-2"></i>
                    <h3 class="text-base font-medium text-stone-900 mb-0.5">No products found</h3>
                    <p class="text-xs text-stone-500">Refine parameters or check spelling options.</p>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="mt-12 border-t border-stone-200 pt-6">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 bg-[var(--store-surface)]/40 border border-stone-200 p-4 sm:p-6 rounded-xl">
            <div class="flex items-center gap-3 p-1">
                <div class="text-[var(--store-primary)] bg-white rounded-lg w-9 h-9 flex items-center justify-center shrink-0 shadow-xs border border-stone-200/40"><i class="fa-solid fa-truck text-sm"></i></div>
                <div>
                    <h4 class="text-[11px] uppercase font-bold tracking-wider text-stone-900">Fast Shipping</h4>
                    <p class="text-[10px] text-stone-500 hidden sm:block">Dispatched within 24h</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-1">
                <div class="text-[var(--store-primary)] bg-white rounded-lg w-9 h-9 flex items-center justify-center shrink-0 shadow-xs border border-stone-200/40"><i class="fa-solid fa-shield-halved text-sm"></i></div>
                <div>
                    <h4 class="text-[11px] uppercase font-bold tracking-wider text-stone-900">Secure Vault</h4>
                    <p class="text-[10px] text-stone-500 hidden sm:block">100% Protected links</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-1">
                <div class="text-[var(--store-primary)] bg-white rounded-lg w-9 h-9 flex items-center justify-center shrink-0 shadow-xs border border-stone-200/40"><i class="fa-solid fa-arrow-rotate-left text-sm"></i></div>
                <div>
                    <h4 class="text-[11px] uppercase font-bold tracking-wider text-stone-900">Easy Returns</h4>
                    <p class="text-[10px] text-stone-500 hidden sm:block">30 Day active term</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-1">
                <div class="text-[var(--store-primary)] bg-white rounded-lg w-9 h-9 flex items-center justify-center shrink-0 shadow-xs border border-stone-200/40"><i class="fa-solid fa-headset text-sm"></i></div>
                <div>
                    <h4 class="text-[11px] uppercase font-bold tracking-wider text-stone-900">Help Desk</h4>
                    <p class="text-[10px] text-stone-500 hidden sm:block">24/7 Support line</p>
                </div>
            </div>
        </div>
    </div>

    @if($showQuickView && $quickViewProduct)
        @php
            $original = $quickViewProduct->originalProduct;
        @endphp
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
            <div class="fixed inset-0 bg-stone-950/50 backdrop-blur-xs" @click="$wire.closeQuickView()"></div>

            <div class="relative bg-white rounded-xl max-w-2xl w-full shadow-xl border border-stone-200 overflow-hidden z-10 max-h-[90vh] flex flex-col">
                <div class="flex justify-between items-center px-5 py-3.5 border-b border-stone-100 bg-stone-50">
                    <span class="text-[10px] uppercase tracking-wider font-bold text-stone-500">Quick Product View</span>
                    <button wire:click="closeQuickView" class="text-stone-400 hover:text-stone-600 w-6 h-6 rounded-md flex items-center justify-center bg-stone-200/60"><i class="fa-solid fa-xmark text-xs"></i></button>
                </div>

                <div class="overflow-y-auto p-5 sm:p-6 flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="aspect-square bg-stone-50 rounded-lg overflow-hidden p-4 border border-stone-100 flex items-center justify-center">
                            @if($original->primary_image_url)
                                <img src="{{ $original->primary_image_url }}" alt="{{ $original->name }}" class="w-full h-full object-contain mix-blend-multiply">
                            @endif
                        </div>

                        <div class="flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-1.5 mb-1">
                                    <span class="text-[9px] font-bold uppercase tracking-wider text-[var(--store-primary)] bg-amber-50 px-1.5 py-0.5 rounded">
                                        {{ $original->section->name ?? 'Uncategorized' }}
                                    </span>
                                </div>
                                <h2 class="text-base sm:text-lg font-semibold text-stone-900 leading-tight mb-2">{{ $original->name }}</h2>

                                <div class="flex items-center gap-2 mb-3">
                                        <span class="text-xl font-bold text-stone-950">₦{{ number_format($quickViewProduct->custom_price) }}</span>
                                </div>

                                <div class="text-stone-600 text-xs leading-relaxed mb-4 border-t border-stone-100 pt-3 max-h-[120px] overflow-y-auto">
                                    {{ $original->description }}
                                </div>
                            </div>

                            <div>
                                <div class="mb-3">
                                    @if($quickViewProduct->in_stock)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            <span class="w-1 h-1 bg-emerald-600 rounded-full"></span>In Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium bg-rose-50 text-rose-700 border border-rose-100">
                                            <span class="w-1 h-1 bg-rose-600 rounded-full"></span>Out of Stock
                                        </span>
                                    @endif
                                </div>

                                <button
                                    wire:click="addToCart({{ $quickViewProduct->id }})"
                                    wire:loading.attr="disabled"
                                    class="w-full bg-[var(--store-primary)] hover:bg-[var(--store-primary-hover)] text-white py-2.5 rounded-lg font-medium text-xs transition-colors flex items-center justify-center gap-2 shadow-sm"
                                >
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
</div>
