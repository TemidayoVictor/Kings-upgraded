<div class="pb-20 bg-[var(--surface)]">

    {{-- ==================== BRAND ACCENT SYSTEM ==================== --}}
    <style>
        /* Gradient accent bar — primary to secondary */
        .brand-accent-bar {
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
        }

        /* Safe "brand fill" — darkened mix so white text stays readable */
        .brand-sale-badge {
            background: color-mix(in srgb, var(--primary) 85%, #000 15%);
            color: #ffffff;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
        }

        /* Hover fill using brand primary — for buttons */
        .hover-brand-primary {
            transition: background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-brand-primary:hover {
            background-color: color-mix(in srgb, var(--primary) 85%, #000 15%);
            color: #ffffff;
            box-shadow: 0 4px 14px color-mix(in srgb, var(--primary) 30%, transparent);
        }

        /* Brand-tinted hover glow for product cards */
        .brand-card-hover-glow {
            transition: box-shadow 0.35s ease, transform 0.35s ease;
        }
        .brand-card-hover-glow:hover {
            box-shadow: 0 10px 30px -12px color-mix(in srgb, var(--primary) 35%, transparent);
        }
    </style>

    {{-- ==================== EDITORIAL MASTHEAD ==================== --}}
    <section class="relative w-full bg-[var(--surface-low)] py-10 px-4 sm:px-8">
        <div class="max-w-7xl mx-auto flex flex-col items-center text-center">
            <div class="inline-flex items-center gap-2 mb-4 bg-[var(--surface)] px-4 py-1.5 rounded-full shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-[var(--secondary)]"></span>
                <span class="text-[10px] tracking-widest text-[var(--on-surface-variant)] uppercase font-semibold">
                    {{ $brand->brand_name }} Collection
                </span>
            </div>
            <h1 class="font-editorial text-3xl sm:text-4xl lg:text-5xl text-[var(--on-surface)] max-w-4xl tracking-tight mb-4 uppercase">
                Shop the Collection
            </h1>
            @if($brand->description)
                <p class="text-sm sm:text-base text-[var(--on-surface-variant)] max-w-2xl font-light mb-6">
                    {{ strip_tags($brand->description) }}
                </p>
            @endif
            <div class="flex flex-wrap items-center justify-center gap-2">
                <div class="flex items-center gap-2 bg-[var(--surface)] px-4 py-2 rounded-full shadow-sm text-[var(--on-surface)]">
                    <i class="fa-solid fa-truck-fast text-[var(--secondary)] text-xs"></i>
                    <span class="text-[10px] tracking-wider uppercase font-semibold">Fast Delivery</span>
                </div>
            </div>
        </div>
        {{-- Brand identity: gradient accent bar at bottom of masthead --}}
{{--        <div class="absolute bottom-0 left-0 right-0 h-1 brand-accent-bar"></div>--}}
    </section>

    {{-- ==================== FILTERS + GRID ==================== --}}
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-8 pt-8 pb-12">

        {{-- Search — focus uses brand primary --}}
        <div class="w-full mb-6">
            <div class="relative w-full max-w-3xl mx-auto">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[var(--outline)] text-sm"></i>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search products..."
                    class="w-full bg-white text-[var(--on-surface)] placeholder:text-[var(--outline)] pl-12 pr-10 py-3.5 rounded-full text-sm shadow-sm focus:outline-none border border-[var(--outline-variant)]/30 focus:border-[var(--primary)] transition-colors"
                >
            </div>
        </div>

        {{-- Category pills + sort --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-4">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-2 lg:pb-0">
                {{-- Active pill uses brand primary background --}}
                <button
                    wire:click="$set('selectedSection', 'all')"
                    class="px-4 py-2 rounded-full text-[10px] uppercase tracking-wider whitespace-nowrap transition-all font-semibold {{ $selectedSection === 'all' ? 'bg-[var(--primary)] text-white shadow-sm' : 'bg-[var(--surface-container)] text-[var(--on-surface-variant)] hover:bg-[var(--surface-high)]' }}"
                >
                    All Products
                </button>
                @foreach($sections as $section)
                    <button
                        wire:click="$set('selectedSection', {{ $section->id }})"
                        class="px-4 py-2 rounded-full text-[10px] uppercase tracking-wider whitespace-nowrap transition-all font-semibold {{ $selectedSection == $section->id ? 'bg-[var(--primary)] text-white shadow-sm' : 'bg-[var(--surface-container)] text-[var(--on-surface-variant)] hover:bg-[var(--surface-high)]' }}"
                    >
                        {{ $section->name }} ({{ $section->products_count }})
                    </button>
                @endforeach
            </div>

            <div class="flex items-center justify-between sm:justify-end gap-4">
                <div class="relative inline-flex items-center">
                    <span class="text-[10px] tracking-wider uppercase text-[var(--outline)] mr-2 font-semibold">Sort:</span>
                    <select
                        wire:model.live="sortBy"
                        class="bg-[var(--surface-container)] text-[var(--on-surface)] text-sm px-3 py-1.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary)] cursor-pointer transition-shadow"
                    >
                        <option value="newest">Newest</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Price range strip + Reset --}}
        <div class="mb-6 bg-[var(--surface-container)]/60 px-4 py-3 rounded-lg flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-[10px] uppercase tracking-widest text-[var(--outline)] font-semibold">Price Range:</span>
                <div class="flex items-center gap-2">
                    <span class="text-xs px-2 py-1 bg-white rounded border border-[var(--outline-variant)]/30">₦{{ number_format($priceRange[0]) }}</span>
                    <span class="text-xs text-[var(--outline)]">—</span>
                    <span class="text-xs px-2 py-1 bg-white rounded border border-[var(--outline-variant)]/30">₦{{ number_format($priceRange[1]) }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <input type="range"
                           wire:model.live="priceRange.0"
                           min="{{ $minPrice }}" max="{{ $maxPrice }}"
                           class="w-24 accent-[var(--primary)] cursor-pointer">
                    <input type="range"
                           wire:model.live="priceRange.1"
                           min="{{ $minPrice }}" max="{{ $maxPrice }}"
                           class="w-24 accent-[var(--primary)] cursor-pointer">
                </div>
            </div>
            <a href="{{ route('shop', $brand) }}" wire:navigate
               class="text-[10px] uppercase tracking-wider font-semibold text-[var(--secondary)] hover:underline">
                Reset All
            </a>
        </div>

        {{-- ==================== PRODUCT GRID ==================== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($products as $product)
                <article
                    wire:key="product-{{ $product->id }}"
                    class="group flex flex-col bg-[var(--surface)] rounded-xl overflow-hidden brand-card-hover-glow"
                >
                    <div class="relative aspect-[3/4] w-full overflow-hidden bg-[var(--surface-high)]">
                        @if($product->primary_image_url)
                            <img src="{{ $product->primary_image_url }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-[var(--surface-high)]">
                                <i class="fa-regular fa-image text-2xl text-[var(--outline)]"></i>
                            </div>
                        @endif

                        {{-- Sale badge — brand-tinted --}}
                        @if($product->discount_price || $product->sale_status)
                            <div class="absolute top-3 left-3">
                                <span class="brand-sale-badge text-[9px] font-semibold tracking-wider uppercase px-2.5 py-1 rounded-full shadow-sm">
                                    Sale
                                </span>
                            </div>
                        @endif

                        {{-- Wishlist --}}
                        <button
                            wire:click="addToWishlist({{ $product->id }})"
                            wire:loading.attr="disabled"
                            wire:target="addToWishlist({{ $product->id }})"
                            aria-label="Add to wishlist"
                            class="absolute top-3 right-3 w-8 h-8 rounded-full bg-[var(--surface)]/90 backdrop-blur-md flex items-center justify-center text-[var(--on-surface)] hover:text-[var(--secondary)] transition-colors"
                        >
                            <span wire:loading.remove wire:target="addToWishlist({{ $product->id }})"><i class="fa-regular fa-heart text-sm"></i></span>
                            <span wire:loading wire:target="addToWishlist({{ $product->id }})"><i class="fa-solid fa-spinner animate-spin text-sm"></i></span>
                        </button>

                        {{-- Quick view (desktop hover flyout) --}}
                        <div class="absolute inset-x-3 bottom-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden sm:block">
                            <button
                                wire:click="quickView({{ $product->id }})"
                                wire:loading.attr="disabled"
                                wire:target="quickView({{ $product->id }})"
                                class="w-full bg-[var(--on-surface)] text-white py-3 rounded-lg text-[10px] uppercase tracking-widest hover:bg-[var(--secondary)] transition-all flex items-center justify-center gap-2"
                            >
                                <span wire:loading.remove wire:target="quickView({{ $product->id }})" class="flex items-center gap-2">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                    <span>Quick View</span>
                                </span>
                                <span wire:loading wire:target="quickView({{ $product->id }})" class="flex items-center gap-2">
                                    <i class="fa-solid fa-spinner animate-spin text-xs"></i>
                                    <span>Loading…</span>
                                </span>
                            </button>
                        </div>

                        {{-- Brand accent line at bottom of image, revealed on hover --}}
                        <div class="absolute bottom-0 left-0 right-0 h-[2px] brand-accent-bar opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        {{-- Mobile: tap image to quick view --}}
                        <button
                            wire:click="quickView({{ $product->id }})"
                            wire:loading.attr="disabled"
                            wire:target="quickView({{ $product->id }})"
                            class="absolute inset-0 w-full h-full sm:hidden focus:outline-none cursor-pointer"
                            title="Quick view"
                        ></button>

                        <div
                            wire:loading
                            wire:target="quickView({{ $product->id }})"
                            class="sm:hidden absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-20 pointer-events-none"
                        >
                            <i class="fa-solid fa-spinner animate-spin text-2xl text-[var(--primary)]"></i>
                        </div>
                    </div>

                    <div class="p-4 sm:p-5 flex flex-col flex-1 justify-between gap-3">
                        <div>
                            {{-- Section label — brand secondary for a subtle fingerprint --}}
                            <span class="text-[9px] uppercase tracking-[0.2em] text-[var(--secondary)] block mb-1">
                                {{ $product->section->name ?? 'Uncategorized' }}
                            </span>
                            <h3 class="text-sm text-[var(--on-surface)] font-medium leading-snug line-clamp-2 group-hover:text-[var(--secondary)] transition-colors">
                                {{ $product->name }}
                            </h3>
                        </div>

                        <div class="flex items-baseline justify-between pt-1 gap-2">
                            <div class="flex items-baseline gap-1.5 flex-wrap">
                                @if($product->sale_status)
                                    <span class="text-sm sm:text-base font-semibold text-[var(--on-surface)]">₦{{ number_format($product->sales_price) }}</span>
                                    <span class="text-[11px] text-[var(--outline)] line-through">₦{{ number_format($product->price) }}</span>
                                @else
                                    <span class="text-sm sm:text-base font-semibold text-[var(--on-surface)]">₦{{ number_format($product->price) }}</span>
                                @endif
                            </div>

                            {{-- Add to cart — hover uses brand primary --}}
                            <button
                                wire:click="addToCart({{ $product->id }})"
                                wire:loading.attr="disabled"
                                wire:target="addToCart({{ $product->id }})"
                                title="Add to cart"
                                class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[var(--surface-lowest)] text-[var(--on-surface)] flex items-center justify-center shadow-md active:scale-95 hover-brand-primary shrink-0"
                            >
                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})"><i class="fa-solid fa-plus text-xs"></i></span>
                                <span wire:loading wire:target="addToCart({{ $product->id }})"><i class="fa-solid fa-spinner animate-spin text-xs"></i></span>
                            </button>
                        </div>

                        @if($addedToCart === $product->id)
                            <div class="text-[10px] text-[var(--primary)] font-semibold uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-check"></i> Added
                            </div>
                        @endif
                    </div>
                </article>
            @empty
                {{-- Empty state — brand-tinted icon --}}
                <div class="col-span-full py-20 text-center bg-[var(--surface-lowest)] rounded-3xl border border-[var(--outline-variant)]/30">
                    <div class="max-w-xs mx-auto space-y-4">
                        <div class="w-14 h-14 bg-[var(--surface-low)] rounded-full flex items-center justify-center mx-auto border border-[var(--outline-variant)]/30 text-[var(--primary)]">
                            <i class="fa-solid fa-magnifying-glass text-lg"></i>
                        </div>
                        <h3 class="text-base font-medium text-[var(--on-surface)]">No products found</h3>
                        <p class="text-xs text-[var(--outline)]">Adjust your filters or try a different search.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="mt-12">
                <flux:pagination :paginator="$products" />
            </div>
        @endif
    </section>

    {{-- ==================== ASSURANCE STRIP ==================== --}}
    <section class="w-full bg-[var(--surface-high)] py-12 px-4 sm:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach([
                ['fa-workspace-premium', 'fa-solid fa-award', 'Verified Craftsmanship', 'Every piece is verified and curated by our team.'],
                ['fa-straighten', 'fa-solid fa-ruler-combined', 'Quality Guarantee', 'Complimentary adjustments and reliable after-sales care.'],
                ['fa-truck-fast', 'fa-solid fa-truck-fast', 'Fast Nationwide Delivery', 'Ships within 24–48 hours with escrow protection.'],
            ] as [$k, $icon, $title, $copy])
                <div class="flex items-start gap-3 p-5 bg-[var(--surface)] rounded-xl shadow-xs">
                    {{-- Brand-tinted icon badge --}}
                    <div class="w-10 h-10 rounded-full bg-[color-mix(in_srgb,var(--primary)_12%,transparent)] text-[var(--primary)] flex items-center justify-center shrink-0">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold uppercase tracking-wider text-[var(--on-surface)] mb-1">{{ $title }}</h4>
                        <p class="text-xs text-[var(--on-surface-variant)] font-light leading-relaxed">{{ $copy }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ==================== QUICK VIEW MODAL ==================== --}}
    @if($showQuickView && $quickViewProduct)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6"
            x-data="{ activePreview: '{{ $quickViewProduct->primary_image_url }}', open: true }"
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="$wire.closeQuickView()"
        >
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="open = false; $wire.closeQuickView()"></div>

            {{-- Panel --}}
            <div class="relative bg-white rounded-2xl w-full max-w-5xl max-h-[92vh] overflow-y-auto md:overflow-hidden md:h-[min(88vh,720px)] shadow-2xl z-10">

                {{-- Brand gradient accent bar at top of modal --}}
                <div class="absolute top-0 left-0 right-0 h-1 brand-accent-bar z-30 rounded-t-2xl"></div>

                {{-- Close --}}
                <button
                    @click="open = false; $wire.closeQuickView()"
                    class="absolute top-3 right-3 sm:top-4 sm:right-4 z-30 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/95 backdrop-blur-md text-[var(--on-surface)] hover:bg-[var(--on-surface)] hover:text-white flex items-center justify-center shadow-md transition-all"
                    aria-label="Close"
                >
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>

                <div class="md:flex md:h-full">

                    {{-- Image --}}
                    <div class="md:w-1/2 md:h-full shrink-0 relative bg-[var(--surface-low)]">
                        <div class="relative aspect-[4/5] md:aspect-auto md:absolute md:inset-0">
                            <img
                                :src="activePreview"
                                alt="{{ $quickViewProduct->name }}"
                                class="absolute inset-0 w-full h-full object-cover"
                            >
                            @if($quickViewProduct->sale_status)
                                <div class="absolute top-4 left-4 brand-sale-badge text-[10px] font-semibold tracking-[0.15em] uppercase px-3 py-1 rounded-full shadow-md">
                                    Sale
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="md:w-1/2 md:h-full md:flex md:flex-col">

                        <div class="p-5 sm:p-8 space-y-5 md:flex-1 md:overflow-y-auto">

                            {{-- Section + Title --}}
                            <div class="space-y-1.5 pr-10">
                                <span class="text-[10px] uppercase font-semibold tracking-[0.18em] text-[var(--secondary)] block">
                                    {{ $quickViewProduct->section->name ?? 'Uncategorized' }}
                                </span>
                                <h2 class="font-editorial text-xl sm:text-2xl md:text-3xl text-[var(--on-surface)] tracking-tight leading-tight">
                                    {{ $quickViewProduct->name }}
                                </h2>
                            </div>

                            {{-- Price + Stock --}}
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="flex items-baseline gap-2">
                                    @if($quickViewProduct->sale_status)
                                        <span class="text-xl sm:text-2xl font-semibold text-[var(--on-surface)]">₦{{ number_format($quickViewProduct->sales_price) }}</span>
                                        <span class="text-sm text-[var(--outline)] line-through">₦{{ number_format($quickViewProduct->price) }}</span>
                                    @else
                                        <span class="text-xl sm:text-2xl font-semibold text-[var(--on-surface)]">₦{{ number_format($quickViewProduct->price) }}</span>
                                    @endif
                                </div>

                                @if($quickViewProduct->stock > 0)
                                    <span class="inline-flex items-center gap-1.5 text-emerald-700 bg-emerald-50 text-[10px] font-medium px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                        In stock
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-rose-600 bg-rose-50 text-[10px] font-medium px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                        Out of stock
                                    </span>
                                @endif
                            </div>

                            {{-- Description --}}
                            @if($quickViewProduct->description)
                                <p class="text-sm text-[var(--on-surface-variant)] font-light leading-relaxed">
                                    {{ $quickViewProduct->description }}
                                </p>
                            @endif

                            {{-- Options --}}
                            @if($quickViewProduct->options)
                                <div class="space-y-3 pt-1">
                                    @foreach($quickViewProduct->options as $optionName => $values)
                                        <div class="space-y-2">
                                            <label class="block text-[10px] font-semibold text-[var(--outline)] uppercase tracking-[0.15em]">
                                                {{ $optionName }}
                                            </label>
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach($values as $value)
                                                    <button class="px-3 py-1.5 bg-[var(--surface-low)] text-[var(--on-surface)] rounded-full border border-transparent hover:border-[var(--primary)] text-xs font-medium transition-all cursor-pointer">
                                                        {{ $value }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Gallery — active thumb uses brand primary border --}}
                            @if($quickViewProduct->images->isNotEmpty())
                                <div class="pt-1">
                                    <label class="block text-[10px] font-semibold text-[var(--outline)] uppercase tracking-[0.15em] mb-2">
                                        Gallery
                                    </label>
                                    <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1">
                                        <button
                                            type="button"
                                            @click="activePreview = '{{ $quickViewProduct->primary_image_url }}'"
                                            class="w-12 h-14 sm:w-14 sm:h-16 rounded-lg overflow-hidden shrink-0 bg-[var(--surface-low)] border-2 transition-all"
                                            :class="activePreview === '{{ $quickViewProduct->primary_image_url }}' ? 'border-[var(--primary)]' : 'border-transparent hover:border-[var(--outline-variant)]'"
                                        >
                                            <img src="{{ $quickViewProduct->primary_image_url }}" alt="" class="w-full h-full object-cover">
                                        </button>

                                        @foreach($quickViewProduct->images as $extraImg)
                                            @php $imageAssetPath = asset('storage/' . $extraImg->image_path); @endphp
                                            <button
                                                type="button"
                                                @click="activePreview = '{{ $imageAssetPath }}'"
                                                class="w-12 h-14 sm:w-14 sm:h-16 rounded-lg overflow-hidden shrink-0 bg-[var(--surface-low)] border-2 transition-all"
                                                :class="activePreview === '{{ $imageAssetPath }}' ? 'border-[var(--primary)]' : 'border-transparent hover:border-[var(--outline-variant)]'"
                                            >
                                                <img src="{{ $imageAssetPath }}" alt="" class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- CTA — hover uses brand primary --}}
                        <div class="p-5 sm:p-8 border-t border-[var(--outline-variant)]/30 bg-white md:shrink-0">
                            <button
                                wire:click="addToCart({{ $quickViewProduct->id }})"
                                wire:loading.attr="disabled"
                                class="w-full bg-[var(--on-surface)] text-white text-xs font-semibold tracking-[0.18em] uppercase py-3.5 sm:py-4 rounded-xl flex items-center justify-center gap-2 shadow-md disabled:opacity-70 disabled:cursor-not-allowed hover-brand-primary"
                            >
                                <span wire:loading.remove wire:target="addToCart({{ $quickViewProduct->id }})" class="flex items-center gap-2">
                                    Add to Cart
                                    <i class="fa-solid fa-basket-shopping text-xs"></i>
                                </span>
                                <span wire:loading wire:target="addToCart({{ $quickViewProduct->id }})" class="flex items-center gap-2">
                                    <i class="fa-solid fa-spinner animate-spin text-xs"></i>
                                    Adding...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
