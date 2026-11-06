
@extends('layouts.web')

@section('title', 'Discover Products & Deals | KING’S')

@section('content')
    <div class="w-full">

        {{-- ==================== 1. HERO ==================== --}}
        <section class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter pt-6 md:pt-10 lg:pt-14 pb-4 md:pb-8">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 lg:gap-8">

                <div class="max-w-3xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-subtle rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-status-success animate-pulse"></span>
                        <span class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface">
                            Discover • Shop • Sell
                        </span>
                    </div>
                    <h1 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl text-on-surface tracking-tight leading-tight">
                        Discover Great Products.<br class="hidden lg:inline" />
                        <span class="italic font-normal text-primary">Find Your Next Deal.</span>
                    </h1>
                    <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant max-w-2xl leading-relaxed">
                        Explore products and special offers from brands on KING’S. Shop what you love or discover products to grow your business.
                    </p>
                </div>

                {{-- Desktop only --}}
                <div class="hidden lg:flex items-center gap-3 bg-surface-card p-4 rounded-xl shadow-sm shrink-0 self-end">
                    <div class="w-10 h-10 rounded-lg bg-surface-subtle flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[24px]">storefront</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-headline-sm text-headline-sm text-on-surface font-bold">
                                {{ number_format($sales->total()) }} Sales
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase bg-primary-container/30 text-on-primary-container">
                                Live Offers
                            </span>
                        </div>
                        <p class="font-body-sm text-body-sm text-text-muted">Discover offers from brands on KING’S</p>
                    </div>
                </div>
            </div>

            {{-- Mobile only — live feed ticker --}}
            <div class="lg:hidden flex items-center justify-between gap-2 px-3 py-2 mt-4 bg-surface-subtle rounded-full">
                <div class="flex items-center gap-1.5 min-w-0">
                    <span class="w-2 h-2 rounded-full bg-status-success animate-pulse shrink-0"></span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary truncate">
                        {{ number_format($sales->total()) }} Brand Sales
                    </span>
                </div>
                <div class="flex items-center gap-1 bg-surface-card px-2 py-0.5 rounded-full shadow-sm shrink-0">
                    <span class="material-symbols-outlined text-[14px] text-tertiary">storefront</span>
                    <span class="font-label-sm text-label-sm text-on-surface">Explore Deals</span>
                </div>
            </div>
        </section>

        {{-- ==================== 2. FILTER TOOLBAR ==================== --}}
        @php
            $visibleCategories = $sales->map(fn($s) => $s->brand?->subcategoryModel?->name)->filter()->unique()->values();
        @endphp
        <section class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter pb-4 md:pb-6">
            <div class="bg-surface-card p-4 lg:p-6 rounded-xl shadow-sm space-y-4">

                <div class="flex flex-col lg:flex-row gap-3 lg:gap-4 items-stretch lg:items-center justify-between">

                    {{-- Search --}}
                    <form method="GET" action="{{ url()->current() }}" class="relative flex-1">
                        <span class="material-symbols-outlined absolute left-3.5 top-4 text-text-muted text-[20px] pointer-events-none">
                            search
                        </span>
                        <input
                            id="promo-search-input"
                            name="search"
                            type="search"
                            value="{{ $search }}"
                            placeholder="Search products, brands, deals, or tags..."
                            class="w-full h-12 pl-11 pr-24 bg-surface-subtle rounded-lg font-body-md text-body-md text-on-surface placeholder:text-text-muted focus:outline-none focus:bg-surface-container-low transition-colors"
                        />
                        <button
                            type="submit"
                            class="absolute right-2 top-1.5 h-9 px-4 rounded-md bg-on-surface text-surface-card text-sm font-semibold hover:bg-primary transition-colors"
                        >
                            Search
                        </button>

                    </form>

                    {{-- Sort --}}
                    <div class="flex items-center gap-3">
                        <label for="sort-dropdown" class="hidden sm:inline-block font-label-md text-label-md text-text-muted">Sort:</label>
                        <div class="relative flex-1 lg:flex-initial min-w-[190px]">
                            <select id="sort-dropdown"
                                    class="w-full h-12 appearance-none bg-surface-subtle text-on-surface font-label-lg text-label-lg px-4 pr-10 rounded-lg focus:outline-none cursor-pointer">
                                <option value="newest">Newest First</option>
                                <option value="ending">Ending Soon</option>
                                <option value="name">Brand Name (A-Z)</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-2.5 text-text-muted pointer-events-none text-lg">keyboard_arrow_down</span>
                        </div>
                    </div>
                </div>

                {{-- Category pills --}}
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1 -mx-4 px-4 lg:mx-0 lg:px-0 lg:flex-wrap">
                    <button type="button"
                            class="cat-pill active shrink-0 px-4 py-1.5 rounded-full font-label-md text-label-md transition-all bg-on-surface text-surface-card shadow-sm font-semibold"
                            data-category="all">
                        All Categories
                    </button>
                    @foreach($visibleCategories as $categoryName)
                        <button type="button"
                                class="cat-pill shrink-0 px-4 py-1.5 rounded-full font-label-md text-label-md transition-all bg-surface-subtle text-on-surface-variant hover:bg-surface-container-high font-medium"
                                data-category="{{ strtolower($categoryName) }}">
                            {{ $categoryName }}
                        </button>
                    @endforeach
                </div>

                {{-- Supporting text + reset --}}
                <div class="flex items-center justify-between pt-1 border-t border-border-hairline">
                    <div class="flex items-center gap-1.5 font-label-sm text-label-sm text-text-muted">
                        <span class="material-symbols-outlined text-[16px] text-status-success">storefront</span>
                        <span class="hidden sm:inline">Explore products from brands on KING’S</span>
                        <span class="sm:hidden">Explore KING’S brands</span>
                    </div>
                    <button type="button" id="reset-filters-btn"
                            class="flex items-center gap-1 text-text-muted hover:text-primary transition-colors font-label-sm text-label-sm py-1">
                        <span class="material-symbols-outlined text-[14px]">refresh</span>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </section>

        {{-- ==================== 3. BRAND SALES ==================== --}}
        <section class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter pb-12 md:pb-16">
            <div class="flex items-end justify-between pb-4 md:pb-6">
                <div>
                    <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface tracking-tight">
                        Explore Brand Sales
                    </h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                        Discover products and special offers from brands across KING’S.
                    </p>
                </div>
                <span class="hidden md:inline-block font-label-sm text-label-sm uppercase tracking-widest text-text-muted shrink-0">
                    Shop from brands
                </span>
            </div>

            @if($sales->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 lg:gap-8" id="sales-grid">
                    @foreach($sales as $sale)
                        @php
                            // Discount badge text
                            if ($sale->sale_mode === 'generic') {
                                $discountBadge = $sale->discount_type === 'percentage'
                                    ? number_format($sale->discount_value, 0) . '% OFF'
                                    : '₦' . number_format($sale->discount_value, 0) . ' OFF';
                            } else {
                                $discountBadge = 'Special Offer';
                            }

                            $isUpcoming = $sale->starts_at->isFuture();
                            $isEnded = $sale->ends_at->isPast();

                            $categoryName = $sale->brand?->subcategoryModel?->name ?? 'General';
                            $categoryKey = strtolower($categoryName);
                        @endphp

                        <article class="sale-brand-card bg-surface-card rounded-xl shadow-md overflow-hidden flex flex-col justify-between transition-transform duration-300 hover:-translate-y-1"
                                 data-cat="{{ $categoryKey }}"
                                 data-name="{{ strtolower($sale->brand?->brand_name ?? '') }}"
                                 data-ends="{{ $sale->ends_at->timestamp }}"
                                 data-starts="{{ $sale->starts_at->timestamp }}">

                            <div class="p-5 md:p-6 lg:p-8 space-y-5 md:space-y-6">
                                {{-- Header --}}
                                <div class="flex items-start justify-between gap-3 md:gap-4">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                                            <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold truncate">
                                                {{ $categoryName }}
                                            </span>
                                            <span class="w-1.5 h-1.5 rounded-full bg-border-hairline shrink-0"></span>
                                            @props(['isUpcoming' => false, 'isEnded' => false])

                                            @php
                                                $statusConfig = $isUpcoming
                                                    ? ['label' => 'Upcoming', 'classes' => 'bg-amber-50 text-amber-700 border-amber-200/70', 'dot' => 'bg-amber-500', 'pulse' => false]
                                                    : ($isEnded
                                                        ? ['label' => 'Ended',    'classes' => 'bg-stone-100 text-stone-500 border-stone-200/70',  'dot' => 'bg-stone-400',  'pulse' => false]
                                                        : ['label' => 'Ongoing',  'classes' => 'bg-emerald-50 text-emerald-700 border-emerald-200/70', 'dot' => 'bg-emerald-500', 'pulse' => true]);
                                            @endphp

                                            <span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-[11px] font-semibold tracking-wide uppercase {$statusConfig['classes']}"]) }}>
                                                <span class="relative flex h-1.5 w-1.5">
                                                    @if($statusConfig['pulse'])
                                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full {{ $statusConfig['dot'] }} opacity-75"></span>
                                                    @endif
                                                    <span class="relative inline-flex h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                                </span>
                                                {{ $statusConfig['label'] }}
                                            </span>
                                        </div>
                                        <h3 class="font-headline-md text-headline-md text-on-surface font-bold truncate">
                                            {{ $sale->brand?->brand_name }}
                                        </h3>
                                        <p class="font-headline-lg text-[16px] md:text-headline-lg text-on-surface-variant font-normal italic mt-1 line-clamp-1">
                                            {{ $sale->name }}
                                        </p>
                                    </div>
                                    <div class="flex flex-col items-end gap-1.5 shrink-0">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-primary-container text-on-primary-container shadow-sm whitespace-nowrap">
                                            {{ $discountBadge }}
                                        </span>
                                        <span class="font-body-sm text-body-sm text-text-muted flex items-center gap-1 whitespace-nowrap">
                                            <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                            @if($isUpcoming)
                                                Starts {{ $sale->starts_at->format('M d') }}
                                            @elseif($isEnded)
                                                Ended {{ $sale->ends_at->format('M d') }}
                                            @else
                                                Ends {{ $sale->ends_at->format('M d') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                {{-- Description --}}
                                @if($sale->description)
                                    <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2">
                                        {{ $sale->description }}
                                    </p>
                                @endif

                                {{-- Body: Upcoming notice OR Product preview --}}
                                @if($isUpcoming)
                                    <div class="rounded-xl border border-primary-container/30 bg-primary-container/10 p-5 md:p-6 flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-primary-container/20 text-primary-container flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-[20px]">hourglass_empty</span>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-headline-sm text-headline-sm text-on-surface font-semibold">Coming Soon</p>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                                                Begins {{ $sale->starts_at->format('M d, Y \a\t h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div class="grid grid-cols-2 gap-3 md:gap-4">
                                        @foreach($sale->products->take(2) as $product)
                                            <div class="bg-surface-cream rounded-lg p-2.5 md:p-3 flex gap-2.5 md:gap-3 items-center">
                                                <div class="w-14 h-14 md:w-16 md:h-16 rounded-md overflow-hidden bg-surface-subtle shrink-0">
                                                    @if($product->images->count() > 0)
                                                        <img src="{{ $product->primary_image_url }}"
                                                             alt="{{ $product->name }}"
                                                             class="w-full h-full object-cover" />
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-primary font-bold text-sm">
                                                            {{ strtoupper(substr($product->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <h4 class="font-label-md md:font-headline-sm md:text-headline-sm text-on-surface truncate font-semibold">
                                                        {{ $product->name }}
                                                    </h4>
                                                    <div class="flex items-baseline gap-1.5 mt-0.5 md:mt-1 flex-wrap">
                                                        <span class="font-currency-display text-[13px] md:text-[16px] text-primary font-bold">
                                                            ₦{{ number_format($product->sales_price ?? $product->price) }}
                                                        </span>
                                                        @if($product->sales_price && $product->sales_price < $product->price)
                                                            <span class="font-label-sm text-[10px] md:text-body-sm text-text-muted line-through">
                                                                ₦{{ number_format($product->price) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if($product->sales_price && $product->sales_price < $product->price)
                                                        <span class="inline-block mt-0.5 font-label-sm text-[9px] md:text-label-sm text-status-success uppercase font-semibold">
                                                            Save ₦{{ number_format($product->price - $product->sales_price) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            {{-- Footer --}}
                            <div class="bg-surface-subtle px-5 md:px-6 lg:px-8 py-3.5 md:py-4 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-1.5 text-text-muted font-body-sm text-body-sm min-w-0">
                                    <span class="material-symbols-outlined text-[16px] shrink-0">
                                        {{ $isUpcoming ? 'schedule' : ($isEnded ? 'block' : 'local_shipping') }}
                                    </span>
                                    <span class="truncate">
                                        @if($isUpcoming)
                                            Starts {{ $sale->starts_at->diffForHumans() }}
                                        @elseif($isEnded)
                                            Ended {{ $sale->ends_at->diffForHumans() }}
                                        @else
                                            Ends {{ $sale->ends_at->diffForHumans() }}
                                        @endif
                                    </span>
                                </div>
                                <a href="{{ route('shop', $sale->brand) }}"
                                   class="inline-flex items-center gap-1.5 font-label-md md:font-label-lg md:text-label-lg bg-on-surface text-surface-card hover:bg-primary transition-colors px-3.5 md:px-5 py-2 md:py-2.5 rounded-lg font-semibold shadow-sm shrink-0">
                                    <span>View Products</span>
                                    <span class="material-symbols-outlined text-[16px] md:text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($sales->hasPages())
                    <div class="mt-10 md:mt-12">
                        {{ $sales->links() }}
                    </div>
                @endif

                {{-- Client-side "no results" state (toggled by JS) --}}
                <div class="hidden mt-8 bg-surface-card p-10 md:p-12 rounded-xl text-center shadow-sm" id="sales-empty-state">
                    <div class="w-16 h-16 rounded-full bg-surface-subtle flex items-center justify-center text-text-muted mx-auto mb-4">
                        <span class="material-symbols-outlined text-[32px]">production_quantity_limits</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md text-on-surface font-semibold mb-2">
                        No Matching Products or Deals
                    </h3>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-md mx-auto mb-6">
                        Try another search or category to discover more products and offers.
                    </p>
                    <div class="flex items-center justify-center gap-3 md:gap-4 flex-wrap">
                        <button type="button" id="empty-reset-btn"
                                class="font-label-lg text-label-lg px-5 py-2.5 bg-surface-cream text-on-surface font-semibold rounded-lg hover:bg-surface-subtle transition-colors">
                            Clear Search
                        </button>
                        <a href="{{ route('brands') }}"
                           class="font-label-lg text-label-lg px-5 py-2.5 bg-on-surface text-surface-card font-semibold rounded-lg hover:bg-primary transition-colors">
                            View All Brands
                        </a>
                    </div>
                </div>
            @else
                {{-- Server-side empty state --}}
                <div class="max-w-md mx-auto text-center py-16 px-4 space-y-6">
                    <div class="relative w-20 h-20 mx-auto flex items-center justify-center">
                        <div class="absolute inset-0 bg-primary/5 rounded-full blur-xl"></div>
                        <div class="relative w-16 h-16 bg-surface-card border border-border-hairline rounded-2xl flex items-center justify-center shadow-sm">
                            <span class="material-symbols-outlined text-[24px] text-text-tertiary">storefront</span>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-primary-container rounded-full animate-pulse"></span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-headline-sm text-headline-sm text-on-surface tracking-tight">No Sales Available Right Now</h3>
                        <p class="font-body-sm text-body-sm text-text-muted leading-relaxed max-w-xs mx-auto">
                            There are no sales to explore at the moment. Browse our brands to discover more products.
                        </p>
                    </div>
                    <a href="{{ route('brands') }}"
                       class="inline-block bg-inverse-surface hover:bg-on-surface text-surface-card font-label-md text-label-md px-5 py-3 rounded-xl transition shadow-sm">
                        View All Brands
                    </a>
                </div>
            @endif
        </section>

        {{-- ==================== 4. FEATURED DEALS ==================== --}}
        @php
            $handpickedDeals = collect();
            foreach ($sales as $sale) {
                if ($sale->starts_at->isFuture()) continue;
                foreach ($sale->products as $product) {
                    if ($product->sales_price && $product->sales_price < $product->price) {
                        $handpickedDeals->push(['product' => $product, 'brand' => $sale->brand]);
                    }
                }
            }
            $handpickedDeals = $handpickedDeals->shuffle()->take(8);
        @endphp

        @if($handpickedDeals->count() > 0)
            <section class="w-full bg-surface-subtle py-12 md:py-16">
                <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter space-y-6 md:space-y-8">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 md:gap-4">
                        <div>
                            <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">Deals to Explore</span>
                            <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface tracking-tight mt-1">
                                Handpicked Deals
                            </h2>
                        </div>
                        <a href="{{ route('brands') }}"
                           class="inline-flex items-center gap-1.5 font-label-lg text-label-lg text-primary hover:text-on-surface transition-colors font-bold underline underline-offset-4 self-start md:self-auto">
                            <span>Explore All Brands</span>
                            <span class="material-symbols-outlined text-[18px]">north_east</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
                        @foreach($handpickedDeals as $deal)
                            @php
                                $product = $deal['product'];
                                $brand = $deal['brand'];
                                $savePercent = $product->price > 0
                                    ? round((1 - $product->sales_price / $product->price) * 100)
                                    : 0;
                            @endphp

                            <div class="bg-surface-card rounded-xl overflow-hidden shadow-sm flex flex-col group transition-transform duration-300 hover:-translate-y-1">
                                <div class="relative aspect-[4/5] bg-surface-cream overflow-hidden">
                                    @if($product->images->count() > 0)
                                        <img src="{{ $product->primary_image_url }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-primary font-bold text-3xl">
                                            {{ strtoupper(substr($product->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="absolute top-2 md:top-3 left-2 md:left-3 bg-on-surface text-surface-card font-label-sm text-[10px] md:text-label-sm px-2 md:px-2.5 py-0.5 md:py-1 rounded tracking-wider uppercase font-semibold">
                                        Save {{ $savePercent }}%
                                    </div>
                                    <div class="absolute top-2 md:top-3 right-2 md:right-3 bg-surface-card/90 backdrop-blur px-2 md:px-2.5 py-0.5 md:py-1 rounded text-[10px] md:text-[11px] font-bold text-on-surface shadow-xs truncate max-w-[80px] md:max-w-[120px]">
                                        {{ $brand?->brand_name }}
                                    </div>
                                </div>
                                <div class="p-3 md:p-5 flex flex-col flex-1 justify-between gap-2 md:gap-4">
                                    <div>
                                        <p class="font-label-sm text-[9px] md:text-label-sm uppercase tracking-wider text-text-muted truncate">
                                            {{ $brand?->subcategoryModel?->name ?? 'General' }}
                                        </p>
                                        <h4 class="font-label-md md:font-headline-sm md:text-headline-sm text-on-surface font-semibold mt-0.5 md:mt-1 line-clamp-2">
                                            {{ $product->name }}
                                        </h4>
                                    </div>
                                    <div class="flex flex-col gap-2 pt-1 md:pt-2">
                                        <div class="flex items-baseline gap-1.5 flex-wrap">
                                            <span class="font-currency-display text-[15px] md:text-currency-display text-on-surface">
                                                ₦{{ number_format($product->sales_price) }}
                                            </span>
                                            <span class="block font-label-sm text-[10px] md:text-body-sm text-text-muted line-through">
                                                ₦{{ number_format($product->price) }}
                                            </span>
                                        </div>
                                        <a href="{{ route('shop', ['brand' => $brand, 'search' => $product->name]) }}"
                                           class="w-full py-2 md:py-2.5 bg-surface-subtle hover:bg-inverse-surface hover:text-inverse-on-surface text-on-surface rounded-lg font-label-md text-label-md font-semibold transition-colors flex items-center justify-center gap-1">
                                            <span class="material-symbols-outlined text-[14px] md:text-[16px]">add_shopping_cart</span>
                                            <span>Order</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- ==================== 5. SALES PARTNER CTA ==================== --}}
        <section class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter py-12 md:py-20">
            <div class="bg-inverse-surface text-inverse-on-surface rounded-2xl p-6 md:p-8 lg:p-14 xl:p-16 shadow-xl relative overflow-hidden">
                <div class="absolute -right-16 lg:-right-20 -top-16 lg:top-0 w-52 lg:w-96 h-52 lg:h-96 bg-primary-container/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-3xl space-y-4 md:space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-surface-card/10 backdrop-blur-md text-primary-fixed">
                        <span class="material-symbols-outlined text-[16px]">storefront</span>
                        <span class="font-label-sm text-label-sm uppercase tracking-widest font-bold">Grow Your Business</span>
                    </div>

                    <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl tracking-tight leading-tight">
                        Find Products to Sell. <span class="italic text-primary-fixed-dim">Build Your Business.</span>
                    </h2>

                    <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-inverse-on-surface/80 max-w-2xl leading-relaxed">
                        Discover products from brands on KING’S and explore opportunities to sell to your own customers. Find products that fit your market and grow your business.
                    </p>

                    <div class="space-y-2.5 md:space-y-3.5 pt-1">
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 md:w-6 md:h-6 rounded-full bg-primary-container/20 text-primary-container flex items-center justify-center shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[14px] md:text-[16px] font-bold">check</span>
                            </div>
                            <span class="font-body-sm text-body-sm md:font-body-md md:text-body-md text-inverse-on-surface">
                                Discover products from participating brands
                            </span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 md:w-6 md:h-6 rounded-full bg-primary-container/20 text-primary-container flex items-center justify-center shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[14px] md:text-[16px] font-bold">check</span>
                            </div>
                            <span class="font-body-sm text-body-sm md:font-body-md md:text-body-md text-inverse-on-surface">
                                Explore ways to sell without buying stock upfront, subject to each brand’s terms
                            </span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 md:w-6 md:h-6 rounded-full bg-primary-container/20 text-primary-container flex items-center justify-center shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[14px] md:text-[16px] font-bold">check</span>
                            </div>
                            <span class="font-body-sm text-body-sm md:font-body-md md:text-body-md text-inverse-on-surface">
                                Find products your customers need and connect with brands
                            </span>
                        </div>
                    </div>

                    <div class="pt-3 md:pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 md:gap-4">
                        <a href="{{ auth()->check() ? route('dashboard') : route('signup') }}"
                           class="inline-flex items-center justify-center gap-2 px-6 md:px-8 py-3 md:py-4 bg-primary-container text-on-primary-container font-label-lg text-label-lg font-bold rounded-lg shadow-md hover:bg-tertiary-container transition-all active:scale-95">
                            <span>Start Selling with KING’S</span>
                            <span class="material-symbols-outlined text-[18px] md:text-[20px]">arrow_forward</span>
                        </a>
                        <a href="#"
                           class="inline-flex items-center gap-2 px-4 md:px-6 py-3 md:py-4 text-inverse-on-surface/70 hover:text-inverse-on-surface font-label-lg text-label-lg transition-colors">
                            <span>Do you own a brand?</span>
                            <span class="material-symbols-outlined text-[16px] md:text-[18px]">storefront</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    {{-- ==================== Client-side filter/sort (current page only) ==================== --}}
    @push('scripts')
        <script>
            (function initSalesDiscovery() {
                const searchInput = document.getElementById('promo-search-input');
                const sortSelect = document.getElementById('sort-dropdown');
                const categoryPills = document.querySelectorAll('.cat-pill');
                const cards = Array.from(document.querySelectorAll('.sale-brand-card'));
                const grid = document.getElementById('sales-grid');
                const emptyState = document.getElementById('sales-empty-state');
                const resetBtn = document.getElementById('reset-filters-btn');
                const emptyResetBtn = document.getElementById('empty-reset-btn');
                const paginationEl = document.querySelector('.mt-12');

                if (!grid || cards.length === 0) return;

                let currentCategory = 'all';
                let currentQuery = '';

                function filterAndSort() {
                    let visible = 0;

                    cards.forEach(card => {
                        const cat = card.getAttribute('data-cat') || '';
                        const name = card.getAttribute('data-name') || '';
                        const text = card.innerText.toLowerCase();

                        const matchesCat = currentCategory === 'all' || cat === currentCategory;
                        const matchesQuery = !currentQuery || name.includes(currentQuery) || text.includes(currentQuery);

                        if (matchesCat && matchesQuery) {
                            card.classList.remove('hidden');
                            visible++;
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    // Sort
                    const sortMode = sortSelect ? sortSelect.value : 'newest';
                    const sorted = [...cards].sort((a, b) => {
                        if (sortMode === 'ending') {
                            return parseInt(a.dataset.ends) - parseInt(b.dataset.ends);
                        }
                        if (sortMode === 'name') {
                            return a.dataset.name.localeCompare(b.dataset.name);
                        }
                        return parseInt(b.dataset.starts) - parseInt(a.dataset.starts); // newest
                    });
                    sorted.forEach(card => grid.appendChild(card));

                    // Empty state
                    if (emptyState) {
                        if (visible === 0) {
                            emptyState.classList.remove('hidden');
                            grid.classList.add('hidden');
                        } else {
                            emptyState.classList.add('hidden');
                            grid.classList.remove('hidden');
                        }
                    }
                }

                // Category pills
                categoryPills.forEach(pill => {
                    pill.addEventListener('click', () => {
                        categoryPills.forEach(p => {
                            p.classList.remove('bg-on-surface', 'text-surface-card', 'shadow-sm', 'font-semibold');
                            p.classList.add('bg-surface-subtle', 'text-on-surface-variant', 'font-medium');
                        });
                        pill.classList.remove('bg-surface-subtle', 'text-on-surface-variant', 'font-medium');
                        pill.classList.add('bg-on-surface', 'text-surface-card', 'shadow-sm', 'font-semibold');
                        currentCategory = pill.getAttribute('data-category') || 'all';
                        filterAndSort();
                    });
                });

                // Sort
                if (sortSelect) {
                    sortSelect.addEventListener('change', filterAndSort);
                }

                function resetAll() {
                    if (searchInput) searchInput.value = '';
                    if (sortSelect) sortSelect.value = 'newest';

                    currentQuery = '';
                    currentCategory = 'all';

                    categoryPills.forEach(p => {
                        if (p.getAttribute('data-category') === 'all') {
                            p.classList.add(
                                'bg-on-surface',
                                'text-surface-card',
                                'shadow-sm',
                                'font-semibold'
                            );

                            p.classList.remove(
                                'bg-surface-subtle',
                                'text-on-surface-variant',
                                'font-medium'
                            );
                        } else {
                            p.classList.remove(
                                'bg-on-surface',
                                'text-surface-card',
                                'shadow-sm',
                                'font-semibold'
                            );

                            p.classList.add(
                                'bg-surface-subtle',
                                'text-on-surface-variant',
                                'font-medium'
                            );
                        }
                    });

                    // Reload without search parameters.
                    if (searchInput?.form) {
                        searchInput.form.requestSubmit();
                        return;
                    }

                    filterAndSort();
                }

                if (resetBtn) resetBtn.addEventListener('click', resetAll);
                if (emptyResetBtn) emptyResetBtn.addEventListener('click', resetAll);
            })();
        </script>
    @endpush

@endsection
