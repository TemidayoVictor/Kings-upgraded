<div class="pb-24">

    <!-- Editorial Split Hero Configuration Layer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <!-- Dynamic Theme Color Injection for this Specific Hero Component Container -->
        <style>
            :root {
                --primary: {{ $brand->brandSetting->primary_color ?? '#000000' }};
                --secondary: {{ $brand->brandSetting->secondary_color ?? '#f7f6f2' }};
            }
        </style>

        <div class="bg-[var(--secondary)] rounded-[2em] overflow-hidden grid grid-cols-1 lg:grid-cols-12 items-center min-h-[520px] relative border border-black/[0.02]">
            <div class="absolute inset-0 bg-gradient-to-tr from-white/30 to-transparent pointer-events-none"></div>

            <!-- Left Text Content -->
            <div class="p-8 sm:p-12 lg:p-20 lg:col-span-7 relative z-10 space-y-6">
            <span class="text-xs font-bold tracking-[4px] uppercase text-neutral-500 block">
                {{ $brand->brandSetting->hero_tagline ?? 'curated lifestyle collections' }}
            </span>

                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-light tracking-tight text-neutral-900 leading-[1.05] serif-display">
                    {{ $brand->brandSetting->hero_title_line_1 ?? 'Elixirs for the' }}
                    <br>
                    <span class="text-[var(--primary)] font-normal italic">
                    {{ $brand->brandSetting->hero_title_line_2_italic ?? 'modern identity.' }}
                </span>
                </h1>

                <p class="text-sm sm:text-base text-neutral-600 max-w-md font-light leading-relaxed">
                    {{ $brand->brandSetting->hero_description ?? 'Radiant serums, cold‑pressed botanical extractions. Formulated seamlessly to anchor your everyday morning skin glow routine.' }}
                </p>

                <div class="pt-4">
                    <button class="bg-neutral-950 text-white text-xs font-medium tracking-widest uppercase px-8 py-4.5 rounded-full hover:bg-[var(--primary)] transition-all duration-300 shadow-xl hover:-translate-y-1 flex items-center gap-3 group">
                        {{ $brand->brandSetting->hero_button_text ?? 'Discover Bestsellers' }}
                        <i class="fa-solid fa-arrow-right-long transition-transform group-hover:translate-x-1.5"></i>
                    </button>
                </div>
            </div>

            <!-- Right Visual Layout Box -->
            <div class="hidden lg:block lg:col-span-5 h-full relative self-stretch overflow-hidden">
                @if($brand->image)
                    <!-- Full-Bleed Brand Image Layer -->
                    <img
                        src="{{ asset('storage/' . $brand->image) }}"
                        alt="{{ $brand->brand_name }} Brand Showcase"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                @else
                    <!-- Balanced Glassmorphism Centered Placeholder -->
                    <div class="absolute inset-0 flex items-center justify-center p-12 bg-neutral-950/5">
                        <div class="w-full h-full rounded-[32px] border border-white/20 bg-gradient-to-b from-white/20 to-transparent backdrop-blur-md shadow-2xl flex items-center justify-center">
                            <i class="fa-solid fa-wand-magic-sparkles text-7xl text-[var(--primary)] opacity-40"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Core Dynamic Catalog Interface Container Framework -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">

        <!-- Modern Layout: Left Filter Sidebar, Right Product Catalog Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

            <!-- Structural Sidebar Panel Left (Desktop Filters) -->
            <div class="lg:col-span-3 sticky top-28 space-y-8 hidden lg:block">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-4">Catalog Discovery</h4>
                    <div class="relative">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Type to search..."
                            class="w-full bg-white text-neutral-800 text-xs rounded-lg border border-neutral-200 outline-none focus:border-[var(--primary)] focus:ring-[var(--primary)] px-5 py-4 pl-11 transition-all"
                        >
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 text-xs"></i>
                    </div>
                </div>

                <!-- Structural List Categories -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-3">Categories</h4>
                    <div class="flex flex-col gap-1">
                        <button
                            wire:click="$set('selectedSection', 'all')"
                            class="w-full text-left px-3 py-2.5 rounded-xl text-xs font-medium tracking-wide transition-all flex items-center justify-between {{ $selectedSection === 'all' ? 'bg-[var(--primary-muted)] text-[var(--primary)] font-semibold' : 'text-neutral-600 hover:bg-neutral-50' }}"
                        >
                            <span>All Products</span>
                            <i class="fa-solid fa-circle-nodes text-[10px] opacity-60"></i>
                        </button>
                        @foreach($sections as $section)
                            <button
                                wire:click="$set('selectedSection', {{ $section->id }})"
                                class="w-full text-left px-3 py-2.5 rounded-xl text-xs font-medium tracking-wide transition-all flex items-center justify-between {{ $selectedSection == $section->id ? 'bg-[var(--primary-muted)] text-[var(--primary)] font-semibold' : 'text-neutral-600 hover:bg-neutral-50' }}"
                            >
                                <span class="truncate">{{ $section->name }}</span>
                                <i class="fa-solid fa-chevron-right text-[9px] opacity-40"></i>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range Component Segment -->
                <div class="pt-4 border-t border-neutral-100 mb-3">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-4">Filter By Price</h4>
                    <div class="bg-white p-4 rounded-2xl border border-neutral-100 space-y-4">
                        <div class="flex items-center justify-between text-xs text-neutral-500 font-medium">
                            <span>₦{{ number_format($priceRange[0]) }}</span>
                            <span>₦{{ number_format($priceRange[1]) }}</span>
                        </div>
                        <div class="flex gap-2">
                            <input
                                type="range"
                                wire:model.live="priceRange.0"
                                min="{{ $minPrice }}"
                                max="{{ $maxPrice }}"
                                class="w-full accent-[var(--primary)] cursor-pointer"
                            >
                            <input
                                type="range"
                                wire:model.live="priceRange.1"
                                min="{{ $minPrice }}"
                                max="{{ $maxPrice }}"
                                class="w-full accent-[var(--primary)] cursor-pointer"
                            >
                        </div>
                    </div>
                </div>

                <div class="w-full">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-4">Sort By</h4>
                    <select
                        wire:model.live="sortBy"
                        class="w-full bg-neutral-50 text-neutral-700 text-xs font-medium px-4 py-2.5 rounded-lg border border-neutral-200 focus:ring-1 focus:ring-[var(--primary)] focus:border-[var(--primary)] outline-none"
                    >
                        <option value="newest">Newest</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>

            <!-- Right Segment Content Panel (Catalog Display Elements) -->
            <div class="lg:col-span-9 space-y-8">

                <!-- Toolbar Header Control Block (Mobile Navigation Layer & General Sorting) -->
                <div class="bg-white p-4 rounded-2xl border border-[var(--primary)] flex flex-col sm:flex-row gap-4 items-center justify-between sm:hidden">

                    <!-- Search Input element container (Visible only on smaller screens) -->
                    <div class="w-full lg:hidden relative">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search catalog products..."
                            class="w-full bg-neutral-50 text-neutral-800 text-xs rounded-xl border border-neutral-200 px-4 py-3 pl-10"
                        >
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-neutral-400 text-xs"></i>
                    </div>

                    <div class="w-full">
                        <select
                            wire:model.live="sortBy"
                            class="w-full bg-neutral-50 text-neutral-700 text-xs font-medium px-4 py-2.5 rounded-lg border border-neutral-200 focus:ring-1 focus:ring-[var(--primary)] focus:border-[var(--primary)] outline-none"
                        >
                            <option value="newest">Newest</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="popular">Most Popular</option>
                        </select>
                    </div>

                    <!-- Category Pills Display layout wrapper view (Visible only on smaller screens) -->
                    <div class="w-full lg:hidden overflow-x-auto no-scrollbar flex gap-2 pb-1">
                        <button wire:click="$set('selectedSection', 'all')" class="text-xs px-4 py-2 shrink-0 rounded-lg {{ $selectedSection === 'all' ? 'bg-neutral-900 text-white' : 'bg-neutral-100 text-neutral-600' }}">All</button>
                        @foreach($sections as $section)
                            <button wire:click="$set('selectedSection', {{ $section->id }})" class="text-xs px-4 py-2 shrink-0 rounded-lg {{ $selectedSection == $section->id ? 'bg-neutral-900 text-white' : 'bg-neutral-100 text-neutral-600' }}">{{ $section->name }}</button>
                        @endforeach
                    </div>
                </div>

                <!-- Products Grid Element -->
                <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-6">
                    @forelse($products as $product)
                        <div
                            wire:key="product-{{ $product->id }}"
                            class="group card-smooth rounded-lg overflow-hidden flex flex-col justify-between relative h-full bg-white"
                        >
                            <div class="relative aspect-[4/5] bg-neutral-50/70 flex items-center justify-center border-b border-neutral-100/40 overflow-hidden">
                                @if($product->primary_image_url)
                                    <img
                                        src="{{ $product->primary_image_url }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-neutral-100/40">
                                        <i class="fa-regular fa-image text-2xl sm:text-4xl text-neutral-300"></i>
                                    </div>
                                @endif

                                <div class="absolute inset-0 bg-neutral-950/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden sm:flex items-center justify-center backdrop-blur-xs">
                                    <button
                                        wire:click="quickView({{ $product->id }})"
                                        class="bg-white text-neutral-900 text-xs font-semibold px-5 py-3 rounded-xl shadow-xl hover:bg-neutral-950 hover:text-white transition-all transform translate-y-2 group-hover:translate-y-0 duration-500"
                                    >
                                        Inspect Item
                                    </button>
                                </div>

                                <button
                                    wire:click="quickView({{ $product->id }})"
                                    class="absolute inset-0 w-full h-full sm:hidden focus:outline-none"
                                    title="Quick view product details"
                                ></button>

                                @if($product->discount_price)
                                    <div class="absolute top-2 left-2 sm:top-4 sm:left-4 bg-[var(--primary)] text-white text-[8px] sm:text-[9px] font-bold tracking-widest uppercase px-2 py-1 sm:px-3 sm:py-1.5 rounded-md shadow-sm z-10">
                                        Sale
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 sm:p-6 space-y-3 sm:space-y-4 flex-1 flex flex-col justify-between">
                                <div class="space-y-0.5 sm:space-y-1">
                                    <span class="text-[8px] sm:text-[10px] uppercase font-bold tracking-wider text-[var(--primary)]">
                                        {{ $product->section->name ?? 'Uncategorized' }}
                                    </span>
                                    <h3 class="text-xs sm:text-base font-medium text-neutral-800 line-clamp-1 group-hover:text-[var(--primary)] transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                </div>

                                <div class="flex items-center justify-between pt-1.5 sm:pt-2 border-t border-neutral-50 gap-1">
                                    <div class="flex flex-wrap items-baseline gap-1 sm:gap-2">
                                        @if($product->sale_status)
                                            <span class="text-sm sm:text-lg font-semibold text-neutral-900">₦{{ number_format($product->sales_price) }}</span>
                                            <span class="text-[10px] sm:text-xs text-neutral-400 line-through">₦{{ number_format($product->price) }}</span>
                                        @else
                                            <span class="text-sm sm:text-lg font-semibold text-neutral-900">₦{{ number_format($product->price) }}</span>
                                        @endif
                                    </div>

                                    <div class="relative shrink-0">
                                        <button
                                            wire:click="addToCart({{ $product->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="addToCart({{ $product->id }})"
                                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-neutral-50 hover:bg-[var(--primary)] border border-neutral-200 hover:border-[var(--primary)] text-neutral-700 hover:text-white flex items-center justify-center transition-all duration-300"
                                            title="Add item to checkout box"
                                        >
                                            <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                                <i class="fa-solid fa-plus text-[10px] sm:text-xs"></i>
                                            </span>
                                            <span wire:loading wire:target="addToCart({{ $product->id }})">
                                                <i class="fa-solid fa-spinner animate-spin text-[10px] sm:text-xs"></i>
                                            </span>
                                        </button>

                                        @if($addedToCart === $product->id)
                                            <div class="absolute -top-8 -right-1 bg-emerald-600 text-white w-5 h-5 rounded-full shadow-md flex items-center justify-center animate-bounce z-10">
                                                <i class="fa-solid fa-check text-[8px]"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-neutral-100">
                            <div class="max-w-xs mx-auto space-y-4">
                                <div class="w-14 h-14 bg-neutral-50 rounded-full flex items-center justify-center mx-auto border border-neutral-100 text-neutral-400">
                                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                                </div>
                                <h3 class="text-base font-medium text-neutral-900">No products found</h3>
                                <p class="text-xs text-neutral-400 font-light">
                                    Adjust your filters or try a different search.
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination navigation drawer layer -->
                <div class="pt-6">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Features Banner Block Container Layer Layout -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-32">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 bg-white p-8 rounded-[32px] border border-neutral-100 shadow-xs">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-neutral-50 border border-neutral-100 rounded-2xl flex items-center justify-center shrink-0 text-[var(--primary)]">
                    <i class="fa-solid fa-truck-fast text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Free Logistics</h4>
                    <p class="text-xs text-neutral-400 mt-0.5 font-light">Orders qualifying above thresholds</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-neutral-50 border border-neutral-100 rounded-2xl flex items-center justify-center shrink-0 text-[var(--primary)]">
                    <i class="fa-solid fa-seedling text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Organic Sourcing</h4>
                    <p class="text-xs text-neutral-400 mt-0.5 font-light">Certified premium botanical craft</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-neutral-50 border border-neutral-100 rounded-2xl flex items-center justify-center shrink-0 text-[var(--primary)]">
                    <i class="fa-solid fa-arrow-rotate-left text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Easy Returns</h4>
                    <p class="text-xs text-neutral-400 mt-0.5 font-light">Complimentary return option window</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-neutral-50 border border-neutral-100 rounded-2xl flex items-center justify-center shrink-0 text-[var(--primary)]">
                    <i class="fa-solid fa-box-open text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Premium Wrapping</h4>
                    <p class="text-xs text-neutral-400 mt-0.5 font-light">Elegant customized presentation box</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Overlay Dialog Node Module Modal -->
    @if($showQuickView && $quickViewProduct)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            x-data
            x-show="$wire.showQuickView"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="$wire.closeQuickView()"
        >
            <div class="absolute inset-0 bg-neutral-950/40 backdrop-blur-md" @click="$wire.closeQuickView()"></div>

            <div class="relative bg-white rounded-[32px] max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-neutral-100/50 z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-10">

                    <!-- Frame Gallery Node -->
                    <div class="aspect-square bg-neutral-50 rounded-2xl overflow-hidden p-6 flex items-center justify-center border border-neutral-100">
                        @if($quickViewProduct->primary_image_url)
                            <img src="{{ $quickViewProduct->primary_image_url }}" alt="{{ $quickViewProduct->name }}" class="w-full h-full object-contain mix-blend-multiply">
                        @endif
                    </div>

                    <!-- Meta specs Details section properties window -->
                    <div class="flex flex-col justify-between py-2">
                        <div class="space-y-4">
                            <div>
                                <span class="text-[10px] uppercase font-bold tracking-widest text-[var(--primary)]">
                                    {{ $quickViewProduct->section->name ?? 'Uncategorized' }}
                                </span>
                                <h2 class="text-2xl sm:text-3xl font-light text-neutral-900 tracking-tight serif-display mt-1">
                                    {{ $quickViewProduct->name }}
                                </h2>
                            </div>

                            <div class="flex items-center gap-3">
                                @if($quickViewProduct->discount_price)
                                    <span class="text-2xl font-semibold text-neutral-900">₦{{ number_format($quickViewProduct->discount_price) }}</span>
                                    <span class="text-sm text-neutral-400 line-through">₦{{ number_format($quickViewProduct->price) }}</span>
                                    <span class="bg-[var(--primary-muted)] text-[var(--primary)] text-[10px] font-bold px-2.5 py-1 rounded-md">-{{ $quickViewProduct->discount_percentage }}%</span>
                                @else
                                    <span class="text-2xl font-semibold text-neutral-900">₦{{ number_format($quickViewProduct->price) }}</span>
                                @endif
                            </div>

                            <p class="text-xs text-neutral-500 font-light leading-relaxed">{{ $quickViewProduct->description }}</p>

                            <div class="pt-2">
                                @if($quickViewProduct->stock > 0)
                                    <span class="inline-flex items-center gap-2 text-emerald-700 bg-emerald-50 text-[11px] font-medium px-3 py-1.5 rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                        Available Item Status ({{ $quickViewProduct->stock }} items)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 text-rose-600 bg-rose-50 text-[11px] font-medium px-3 py-1.5 rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                        Out of stock inventory marker
                                    </span>
                                @endif
                            </div>

                            @if($quickViewProduct->options)
                                <div class="space-y-3 pt-2">
                                    @foreach($quickViewProduct->options as $optionName => $values)
                                        <div>
                                            <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-2">{{ $optionName }}</label>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($values as $value)
                                                    <button class="px-4 py-2 bg-white text-neutral-700 rounded-xl border border-neutral-200 hover:border-[var(--primary)] transition-all text-xs font-medium">
                                                        {{ $value }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Panel Execution Buttons Drawer -->
                        <button
                            wire:click="addToCart({{ $quickViewProduct->id }})"
                            wire:loading.attr="disabled"
                            class="w-full bg-neutral-950 text-white text-xs font-medium tracking-widest uppercase py-4.5 rounded-xl hover:bg-[var(--primary)] transition-colors mt-8 flex items-center justify-center gap-2.5 shadow-xl"
                        >
                            <span wire:loading.remove wire:target="addToCart({{ $quickViewProduct->id }})">Add Item to Cart Box</span>
                            <span wire:loading wire:target="addToCart({{ $quickViewProduct->id }})">Synchronizing...</span>
                            <i class="fa-solid fa-basket-shopping text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Escape Window Trigger Close Target Control button -->
                <button
                    wire:click="closeQuickView"
                    class="absolute top-5 right-5 text-neutral-400 hover:text-neutral-900 transition-colors w-10 h-10 rounded-full flex items-center justify-center hover:bg-neutral-50"
                >
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        </div>
    @endif
</div>
