@extends('layouts.web')

@section('title', 'Home')

@section('content')

    {{-- ==================== 1. HERO SECTION ==================== --}}
    <section class="relative w-full overflow-hidden bg-surface-cream">
        <div class="absolute -top-32 -right-24 w-[36rem] h-[36rem] rounded-full bg-primary-container/15 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-12 w-[28rem] h-[28rem] rounded-full bg-tertiary-fixed-dim/20 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter py-8 lg:py-24 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">

                {{-- Left: Typography + CTAs + Metrics --}}
                <div class="lg:col-span-6 flex flex-col space-y-5 lg:space-y-6">
{{--                    <div class="inline-flex items-center gap-2 self-start px-3.5 py-1.5 rounded-full bg-surface-subtle shadow-sm">--}}
{{--                        <span class="w-2 h-2 rounded-full bg-status-success animate-pulse"></span>--}}
{{--                        <span class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface">A place for brands, sellers, and customers</span>--}}
{{--                    </div>--}}

                    <h1 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl tracking-tight leading-[1.1] lg:leading-[1.08] text-on-surface">
                        Discover Brands.<br>
                        <span class="italic font-normal text-primary">Unlock Opportunities.</span><br>
                        Grow Together.
                    </h1>

                    <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant max-w-xl leading-relaxed">
                        Discover brands, shop products, and find new ways to sell. KING’S brings businesses, sales partners, and customers together in one place.
                    </p>

                    <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                        <a href="{{ route('brands') }}" class="inline-flex items-center justify-center font-label-lg text-label-lg bg-on-surface text-surface-card px-6 sm:px-8 py-3.5 sm:py-4 rounded-lg shadow-sm hover:bg-on-surface-variant transition-all duration-200">
                            Explore Brands
                            <span class="material-symbols-outlined ml-2 text-[18px]">arrow_forward</span>
                        </a>
                        <a href="{{ auth()->check() ? route('dashboard') : route('signup') }}" class="inline-flex items-center justify-center font-label-lg text-label-lg bg-primary-container text-on-primary-container px-6 sm:px-8 py-3.5 sm:py-4 rounded-lg shadow-sm hover:bg-tertiary-container transition-all duration-200 font-semibold">
                            Join KING'S
                        </a>
                    </div>

                    <div class="pt-4 lg:pt-8 grid grid-cols-3 gap-3 lg:gap-6 bg-surface-card p-4 lg:p-6 rounded-xl shadow-sm">
                        <div>
                            <div class="font-currency-display text-[18px] lg:text-currency-display text-on-surface">Discover</div>
                            <div class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted mt-1">Brands to explore</div>
                        </div>
                        <div>
                            <div class="font-currency-display text-[18px] lg:text-currency-display text-primary">Connect</div>
                            <div class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted mt-1">With sales partners</div>
                        </div>
                        <div>
                            <div class="font-currency-display text-[18px] lg:text-currency-display text-status-success">Grow</div>
                            <div class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted mt-1">Together on KING’S</div>
                        </div>
                    </div>
                </div>

                {{-- Right: Editorial image mosaic --}}
                <div class="lg:col-span-6 relative mt-4 lg:mt-0">
                    <div class="relative grid grid-cols-12 gap-2 lg:gap-4">
                        <div class="col-span-7 relative rounded-xl overflow-hidden shadow-md group aspect-[4/5] lg:aspect-auto lg:h-[430px]">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 alt="Curated leathercraft"
                                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuC9XRZnBL90B8ZHNMr-UagROPimVLkVhEQdfLx3sJlnf_HfEna_XMvr7f1dxDwFJGSTVLAcZ_I_c9E3JXAAjmq7C0gzW7biY7EJNGjP9ZDB4R6DmzGp-8mWpDTbvVXQe1YJiIFfT5GLcom0sveiT6mEbHrTb1pvX0Gzfv_SBZQkIb-BV1f96B6uuj-9PTHL83sJbxkIwjgTNxgrg241Gh0Zs1nTbUIW_tMC-cPppPRp" />
                            <div class="absolute inset-0 bg-gradient-to-t from-on-surface/75 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 lg:bottom-4 left-3 lg:left-4 right-3 lg:right-4 text-surface-card">
                                <span class="inline-block px-2.5 py-0.5 rounded-full bg-primary-container text-on-primary-container font-label-sm text-[10px] lg:text-label-sm font-bold uppercase mb-1">Featured Brand</span>
                                <p class="font-headline-sm text-headline-sm font-semibold">Explore Local Brands</p>
                                <p class="hidden lg:block font-body-sm text-body-sm text-surface-cream/80">Discover products from participating businesses</p>
                            </div>
                        </div>
                        <div class="col-span-5 flex flex-col gap-2 lg:gap-4">
                            <div class="relative rounded-xl overflow-hidden shadow-sm group flex-1 aspect-square lg:aspect-auto lg:h-[205px]">
                                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     alt="Botanical skincare"
                                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuAmkanAgPKWtZbCezxd8TQ-ngllxcdXThlmnSc0PftUc82E5N_e07b4UbOM7GpCJ-2pIMqk_A4INLHzE0iivqJHWKg8TnSMQN9Ngi3kvB7FzLTyAvIOLLYwyK7IP9_1duYQ86oRlKCSaeNGL0qAVg2FaTnc6utFSkc1f86RC5osCaMmqKJe0JNk19SmkA4g5hQnjbVDqEEm2Dk8MCaFbzoyUJROuetr8Yx7SMFsyzuD" />
                                <div class="absolute top-2 lg:top-3 right-2 lg:right-3 bg-surface-card/90 backdrop-blur-sm px-1.5 lg:px-2 py-0.5 lg:py-1 rounded text-on-surface font-label-sm text-[10px] lg:text-label-sm font-bold">Featured</div>
                            </div>
                            <div class="relative rounded-xl overflow-hidden shadow-sm group flex-1 aspect-square lg:aspect-auto lg:h-[205px]">
                                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     alt="Artisanal ceramics"
                                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQUdACcXwfFOfeNq-dfcOqrD47c1cFLQ87u7c2un35N7kD-kBunc5w6JRjp8GOHOSxCR1QI0kpb3hokOodRwV4ns07GZsGYyHg5CKW_Si0QSXHTtgCDNb-Y9b-yrkmVp4eseHys4x2SsQww2oc4eNuvHFvsNK1D_SD2JdPDtlyHXF5ZZuBRQoKGp_kwLq-D7CqWy-cJJDlu6yoFrtKX7CIBb-cU7b6c1g-OgqoBG3u" />
                                <div class="absolute inset-0 bg-gradient-to-t from-on-surface/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-2 lg:bottom-3 left-2 lg:left-3 text-surface-card">
                                    <span class="font-label-sm text-[9px] lg:text-label-sm uppercase tracking-wide text-primary-fixed">Featured Collection</span>
                                    <p class="hidden lg:block font-label-lg text-label-lg font-bold">Products for every day</p>
                                </div>
                            </div>
                        </div>
                    </div>

{{--                    <div class="hidden lg:flex absolute -bottom-[4rem] -left-6 bg-surface-card p-4 rounded-xl shadow-lg items-center gap-3">--}}
{{--                        <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container">--}}
{{--                            <span class="material-symbols-outlined text-[20px]">verified</span>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <p class="font-label-md text-label-md text-on-surface font-bold">Commerce That Connects</p>--}}
{{--                            <p class="font-body-sm text-body-sm text-text-muted">Brands, sellers, and customers in one ecosystem</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

            </div>
        </div>
    </section>

    {{-- ==================== 2. FEATURED BRANDS SECTION ==================== --}}
    <section class="w-full py-12 lg:py-20 bg-surface-subtle">
        <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter space-y-6 lg:space-y-12">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 lg:gap-6">
                <div class="space-y-2 max-w-xl">
                    <div class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">Discover the businesses</div>
                    <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface">Brands Worth Discovering</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Explore brands, discover their products, and find businesses worth knowing.
                    </p>
                </div>
                <a href="{{ route('brands') }}" class="inline-flex items-center gap-2 font-label-lg text-label-lg text-on-surface hover:text-primary transition-colors pb-1 group self-start md:self-auto">
                    <span>View All Brands</span>
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            @if($brands->count() > 0)
                {{-- Mobile: horizontal swipe / Desktop: 4-col grid --}}
                <div class="flex overflow-x-auto gap-3 lg:grid lg:grid-cols-4 lg:gap-6 snap-x snap-mandatory no-scrollbar -mx-margin-mobile px-margin-mobile lg:mx-0 lg:px-0 pb-2">
                    @foreach($brands as $brand)
                        <div class="snap-start shrink-0 w-[260px] lg:w-auto bg-surface-card rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    @if($brand->image)
                                        <img src="{{ Storage::url($brand->image) }}" alt="{{ $brand->brand_name }}"
                                             class="w-12 h-12 rounded-lg object-cover shadow-sm" />
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center font-headline-sm text-headline-sm font-bold text-primary">
                                            {{ substr($brand->brand_name, 0, 2) }}
                                        </div>
                                    @endif
                                    <span class="px-2.5 py-1 rounded-full bg-surface-subtle font-label-sm text-label-sm text-on-surface-variant font-medium truncate max-w-[120px]">
                                    {{ $brand->subcategoryModel->name ?? 'General' }}
                                </span>
                                </div>

                                <div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface truncate">{{ $brand->brand_name }}</h3>
                                    <p class="font-body-sm text-body-sm text-text-muted mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-amber-500">star</span>
                                        <span class="text-on-surface font-semibold">
                                        {{ $brand->ratings()->avg('rating') > 0 ? number_format($brand->ratings()->avg('rating'), 1) : '0.0' }}
                                    </span>
                                        <span class="text-text-muted">•</span>
                                        <span>{{ $brand->products->count() }} SKUs</span>
                                    </p>
                                </div>
                            </div>

                            <div class="pt-6">
                                <a href="{{ route('shop', $brand) }}"
                                   class="w-full inline-flex items-center justify-center font-label-md text-label-md py-2.5 px-4 rounded-lg bg-surface-subtle text-on-surface hover:bg-surface-container transition-colors font-semibold">
                                    Explore Brand
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="max-w-md mx-auto text-center py-16 px-4 space-y-6">
                    <div class="relative w-20 h-20 mx-auto flex items-center justify-center">
                        <div class="absolute inset-0 bg-primary/5 rounded-full blur-xl"></div>
                        <div class="relative w-16 h-16 bg-surface-card border border-border-hairline rounded-2xl flex items-center justify-center shadow-sm">
                            <span class="material-symbols-outlined text-[24px] text-text-tertiary">storefront</span>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-primary-container rounded-full animate-pulse"></span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-headline-sm text-headline-sm text-on-surface tracking-tight">Discover Brands on KING’S</h3>
                        <p class="font-body-sm text-body-sm text-text-muted leading-relaxed max-w-xs mx-auto">
                            There are no brands to show right now. Check the full directory to see what’s available.
                        </p>
                    </div>
                    <a href="{{ route('brands') }}" class="inline-block bg-inverse-surface hover:bg-on-surface text-surface-card font-label-md text-label-md px-5 py-3 rounded-xl transition shadow-sm">
                        View Brands
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- ==================== 3. FEATURED PRODUCTS SECTION ==================== --}}
    <section class="w-full py-12 lg:py-20 bg-surface-cream">
        <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter space-y-6 lg:space-y-12">

            {{-- Header + Category Filter Tabs --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 lg:gap-6">
                <div class="space-y-2">
                    <div class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">Explore the catalogue</div>
                    <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface">Products Worth Discovering</h2>
                </div>
                <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 no-scrollbar">
                    <button class="px-4 py-2 rounded-lg bg-on-surface text-surface-card font-label-md text-label-md whitespace-nowrap">All Products</button>
                    @if(isset($categories) && $categories->count() > 0)
                        @foreach($categories as $category)
                            <a href="{{ route('brands', ['selectedCategory' => $category->id]) }}"
                               class="px-4 py-2 rounded-lg bg-surface-card text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-colors whitespace-nowrap">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            @if($featuredProducts->count() > 0)
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6">
                    @foreach($featuredProducts as $product)
                        <div class="bg-surface-card rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between">
                            <div class="relative">
                                <div class="aspect-square lg:aspect-[4/5] overflow-hidden bg-surface-container">
                                    @if($product->images->count() > 0)
                                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                             src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-4xl font-bold text-text-tertiary">
                                            {{ strtoupper(substr($product->name, 0, 1)) }}
                                        </span>
                                        </div>
                                    @endif
                                </div>
                                <button aria-label="Save item"
                                        class="absolute top-2 lg:top-3 right-2 lg:right-3 w-7 lg:w-8 h-7 lg:h-8 rounded-full bg-surface-card/80 backdrop-blur text-on-surface hover:bg-surface-card flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined text-[16px] lg:text-[18px]">favorite</span>
                                </button>
                            </div>
                            <div class="p-3 lg:p-5 space-y-2 lg:space-y-3 flex-1 flex flex-col justify-between">
                                <div>
                                    <p class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wide text-text-muted truncate">
                                        {{ $product->brand->brand_name }}
                                    </p>
                                    <h4 class="font-label-md text-label-md lg:font-headline-sm lg:text-headline-sm text-on-surface mt-1 group-hover:text-primary transition-colors line-clamp-2">
                                        {{ $product->name }}
                                    </h4>
                                </div>
                                <div class="pt-1 lg:pt-2">
                                    <div class="flex items-baseline justify-between">
                                        <span class="font-currency-display text-[16px] lg:text-currency-display text-on-surface">₦{{ number_format($product->price) }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('shop', ['brand' => $product->brand, 'search' => $product->name]) }}"
                                   class="w-full mt-1 py-2 lg:py-2.5 px-3 lg:px-4 bg-on-surface text-surface-card rounded-lg font-label-md text-label-md hover:bg-on-surface-variant transition-colors flex items-center justify-center gap-1.5 lg:gap-2">
                                    <span class="material-symbols-outlined text-[15px] lg:text-[16px]">shopping_bag</span>
                                    <span class="truncate">Shop or Sell</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="max-w-md mx-auto text-center py-16 px-4 space-y-6">
                    <div class="relative w-20 h-20 mx-auto flex items-center justify-center">
                        <div class="absolute inset-0 bg-primary/5 rounded-full blur-xl"></div>
                        <div class="relative w-16 h-16 bg-surface-card border border-border-hairline rounded-2xl flex items-center justify-center shadow-sm">
                            <span class="material-symbols-outlined text-[24px] text-text-tertiary">shopping_bag</span>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-primary-container rounded-full animate-pulse"></span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-headline-sm text-headline-sm text-on-surface tracking-tight">No Featured Products Yet</h3>
                        <p class="font-body-sm text-body-sm text-text-muted leading-relaxed max-w-xs mx-auto">
                            Check back soon for products from brands on KING’S, or explore the brand directory in the meantime.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- ==================== 4. ACTIVE SALES PREVIEW ==================== --}}
    <section class="w-full py-12 lg:py-20 bg-surface-subtle">
        <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter space-y-6 lg:space-y-12">

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 lg:gap-6">
                <div class="space-y-2">
                    <div class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">Offers from participating brands</div>
                    <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface">Deals Worth Checking Out</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                        Explore brands running promotions and discover offers currently available on KING’S.
                    </p>
                </div>
                <a href="{{ route('sales') }}" class="inline-flex items-center gap-2 font-label-lg text-label-lg text-on-surface hover:text-primary transition-colors pb-1 group self-start md:self-auto">
                    <span>Explore All Sales</span>
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-8">
                {{-- Promo 1 --}}
                <div class="relative bg-surface-card rounded-2xl overflow-hidden shadow-sm p-5 lg:p-8 flex flex-col justify-between">
                    <div class="relative z-10 space-y-3 lg:space-y-4 max-w-md">
                    <span class="inline-block px-3 py-1 rounded-full bg-status-warning/10 text-status-warning font-label-sm text-label-sm font-bold uppercase tracking-wider">
                        For shoppers
                    </span>
                        <h3 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface">Find Your Next Deal</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            Explore current promotions from participating brands and find products that fit your needs.
                        </p>
                        <div class="pt-2 flex flex-wrap items-center gap-4">
                            <a href="{{ route('sales') }}" class="inline-flex items-center justify-center font-label-md text-label-md bg-on-surface text-surface-card px-5 py-3 rounded-lg shadow-sm hover:bg-on-surface-variant transition-colors">
                                Explore Sales
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Promo 2 --}}
                <div class="relative bg-surface-card rounded-2xl overflow-hidden shadow-sm p-5 lg:p-8 flex flex-col justify-between">
                    <div class="relative z-10 space-y-3 lg:space-y-4 max-w-md">
                    <span class="inline-block px-3 py-1 rounded-full bg-primary-container/20 text-primary font-label-sm text-label-sm font-bold uppercase tracking-wider">
                        For sales partners
                    </span>
                        <h3 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface">Find Products to Sell</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            Discover products from participating brands that you can promote without holding inventory, subject to each brand’s arrangements.
                        </p>
                        <div class="pt-2 flex flex-wrap items-center gap-4">
                            <a href="{{ route('sales') }}" class="inline-flex items-center justify-center font-label-md text-label-md bg-primary-container text-on-primary-container px-5 py-3 rounded-lg shadow-sm hover:bg-tertiary-container transition-colors font-semibold">
                                Explore Sales Opportunities
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== 5. WHY CHOOSE US ($featuresList) ==================== --}}
    @if(isset($featuresList) && count($featuresList) > 0)
        <section class="w-full py-12 lg:py-24 bg-surface-cream border-y border-border-hairline">
            <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter space-y-8 lg:space-y-12">
                <div class="text-center max-w-2xl mx-auto space-y-2 lg:space-y-3">
                    <div class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">Why KING’S</div>
                    <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface">A Simpler Way to Connect</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                    @foreach($featuresList as $feature)
                        <div class="bg-surface-card p-5 lg:p-6 rounded-xl border border-border-hairline shadow-sm flex gap-4">
                            <div class="w-10 h-10 bg-primary-container/20 text-primary rounded-lg flex items-center justify-center shrink-0">
                                <flux:icon name="{{ $feature['icon'] }}" class="w-5 h-5" />
                            </div>
                            <div>
                                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-1">{{ $feature['title'] }}</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">{{ $feature['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ==================== 6. ECOSYSTEM PATHWAYS (3 Roles) ==================== --}}
    <section class="w-full py-12 lg:py-24 bg-surface-cream">
        <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter space-y-8 lg:space-y-16">
            <div class="text-center max-w-2xl mx-auto space-y-2 lg:space-y-3">
                <div class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">One connected commerce ecosystem</div>
                <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface">One Ecosystem. Multiple Opportunities.</h2>
                <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant">
                    KING’S brings brand owners, independent sales partners, and customers together to make products easier to discover and new business opportunities easier to explore.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-8">
                {{-- Pathway 1: Brand Owners --}}
                <div class="bg-surface-card rounded-2xl p-5 lg:p-8 shadow-sm flex flex-col justify-between space-y-6 lg:space-y-8">
                    <div class="space-y-3 lg:space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[26px]">storefront</span>
                        </div>
                        <div class="font-label-sm text-label-sm uppercase tracking-wider text-text-muted">For businesses</div>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Brand Owners</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            Showcase your products, build your brand’s presence, and reach potential customers and sales partners.
                        </p>
                        <ul class="space-y-2.5 pt-2 text-on-surface-variant font-body-sm text-body-sm">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">check_circle</span><span>Reach potential sales partners</span></li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">check_circle</span><span>Showcase your products and brand</span></li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">check_circle</span><span>Build your reach through KING’S</span></li>
                        </ul>
                    </div>
                    <a href="{{ auth()->check() ? route('dashboard') : route('signup') }}"
                       class="w-full inline-flex items-center justify-center font-label-md text-label-md py-3 px-4 rounded-lg bg-surface-subtle text-on-surface hover:bg-surface-container font-semibold transition-colors">
                        Grow Your Brand
                    </a>
                </div>

                {{-- Pathway 2: Dropshippers (Highlighted) --}}
                <div class="bg-surface-card rounded-2xl p-5 lg:p-8 shadow-md flex flex-col justify-between space-y-6 lg:space-y-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 left-0 h-1.5 bg-primary-container"></div>
                    <div class="space-y-3 lg:space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-container/20 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[26px]">trending_up</span>
                        </div>
                        <div class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">For sales partners</div>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Dropshippers &amp; Sales Partners</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            Discover products from participating brands and promote the ones that fit your audience without holding inventory.
                        </p>
                        <ul class="space-y-2.5 pt-2 text-on-surface-variant font-body-sm text-body-sm">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">check_circle</span><span>Discover products from participating brands</span></li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">check_circle</span><span>Choose products that suit your audience</span></li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">check_circle</span><span>Build sales opportunities through promotion</span></li>
                        </ul>
                    </div>
                    <a href="{{ route('sales') }}"
                       class="w-full inline-flex items-center justify-center font-label-md text-label-md py-3 px-4 rounded-lg bg-primary-container text-on-primary-container font-semibold hover:bg-tertiary-container transition-colors shadow-sm">
                        Explore Sales Opportunities
                    </a>
                </div>

                {{-- Pathway 3: Customers --}}
                <div class="bg-surface-card rounded-2xl p-5 lg:p-8 shadow-sm flex flex-col justify-between space-y-6 lg:space-y-8">
                    <div class="space-y-3 lg:space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-on-surface">
                            <span class="material-symbols-outlined text-[26px]">local_mall</span>
                        </div>
                        <div class="font-label-sm text-label-sm uppercase tracking-wider text-text-muted">For customers</div>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Direct Customers</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            Discover brands, explore products, and find promotions from businesses on KING’S.
                        </p>
                        <ul class="space-y-2.5 pt-2 text-on-surface-variant font-body-sm text-body-sm">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">check_circle</span><span>Explore a range of brands and products</span></li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">check_circle</span><span>Find offers from participating brands</span></li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">check_circle</span><span>Connect with businesses on KING’S</span></li>
                        </ul>
                    </div>
                    <a href="{{ route('brands') }}"
                       class="w-full inline-flex items-center justify-center font-label-md text-label-md py-3 px-4 rounded-lg bg-surface-subtle text-on-surface hover:bg-surface-container font-semibold transition-colors">
                        Discover Brands
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== 7. HOW KING'S WORKS (Steps) ==================== --}}
    <section class="w-full py-12 lg:py-20 bg-surface-subtle">
        <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter space-y-8 lg:space-y-12">
            <div class="space-y-2 max-w-lg">
                <div class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">How it works</div>
                <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface">How KING’S Works</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Choose how you want to take part in the KING’S ecosystem.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-8">
                <div class="bg-surface-card p-5 lg:p-8 rounded-xl shadow-sm space-y-3 lg:space-y-4">
                    <div class="w-10 h-10 rounded-full bg-surface-subtle text-on-surface flex items-center justify-center font-bold">1</div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Discover brands and products</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Browse brands and products to find what interests you.
                    </p>
                </div>
                <div class="bg-surface-card p-5 lg:p-8 rounded-xl shadow-sm space-y-3 lg:space-y-4">
                    <div class="w-10 h-10 rounded-full bg-surface-subtle text-on-surface flex items-center justify-center font-bold">2</div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Connect with opportunities that fit you</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Shop as a customer, promote products as a sales partner, or bring your brand to KING’S.
                    </p>
                </div>
                <div class="bg-surface-card p-5 lg:p-8 rounded-xl shadow-sm space-y-3 lg:space-y-4">
                    <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold">3</div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Shop, sell, and grow through the ecosystem</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Connect with the products, people, and opportunities that fit your goals.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== 8. CLOSING CTA ==================== --}}
    <section class="w-full py-12 lg:py-24 bg-surface-cream relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-container/10 via-transparent to-tertiary-fixed/15 pointer-events-none"></div>
        <div class="max-w-5xl mx-auto px-margin-mobile lg:px-gutter relative z-10 text-center space-y-6 lg:space-y-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-subtle shadow-sm">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface">Join the KING’S community</span>
            </div>
            <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl tracking-tight max-w-3xl mx-auto text-on-surface">
                Your Next Opportunity Starts Here.
            </h2>
            <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                Whether you own a brand, want to sell products, or are looking for something to buy, there’s a place for you on KING’S.
            </p>
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3 lg:gap-4">
                <a href="{{ auth()->check() ? route('dashboard') : route('signup') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center font-label-lg text-label-lg bg-primary-container text-on-primary-container px-8 lg:px-10 py-3.5 lg:py-4 rounded-lg shadow-md hover:bg-tertiary-container transition-all duration-200 font-bold active:scale-[0.98]">
                    Join KING'S Today
                </a>
                <a href="{{ route('brands') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center font-label-lg text-label-lg bg-surface-card text-on-surface px-8 py-3.5 lg:py-4 rounded-lg shadow-sm hover:bg-surface-subtle transition-all duration-200">
                    Explore Brands
                </a>
            </div>
            <div class="pt-6 lg:pt-8 flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-text-muted font-label-sm text-label-sm">
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-status-success">lock</span>Discover brands</span>
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-status-success">bolt</span>Sell without holding inventory</span>
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-status-success">payments</span>Connect. Sell. Grow.</span>
            </div>
        </div>
    </section>

@endsection
