<div class="w-full">
    {{-- ==================== 1. HERO / INTRO ==================== --}}
    <section class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter pt-6 md:pt-10 lg:pt-14 pb-4 md:pb-8">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 lg:gap-8">

            <div class="space-y-3 max-w-3xl">
{{--                <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-subtle rounded-full">--}}
{{--                    <span class="w-1.5 h-1.5 rounded-full bg-status-success animate-pulse"></span>--}}
{{--                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface">--}}
{{--                        Explore the KING'S Brand Directory • {{ number_format($brands->total()) }} Brand{{ $brands->total() === 1 ? '' : 's' }}--}}
{{--                    </span>--}}
{{--                </div>--}}
                <h1 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl text-on-surface tracking-tight leading-tight">
                    Discover Brands.<br class="hidden lg:inline" />
                    <span class="italic font-normal text-primary">Find Your Next Opportunity.</span>
                </h1>
                <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant max-w-2xl leading-relaxed">
                    Discover businesses and products on KING'S. Explore brands, find products you love, and uncover opportunities to connect, sell, and grow.
                </p>
            </div>

            {{-- Desktop only — brand discovery highlight --}}
            <div class="hidden lg:flex items-center gap-4 bg-surface-card p-4 rounded-xl shadow-sm shrink-0 self-end">
                <div class="w-12 h-12 rounded-lg bg-surface-subtle flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-2xl">verified_user</span>
                </div>
                <div class="space-y-0.5">
                    <div class="font-label-sm text-label-sm uppercase tracking-wider text-text-muted">The KING'S Network</div>
                    <div class="font-headline-sm text-headline-sm text-on-surface font-bold">Discover. Connect. Grow.</div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant">Find brands and products on KING'S</div>
                </div>
            </div>
        </div>

        {{-- Mobile only — brand discovery highlight --}}
        <div class="mt-4 lg:hidden p-3 rounded-xl bg-surface-card shadow-sm flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined text-[18px]">verified_user</span>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="font-label-md text-label-md text-on-surface">Discover. Connect. Grow. Collective</span>
                <span class="font-body-sm text-body-sm text-text-muted">Find brands and products on KING'S</span>
            </div>
        </div>
    </section>

    {{-- ==================== 2. CONTROLS ==================== --}}
    <section class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter pb-6 md:pb-8">
        <div class="bg-surface-card p-4 lg:p-6 rounded-xl shadow-sm space-y-4">

            {{-- Search + Sort + Reset --}}
            <div class="flex flex-col lg:flex-row gap-3 lg:gap-4 items-stretch lg:items-center justify-between">

                {{-- Search --}}
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-4 text-text-muted text-[20px] pointer-events-none">search</span>
                    <input
                        wire:model.live.debounce.300ms="search"
                        type="search"
                        placeholder="Search brands or products..."
                        class="w-full h-12 pl-11 pr-10 bg-surface-subtle rounded-lg font-body-md text-body-md text-on-surface placeholder:text-text-muted focus:outline-none focus:bg-surface-container-low transition-colors" />
                    @if($search)
                        <button wire:click="$set('search', '')"
                                aria-label="Clear search"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-on-surface p-1">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    @endif
                </div>

                {{-- Sort + Reset --}}
                <div class="flex items-center gap-3">
                    <div class="relative flex-1 lg:flex-initial">
                        <select wire:model.live="sort"
                                class="w-full lg:w-56 appearance-none h-12 py-3 pl-4 pr-10 bg-surface-subtle rounded-lg font-label-lg text-label-lg text-on-surface focus:outline-none cursor-pointer">
                            <option value="featured">Sort: Featured First</option>
                            <option value="recently_added">Sort: Recently Added</option>
                            <option value="most_products">Sort: Most Products</option>
                            <option value="alpha">Sort: Alphabetical (A-Z)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-3 text-text-muted pointer-events-none text-lg">expand_more</span>
                    </div>
                    <button wire:click="clearFilters"
                            class="h-12 px-4 bg-surface-subtle text-on-surface hover:bg-surface-container-low rounded-lg font-label-lg text-label-lg transition-colors flex items-center gap-1.5 whitespace-nowrap">
                        <span class="material-symbols-outlined text-base">restart_alt</span>
                        <span class="hidden lg:inline">Reset</span>
                    </button>
                </div>
            </div>

            {{-- Category chips --}}
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1 -mx-4 px-4 lg:mx-0 lg:px-0 lg:flex-wrap">
                <button wire:click="$set('selectedCategory', null); $set('selectedSubcategory', null); resetPage()"
                        class="shrink-0 whitespace-nowrap px-4 py-2 rounded-full font-label-md text-label-md transition-all {{ !$selectedCategory && !$selectedSubcategory ? 'bg-inverse-surface text-inverse-on-surface shadow-sm' : 'bg-surface-subtle text-on-surface hover:bg-surface-container-high' }}">
                    All Categories
                </button>
                @foreach($categories as $category)
                    <button wire:click="$set('selectedCategory', {{ $selectedCategory == $category->id ? 'null' : $category->id }}); $set('selectedSubcategory', null); resetPage()"
                            class="shrink-0 whitespace-nowrap px-4 py-2 rounded-full font-label-md text-label-md transition-all {{ $selectedCategory == $category->id ? 'bg-inverse-surface text-inverse-on-surface shadow-sm' : 'bg-surface-subtle text-on-surface hover:bg-surface-container-high' }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            {{-- Subcategory chips — appear when a category (or a subcategory via its parent) is active --}}
            @php
                $activeCategory = $selectedCategory
                    ? $categories->firstWhere('id', $selectedCategory)
                    : ($selectedSubcategory
                        ? $categories->first(fn($c) => $c->subcategories->contains('id', $selectedSubcategory))
                        : null);
            @endphp
            @if($activeCategory && $activeCategory->subcategories->count() > 0)
                <div class="flex items-center gap-2 pt-3 overflow-x-auto no-scrollbar border-t border-border-hairline -mx-4 px-4 lg:mx-0 lg:px-0 lg:flex-wrap">
                    <span class="shrink-0 font-label-sm text-label-sm uppercase tracking-wider text-text-muted pr-1">Subcategory:</span>
                    @foreach($activeCategory->subcategories as $sub)
                        <button wire:click="filterBySubcategory({{ $sub->id }})"
                                class="shrink-0 whitespace-nowrap px-3 py-1.5 rounded-full font-label-md text-label-md transition-all {{ $selectedSubcategory == $sub->id ? 'bg-primary-container text-on-primary-container shadow-sm font-bold' : 'bg-surface-subtle text-on-surface-variant hover:text-on-surface' }}">
                            {{ $sub->name }}
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Results count --}}
            <div class="flex items-center justify-between pt-1 font-label-sm text-label-sm text-text-muted">
            <span>
                @if($brands->total() > 0)
                    Showing <span class="font-semibold text-on-surface">{{ $brands->firstItem() }}</span>
                    – <span class="font-semibold text-on-surface">{{ $brands->lastItem() }}</span>
                    of <span class="font-semibold text-on-surface">{{ $brands->total() }}</span>
                @else
                    No brands
                @endif
            </span>
                @if($search)
                    <span class="truncate">"<span class="text-on-surface">{{ $search }}</span>"</span>
                @endif
            </div>
        </div>
    </section>

    {{-- ==================== 3. BRANDS GRID ==================== --}}
    <section class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter pb-12 md:pb-20">
        @if($brands->count() > 0)
            <div class="flex flex-col gap-4 lg:grid lg:grid-cols-2 xl:grid-cols-3 lg:gap-6">
                @foreach($brands as $brand)
                    <article class="bg-surface-card rounded-xl p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col gap-3.5 lg:gap-4">

                        {{-- Header row --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($brand->image)
                                    <img src="{{ Storage::url($brand->image) }}" alt="{{ $brand->brand_name }}"
                                         class="w-12 h-12 rounded-lg object-cover shadow-inner shrink-0" />
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-surface-subtle flex items-center justify-center font-headline-sm text-headline-sm text-primary font-bold shrink-0">
                                        {{ strtoupper(substr($brand->brand_name, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-1.5">
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface truncate">
                                            {{ $brand->brand_name }}
                                        </h2>
                                        <span class="material-symbols-outlined text-[18px] text-primary-container shrink-0"
                                              style="font-variation-settings: 'FILL' 1;"
                                              title="Brand listed on KING'S">verified</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-text-muted truncate">
                                    {{ $brand->subcategoryModel->name ?? 'General' }}
                                </span>
                                </div>
                            </div>
                            <span class="px-2 py-1 rounded-md bg-secondary-container text-on-secondary-container font-label-sm text-label-sm tracking-wide shrink-0">
                            {{ $brand->products->count() }} Product{{ $brand->products->count() === 1 ? '' : 's' }}
                        </span>
                        </div>

                        {{-- Description --}}
                        @php $brandDescription = $brand->description ?: ($brand->about ?? null); @endphp
                        @if($brandDescription)
                            <p class="font-body-sm text-body-sm text-text-muted leading-relaxed line-clamp-2">
                                {{ $brandDescription }}
                            </p>
                        @endif

                        {{-- Product preview strip (up to 3) --}}
                        @if($brand->products->count() > 0)
                            <div class="grid grid-cols-3 gap-2 rounded-lg overflow-hidden">
                                @foreach($brand->products->take(3) as $product)
                                    <div class="aspect-square bg-surface-subtle overflow-hidden">
                                        @if($product->primary_image_url)
                                            <img src="{{ $product->primary_image_url }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover" />
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-primary font-bold text-lg">
                                                {{ strtoupper(substr($product->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Footer --}}
                        <div class="flex items-center justify-between pt-2 mt-auto border-t border-border-hairline">
                            <div class="flex items-center gap-1.5 text-status-success font-label-sm text-label-sm">
                                <span class="w-2 h-2 rounded-full bg-status-success"></span>
                                <span>Explore this brand</span>
                            </div>
                            <a href="{{ route('shop', $brand) }}"
                               class="px-3 lg:px-4 py-2 rounded-lg bg-inverse-surface text-inverse-on-surface font-label-md text-label-md hover:bg-on-surface transition-colors flex items-center gap-1.5">
                                <span>Explore</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($brands->hasPages())
                <div class="mt-10 md:mt-12">
                    {{ $brands->links() }}
                </div>
            @endif
        @else
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center text-center p-8 md:p-16 bg-surface-card rounded-2xl shadow-sm">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-surface-subtle flex items-center justify-center text-text-muted mb-4">
                    <span class="material-symbols-outlined text-2xl md:text-3xl">search_off</span>
                </div>
                <h3 class="font-headline-md text-headline-md font-bold text-on-surface mb-2">No brands found</h3>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-md mb-6">
                    We couldn't find any brands matching your search or selected category. Try another search or clear your filters.
                </p>
                <button wire:click="clearFilters"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-inverse-surface text-inverse-on-surface font-label-lg text-label-lg rounded-lg shadow hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-lg">filter_alt_off</span>
                    <span>Clear Filters</span>
                </button>
            </div>
        @endif
    </section>

    {{-- ==================== 4. STATS BANNER ==================== --}}
    <section class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter pb-12 md:pb-16">
        <div class="bg-surface-card rounded-2xl p-5 lg:p-8 shadow-sm">
            <div class="flex items-center justify-between mb-4 lg:mb-0">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-primary uppercase tracking-widest">Built for Connection</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">One Place to Discover and Grow</h3>
                </div>
                <span class="material-symbols-outlined text-primary text-[24px] hidden lg:block">query_stats</span>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6 pt-1 lg:pt-6">
                <div class="bg-surface-subtle lg:bg-transparent rounded-xl lg:rounded-none p-3.5 lg:p-0 flex flex-col gap-1">
                    <div class="font-currency-display text-[20px] lg:text-currency-display text-primary">Discover</div>
                    <div class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted">Brands and products</div>
                </div>
                <div class="bg-surface-subtle lg:bg-transparent rounded-xl lg:rounded-none p-3.5 lg:p-0 flex flex-col gap-1">
                    <div class="font-currency-display text-[20px] lg:text-currency-display text-on-surface">Connect</div>
                    <div class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted">Brands and sales partners</div>
                </div>
                <div class="bg-surface-subtle lg:bg-transparent rounded-xl lg:rounded-none p-3.5 lg:p-0 flex flex-col gap-1">
                    <div class="font-currency-display text-[20px] lg:text-currency-display text-status-success">Sell</div>
                    <div class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted">Product opportunities</div>
                </div>
                <div class="bg-surface-subtle lg:bg-transparent rounded-xl lg:rounded-none p-3.5 lg:p-0 flex flex-col gap-1">
                    <div class="font-currency-display text-[20px] lg:text-currency-display text-primary-container">Grow</div>
                    <div class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted">Business reach</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== 5. BRAND-OWNER CTA ==================== --}}
    <section class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter pb-16 md:pb-24">
        <div class="relative overflow-hidden rounded-2xl bg-inverse-surface text-inverse-on-surface p-6 lg:p-14 xl:p-16 shadow-xl">
            <div class="absolute -right-16 lg:-right-20 -top-16 lg:top-auto lg:-bottom-20 w-48 lg:w-96 h-48 lg:h-96 bg-primary-container/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl space-y-4 lg:space-y-6">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary-fixed font-semibold">For Brand Owners</span>
                </div>
                <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-white tracking-tight">
                    Have a Brand of <span class="italic text-primary-fixed">Your Own?</span>
                </h2>
                <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-surface-subtle/80 max-w-2xl leading-relaxed">
                    Bring your brand to KING'S, showcase your products, and make it easier for customers and sales partners to discover what you offer.
                </p>

                <div class="flex flex-wrap gap-2 pt-1">
                    <div class="px-3 py-1.5 rounded-full bg-white/5 text-inverse-on-surface font-label-sm text-label-sm flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary-fixed text-[16px]">check_circle</span>
                        <span>Showcase your products</span>
                    </div>
                    <div class="px-3 py-1.5 rounded-full bg-white/5 text-inverse-on-surface font-label-sm text-label-sm flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary-fixed text-[16px]">hub</span>
                        <span>Reach sales partners</span>
                    </div>
                    <div class="px-3 py-1.5 rounded-full bg-white/5 text-inverse-on-surface font-label-sm text-label-sm flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary-fixed text-[16px]">local_shipping</span>
                        <span>Grow your visibility</span>
                    </div>
                </div>

                <div class="pt-3 lg:pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 lg:gap-4">
                    <a href="{{ auth()->check() ? route('dashboard') : route('signup') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 lg:px-8 py-3 lg:py-4 bg-primary-container text-on-surface font-label-lg text-label-lg font-bold rounded-lg shadow-md hover:bg-tertiary-container transition-all duration-200 active:scale-95">
                        <span>Bring Your Brand to KING'S</span>
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </a>
                    <a href="#"
                       class="inline-flex items-center justify-center gap-2 px-4 lg:px-6 py-3 lg:py-4 bg-transparent text-white hover:text-primary-container font-label-lg text-label-lg transition-colors">
                        <span>Discover How KING'S Works</span>
                        <span class="material-symbols-outlined text-base">north_east</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
