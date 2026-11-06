@extends('layouts.web')

@section('title', 'Features')

@section('content')
    <div class="w-full">

        {{-- ==================== 1. HERO ==================== --}}
        <section class="relative w-full overflow-hidden bg-surface-cream py-10 md:py-14 lg:py-24">
            <div class="absolute -top-32 right-1/4 w-72 lg:w-96 h-72 lg:h-96 rounded-full bg-primary-container/15 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 -left-20 w-64 lg:w-80 h-64 lg:h-80 rounded-full bg-primary/10 blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter relative z-10">
                <div class="flex flex-col items-center text-center max-w-4xl mx-auto">

                    {{-- Overline --}}
                    <div class="inline-flex flex-wrap items-center justify-center gap-2 px-3 py-1 rounded-full bg-surface-subtle shadow-sm mb-5 lg:mb-6">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">How KING'S Works</span>
                        <span class="hidden sm:inline text-text-muted">/</span>
                        <span class="hidden sm:inline font-label-sm text-label-sm text-text-muted font-medium">Connect. Sell. Grow.</span>
                    </div>

                    <h1 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl text-on-surface tracking-tight mb-4 lg:mb-6 leading-tight">
                        More Than a Marketplace.<br>
                        <span class="italic font-normal text-primary">A Place for Business to Grow.</span>
                    </h1>

                    <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant max-w-2xl mx-auto mb-8 lg:mb-10 leading-relaxed">
                        KING'S brings brands, sales partners, and customers together. Brands can showcase their products, sales partners can help promote them, and customers can discover what they need.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center gap-3 lg:gap-4 w-full sm:w-auto">
                        <a href="#ecosystem-flow" class="w-full sm:w-auto inline-flex items-center justify-center font-label-lg text-label-lg bg-primary-container text-on-surface font-semibold px-6 lg:px-8 py-3.5 rounded-lg shadow-md hover:bg-tertiary-container transition-all">
                            See How KING'S Works
                            <span class="material-symbols-outlined ml-2 text-[18px]">south</span>
                        </a>
                        <a href="{{ route('brands') }}" class="w-full sm:w-auto inline-flex items-center justify-center font-label-lg text-label-lg bg-surface-card text-on-surface font-semibold px-6 lg:px-7 py-3.5 rounded-lg shadow-sm hover:bg-surface-subtle transition-all">
                            Explore Brands
                            <span class="material-symbols-outlined ml-2 text-[18px]">arrow_forward</span>
                        </a>
                    </div>

                    {{-- Metric Strip: 2-col mobile → 4-col desktop --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 w-full mt-10 lg:mt-16 lg:pt-8 lg:bg-surface-card lg:rounded-xl lg:p-6 lg:shadow-sm">
                        <div class="text-left px-3 py-3 rounded-xl bg-surface-card shadow-sm lg:shadow-none lg:bg-transparent lg:p-0 lg:px-2">
                            <span class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted">Made for Nigeria</span>
                            <p class="font-currency-display text-[18px] lg:text-currency-display text-on-surface mt-1">₦ NGN</p>
                            <span class="font-body-sm text-[11px] lg:text-body-sm text-status-success font-medium">Local commerce</span>
                        </div>
                        <div class="text-left px-3 py-3 rounded-xl bg-surface-card shadow-sm lg:shadow-none lg:bg-transparent lg:p-0 lg:px-2">
                            <span class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted">One platform</span>
                            <p class="font-currency-display text-[18px] lg:text-currency-display text-on-surface mt-1">3 groups</p>
                            <span class="font-body-sm text-[11px] lg:text-body-sm text-text-muted">Brands, sellers &amp; customers</span>
                        </div>
                        <div class="text-left px-3 py-3 rounded-xl bg-surface-card shadow-sm lg:shadow-none lg:bg-transparent lg:p-0 lg:px-2">
                            <span class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted">Sales partnerships</span>
                            <p class="font-currency-display text-[18px] lg:text-currency-display text-on-surface mt-1">Flexible</p>
                            <span class="font-body-sm text-[11px] lg:text-body-sm text-status-success font-medium">Based on agreement</span>
                        </div>
                        <div class="text-left px-3 py-3 rounded-xl bg-surface-card shadow-sm lg:shadow-none lg:bg-transparent lg:p-0 lg:px-2">
                            <span class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted">Inventory</span>
                            <p class="font-currency-display text-[18px] lg:text-currency-display text-on-surface mt-1">No stock</p>
                            <span class="font-body-sm text-[11px] lg:text-body-sm text-text-muted">Partners can promote without holding stock</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== 2. ECOSYSTEM INTERLOCKS ==================== --}}
        <section id="ecosystem-flow" class="w-full py-12 md:py-16 lg:py-20 bg-surface-subtle">
            <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 lg:mb-14 gap-4 lg:gap-6">
                    <div>
                        <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">Three Connected Groups</span>
                        <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface mt-2">How KING'S Brings Business Together</h2>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-md">
                        Each group plays a role: brands provide products, sales partners help reach more buyers, and customers discover and purchase products.
                    </p>
                </div>

                {{-- Mobile: stacked with connectors / Desktop: 3-col grid --}}
                <div class="flex flex-col gap-4 lg:grid lg:grid-cols-3 lg:gap-6 relative">
                    {{-- Participant 1: Brand Owners --}}
                    <div class="bg-surface-card rounded-xl p-6 lg:p-8 shadow-md flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div>
                            <div class="flex items-center justify-between mb-5 lg:mb-6">
                            <span class="w-12 h-12 rounded-lg bg-surface-cream text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined text-[26px]">storefront</span>
                            </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-surface-cream font-label-sm text-label-sm uppercase tracking-wider font-semibold text-primary">Product Owner</span>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Brand Owners</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-5 lg:mb-6">
                                Businesses and creators who want to showcase their products and reach more customers.
                            </p>
                            <div class="bg-surface-subtle p-4 rounded-lg space-y-3 mb-5 lg:mb-6">
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">Showcase products in a brand store</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">Set terms for sales partnerships</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">Manage and fulfill customer orders</span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 flex items-center justify-between bg-surface-cream -mx-6 lg:-mx-8 -mb-6 lg:-mb-8 p-4 lg:p-6 rounded-b-xl">
                            <span class="font-label-sm text-label-sm uppercase text-text-muted">Output</span>
                            <span class="font-label-lg text-label-lg font-bold text-on-surface">More Ways to Sell</span>
                        </div>
                    </div>

                    {{-- Connector (mobile only) --}}
                    <div class="flex justify-center -my-2 lg:hidden">
                        <span class="material-symbols-outlined text-[20px] text-primary">arrow_downward</span>
                    </div>

                    {{-- Participant 2: Sales Partners --}}
                    <div class="bg-surface-card rounded-xl p-6 lg:p-8 shadow-md flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative">
                        <div class="hidden lg:block absolute -top-3 left-1/2 -translate-x-1/2 bg-primary text-on-primary font-label-sm text-label-sm px-4 py-1 rounded-full uppercase tracking-wider font-semibold shadow">
                            Sales Partners
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-5 lg:mb-6">
                            <span class="w-12 h-12 rounded-lg bg-primary-container text-on-surface flex items-center justify-center">
                                <span class="material-symbols-outlined text-[26px]">groups</span>
                            </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-surface-cream font-label-sm text-label-sm uppercase tracking-wider font-semibold text-primary">Promoter</span>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Sales Partners</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-5 lg:mb-6">
                                People who want to promote products and connect them with potential customers.
                            </p>
                            <div class="bg-surface-subtle p-4 rounded-lg space-y-3 mb-5 lg:mb-6">
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">Promote products without holding stock</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">Share product links</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">Earn according to agreed terms</span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 flex items-center justify-between bg-surface-cream -mx-6 lg:-mx-8 -mb-6 lg:-mb-8 p-4 lg:p-6 rounded-b-xl">
                            <span class="font-label-sm text-label-sm uppercase text-text-muted">Output</span>
                            <span class="font-label-lg text-label-lg font-bold text-on-surface">More Customer Reach</span>
                        </div>
                    </div>

                    {{-- Connector (mobile only) --}}
                    <div class="flex justify-center -my-2 lg:hidden">
                        <span class="material-symbols-outlined text-[20px] text-primary">arrow_downward</span>
                    </div>

                    {{-- Participant 3: Customers --}}
                    <div class="bg-surface-card rounded-xl p-6 lg:p-8 shadow-md flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div>
                            <div class="flex items-center justify-between mb-5 lg:mb-6">
                            <span class="w-12 h-12 rounded-lg bg-surface-cream text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined text-[26px]">shopping_bag</span>
                            </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-surface-cream font-label-sm text-label-sm uppercase tracking-wider font-semibold text-primary">Buyer</span>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Customers</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-5 lg:mb-6">
                                Customers looking to discover products and shop from different brands in one place.
                            </p>
                            <div class="bg-surface-subtle p-4 rounded-lg space-y-3 mb-5 lg:mb-6">
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">Explore brand and product details</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">Review available order and payment details</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">Shop through the platform</span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 flex items-center justify-between bg-surface-cream -mx-6 lg:-mx-8 -mb-6 lg:-mb-8 p-4 lg:p-6 rounded-b-xl">
                            <span class="font-label-sm text-label-sm uppercase text-text-muted">Output</span>
                            <span class="font-label-lg text-label-lg font-bold text-on-surface">More Choice</span>
                        </div>
                    </div>
                </div>

                {{-- Participation Model Callout --}}
                <div class="mt-8 lg:mt-10 p-5 lg:p-6 bg-surface-card rounded-xl shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4 lg:gap-6">
                    <div class="flex items-center gap-4">
                    <span class="w-10 h-10 rounded-full bg-primary-container text-on-surface flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px]">tune</span>
                    </span>
                        <div>
                            <h4 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Flexible Brand Participation</h4>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Brands can choose how they sell and whether to work with sales partners, based on the options available to them.</p>
                        </div>
                    </div>
                    <div class="shrink-0 flex flex-wrap items-center gap-2 lg:gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded bg-surface-subtle font-label-sm text-label-sm font-semibold text-on-surface">Sell Direct</span>
                        <span class="inline-flex items-center px-3 py-1 rounded bg-surface-subtle font-label-sm text-label-sm font-semibold text-on-surface">Work with Partners</span>
                        <span class="inline-flex items-center px-3 py-1 rounded bg-primary-container text-on-surface font-label-sm text-label-sm font-bold">Both</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== 3. DEEP-DIVE 1: BRAND OWNERS ==================== --}}
        <section id="brand-showcase" class="w-full py-12 md:py-16 lg:py-24 bg-surface-cream">
            <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter">
                <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-12 lg:items-center">

                    {{-- Content: text first on mobile, left on desktop --}}
                    <div class="lg:col-span-6 space-y-6 lg:space-y-8 order-1">

                        <div class="flex flex-col gap-1">
                            <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">For Brand Owners</span>
                            <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl text-on-surface tracking-tight mt-1">
                                Showcase Your Brand. Reach More Customers.
                            </h2>
                            <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant mt-3 leading-relaxed">
                                Give your products a place to be discovered beyond social media and direct messages. KING'S helps you present your brand, manage products, and connect with potential customers and sales partners.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 lg:gap-6">
                            <div class="bg-surface-card p-5 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <span class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center mb-3 lg:mb-4">
                                <span class="material-symbols-outlined text-[22px]">domain</span>
                            </span>
                                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-1">Your Brand Store</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Showcase your brand, products, images, and story in one place.</p>
                            </div>
                            <div class="bg-surface-card p-5 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <span class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center mb-3 lg:mb-4">
                                <span class="material-symbols-outlined text-[22px]">inventory_2</span>
                            </span>
                                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-1">Product Catalog</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Keep product information organised so customers and sales partners can explore your offerings.</p>
                            </div>
                            <div class="bg-surface-card p-5 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <span class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center mb-3 lg:mb-4">
                                <span class="material-symbols-outlined text-[22px]">hub</span>
                            </span>
                                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-1">Sales Partnerships</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Connect with sales partners who can help promote your products to their audiences.</p>
                            </div>
                            <div class="bg-surface-card p-5 lg:p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <span class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center mb-3 lg:mb-4">
                                <span class="material-symbols-outlined text-[22px]">alt_route</span>
                            </span>
                                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-1">Reach More People</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Give customers and sales partners another way to discover and share your products.</p>
                            </div>
                        </div>

                        <div>
                            <a href="{{ auth()->check() ? route('dashboard') : route('signup') }}" class="w-full sm:w-auto inline-flex items-center justify-center font-label-lg text-label-lg bg-on-surface text-surface font-semibold px-6 lg:px-8 py-3.5 lg:py-4 rounded-lg shadow hover:bg-on-surface-variant transition-all">
                                Join KING'S as a Brand
                                <span class="material-symbols-outlined ml-2 text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    {{-- Image: second on mobile, right on desktop --}}
                    <div class="lg:col-span-6 relative mt-8 lg:mt-0 order-2">
                        <div class="relative rounded-2xl overflow-hidden shadow-xl aspect-[4/5] bg-surface-subtle">
                            <img class="w-full h-full object-cover"
                                 alt="Fashion atelier"
                                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuAhgby8RgCaiuEmdW2Ging0n7WWml7OUjuHms81n9WP2CualurvGWb6QUWNO7-csTR8wpaBfSDqKHifre_I0fTOoZSn6S_tDICy00ukMTcn-L6U3mQkL3dexqGlvbUmxYl1t0_7BnpMXWeTsU__p77SuVb_UblOu2_W3C3rIc677K9THjr9HsaT7GXj8iX12ZrJ1EXSMQ9RlgFbkaCH483oQZVcomPaz_SPTZk3oSyp" />
                            <div class="absolute bottom-4 lg:bottom-6 left-4 lg:left-6 right-4 lg:right-6 bg-surface-card/95 backdrop-blur-md rounded-xl p-4 lg:p-5 shadow-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-on-surface">
                                            <span class="material-symbols-outlined text-[18px]">verified</span>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-label-lg text-label-lg font-bold text-on-surface truncate">Sample Brand</p>
                                            <p class="font-label-sm text-[10px] lg:text-label-sm text-text-muted truncate">Brand store preview</p>
                                        </div>
                                    </div>
                                    <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full bg-surface-subtle font-label-sm text-label-sm text-status-success font-semibold gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-status-success"></span> Sample data
                                </span>
                                </div>
                                <div class="grid grid-cols-3 gap-2 pt-2 bg-surface-subtle rounded-lg p-2.5 lg:p-3">
                                    <div>
                                        <span class="font-label-sm text-[9px] lg:text-label-sm text-text-muted uppercase">Products</span>
                                        <p class="font-label-lg text-[13px] lg:text-label-lg font-bold text-on-surface">—</p>
                                    </div>
                                    <div>
                                        <span class="font-label-sm text-[9px] lg:text-label-sm text-text-muted uppercase">Partners</span>
                                        <p class="font-label-lg text-[13px] lg:text-label-lg font-bold text-on-surface">—</p>
                                    </div>
                                    <div>
                                        <span class="font-label-sm text-[9px] lg:text-label-sm text-text-muted uppercase">Sales</span>
                                        <p class="font-label-lg text-[13px] lg:text-label-lg font-bold text-primary">—</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ==================== 4. DEEP-DIVE 2: SALES PARTNERS ==================== --}}
        <section class="w-full py-12 md:py-16 lg:py-24 bg-surface-subtle">
            <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter">
                <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-12 lg:items-center">

                    {{-- Content: first on mobile, left on desktop --}}
                    <div class="lg:col-span-6 space-y-6 lg:space-y-8 order-1 lg:order-1">

                        <div class="flex flex-col gap-1">
                            <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">For Sales Partners</span>
                            <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl text-on-surface tracking-tight mt-1">
                                Build a Commerce Business Without Inventorys.
                            </h2>
                            <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant mt-3 leading-relaxed">
                                Discover products from brands on KING'S and promote the ones that fit your audience. You can help connect customers with products without having to keep stock yourself; arrangements depend on the brand.
                            </p>
                        </div>

                        <div class="space-y-3 lg:space-y-4">
                            <div class="bg-surface-card p-4 lg:p-5 rounded-xl shadow-sm flex items-start gap-3 lg:gap-4">
                                <div class="w-10 h-10 rounded-lg bg-primary-container text-on-surface flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">shelves</span>
                                </div>
                                <div>
                                    <h4 class="font-headline-sm text-[17px] lg:text-headline-sm text-on-surface">No Need to Hold Stock</h4>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Explore available products and share them with potential customers without buying inventory upfront.</p>
                                </div>
                            </div>
                            <div class="bg-surface-card p-4 lg:p-5 rounded-xl shadow-sm flex items-start gap-3 lg:gap-4">
                                <div class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">percent</span>
                                </div>
                                <div>
                                    <h4 class="font-headline-sm text-[17px] lg:text-headline-sm text-on-surface">Know the Terms</h4>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Review the sales arrangement and any applicable commission or margin before you promote a product.</p>
                                </div>
                            </div>
                            <div class="bg-surface-card p-4 lg:p-5 rounded-xl shadow-sm flex items-start gap-3 lg:gap-4">
                                <div class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">verified_user</span>
                                </div>
                                <div>
                                    <h4 class="font-headline-sm text-[17px] lg:text-headline-sm text-on-surface">Discover Local Brands</h4>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Explore products from participating brands and check product details before recommending them.</p>
                                </div>
                            </div>
                            <div class="bg-surface-card p-4 lg:p-5 rounded-xl shadow-sm flex items-start gap-3 lg:gap-4">
                                <div class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">schedule</span>
                                </div>
                                <div>
                                    <h4 class="font-headline-sm text-[17px] lg:text-headline-sm text-on-surface">Build Through Sales</h4>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Use your product knowledge, relationships, and marketing skills to connect products with the right customers. Results depend on your effort and customer demand.</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <a href="{{ auth()->check() ? route('dashboard') : route('signup') }}" class="w-full sm:w-auto inline-flex items-center justify-center font-label-lg text-label-lg bg-primary text-on-primary font-semibold px-6 lg:px-8 py-3.5 lg:py-4 rounded-lg shadow hover:bg-on-tertiary-container transition-all">
                                Join as a Sales Partner
                                <span class="material-symbols-outlined ml-2 text-[18px]">badge</span>
                            </a>
                        </div>
                    </div>

                    {{-- Image: second on mobile, right on desktop --}}
                    <div class="lg:col-span-6 relative mt-8 lg:mt-0 order-2 lg:order-2">
                        <div class="relative rounded-2xl overflow-hidden shadow-xl aspect-[4/5] bg-surface-card">
                            <img class="w-full h-full object-cover"
                                 alt="Entrepreneur at work"
                                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPQ2Bsufqt2TRgMTpO0ZFK88D5qQ5QG4I5qrvhzrOEy3bHfGa4GMlG2DgHZhnEqx1pCIz1kYLx8b2BO2km5f2XvVbjlklrI3H0ZEfn-P1NUoFJnKx7Q146-fy7C0xUG3AGpMLcoZzSAjBp1T3zWm4cjLEjb1BtADHYsaSrWZXbWcqQEK4Eslnp-_nI5i40pJsDYtKd4FYiOAWTsRs5YQ-4kkvFK0ATgN3Rva2FjaSC" />
                            <div class="absolute bottom-4 lg:top-6 lg:right-6 lg:left-auto lg:bottom-auto left-4 right-4 lg:w-80 bg-surface-card/95 backdrop-blur-md rounded-xl p-4 lg:p-5 shadow-xl">
                                <div class="flex items-center justify-between pb-2 mb-2 bg-surface-subtle rounded-lg px-2.5 py-1.5">
                                    <span class="font-label-sm text-[10px] lg:text-label-sm uppercase tracking-wider text-text-muted">Example Earnings</span>
                                    <span class="font-label-sm text-[10px] lg:text-label-sm font-bold text-status-success">Illustrative</span>
                                </div>
                                <p class="font-body-sm text-[11px] lg:text-body-sm text-text-muted">Example sales-partner earnings</p>
                                <p class="font-currency-display text-[20px] lg:text-currency-display text-on-surface mt-1">Example only</p>
                                <div class="mt-3 space-y-1.5">
                                    <div class="flex justify-between text-[11px] font-medium">
                                        <span class="text-text-muted">Sample product</span>
                                        <span class="text-status-success font-bold">—</span>
                                    </div>
                                    <div class="flex justify-between text-[11px] font-medium">
                                        <span class="text-text-muted">Another sample</span>
                                        <span class="text-status-success font-bold">—</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== 5. CALCULATOR (mobile-only in mockup, shown everywhere here) ==================== --}}
        <section class="w-full py-10 md:py-14 lg:py-20 bg-surface-cream">
            <div class="max-w-3xl mx-auto px-margin-mobile lg:px-gutter">
                <div class="p-5 lg:p-8 rounded-2xl bg-surface-card shadow-md flex flex-col gap-4 lg:gap-6">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Interactive Estimator</span>
                            <h3 class="font-headline-sm text-headline-sm lg:font-headline-md lg:text-headline-md text-on-surface">Sales Partner Earnings Estimator</h3>
                        </div>
                        <span class="w-9 h-9 rounded-full bg-surface-subtle flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[20px]">calculate</span>
                    </span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="monthly-orders" class="flex items-center justify-between font-label-md text-label-md text-text-muted">
                            <span>Monthly Orders Facilitated</span>
                            <span class="font-headline-sm text-[16px] text-on-surface font-bold" id="orders-val">40 Orders</span>
                        </label>
                        <input id="monthly-orders" type="range" min="10" max="250" step="5" value="40"
                               class="w-full accent-[#885211] bg-surface-container rounded-lg h-2" />
                        <div class="flex justify-between font-label-sm text-[11px] text-text-tertiary">
                            <span>10 orders</span>
                            <span>100 orders</span>
                            <span>250 orders</span>
                        </div>
                    </div>
                    <div class="p-4 lg:p-5 rounded-xl bg-surface-subtle flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-text-muted uppercase">Example estimate (₦45,000/order × 25% margin)</span>
                            <span class="font-currency-display text-[24px] lg:text-[28px] text-primary font-bold" id="calculated-payout">₦450,000</span>
                        </div>
                        <span class="px-2.5 py-1 rounded bg-surface-card text-on-surface font-label-sm text-label-sm shadow-sm font-semibold whitespace-nowrap">Example only</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== 6. DEEP-DIVE 3: CUSTOMERS ==================== --}}
        <section class="w-full py-12 md:py-16 lg:py-24 bg-surface-subtle">
            <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter">
                <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-12 lg:items-center">

                    {{-- Image: first on mobile, left on desktop --}}
                    <div class="lg:col-span-6 relative order-2 lg:order-1 mt-8 lg:mt-0">
                        <div class="relative rounded-2xl overflow-hidden shadow-xl aspect-[4/5] bg-surface-subtle">
                            <img class="w-full h-full object-cover"
                                 alt="Artisanal luxury flatlay"
                                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2E9UbEdtISNYL-hlcMLajDmyURLjFRufGx_sAYIp-jb4LqnldD5qaBcqpn4Z3-F8dsSjiSnHATOyaASzhUobOLmPD4HYPL1zziiNy6g5rtv1hiAxBAc3odz2W22ki_MIGW6R9WVkXskRy_IQBq9tHTXV5eWQP_QHAa6i7EmENBsERII576RKB6nX2xALH2VJcom5-dF5EVy0zIQ4r7rSjhnerRu9azEMlbIOSbq2D" />
                            <div class="absolute bottom-4 lg:bottom-6 left-4 lg:left-6 right-4 lg:right-6 bg-surface-card/95 backdrop-blur-md rounded-xl p-4 lg:p-5 shadow-lg">
                                <div class="flex items-center gap-3 lg:gap-4">
                                    <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-full bg-status-success/10 text-status-success flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[22px] lg:text-[28px]">shield</span>
                                    </div>
                                    <div>
                                        <h4 class="font-label-lg text-label-lg font-bold text-on-surface">Order Information</h4>
                                        <p class="font-body-sm text-[11px] lg:text-body-sm text-text-muted">Review the available delivery, payment, and order details before completing your purchase.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Content: first on mobile, right on desktop --}}
                    <div class="lg:col-span-6 space-y-6 lg:space-y-8 order-1 lg:order-2">
                        <div class="flex flex-col gap-1">
                            <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">For Customers</span>
                            <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl text-on-surface tracking-tight mt-1">
                                Discover Brands and Products in One Place.
                            </h2>
                            <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant mt-3 leading-relaxed">
                                Explore products from participating brands, compare your options, and discover items that suit your needs.
                            </p>
                        </div>

                        <div class="space-y-5 lg:space-y-6">
                            <div class="flex items-start gap-4">
                                <span class="w-10 h-10 rounded-full bg-primary-container text-on-surface flex items-center justify-center shrink-0 font-bold">1</span>
                                <div>
                                    <h4 class="font-headline-sm text-headline-sm text-on-surface">Explore Different Brands</h4>
                                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Browse products from different brands and discover something that fits your style or needs.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <span class="w-10 h-10 rounded-full bg-primary-container text-on-surface flex items-center justify-center shrink-0 font-bold">2</span>
                                <div>
                                    <h4 class="font-headline-sm text-headline-sm text-on-surface">Product Details</h4>
                                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Review available product descriptions, images, prices, and other details before you buy.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <span class="w-10 h-10 rounded-full bg-primary-container text-on-surface flex items-center justify-center shrink-0 font-bold">3</span>
                                <div>
                                    <h4 class="font-headline-sm text-headline-sm text-on-surface">Offers and Promotions</h4>
                                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Look out for promotions and offers made available by participating brands.</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('brands') }}" class="w-full sm:w-auto inline-flex items-center justify-center font-label-lg text-label-lg bg-primary-container text-on-surface font-semibold px-6 lg:px-8 py-3.5 lg:py-4 rounded-lg shadow hover:bg-tertiary-container transition-all">
                                Explore Brands
                                <span class="material-symbols-outlined ml-2 text-[18px]">storefront</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== 7. COMPLETE TOOLKIT (preserved from old page) ==================== --}}
        <section class="w-full py-12 md:py-16 lg:py-24 bg-surface-cream">
            <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter">
                <div class="text-center max-w-3xl mx-auto mb-8 lg:mb-12">
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">Tools for Everyday Business</span>
                    <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-headline-lg lg:text-headline-lg text-on-surface tracking-tight mt-2">
                        The Tools to Manage and Grow
                    </h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-3">
                        Manage key parts of your business and sales activity from one platform, with features available according to your account and role.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">

                    {{-- Manage Orders --}}
                    <div class="bg-surface-card rounded-xl p-5 lg:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]">inventory</span>
                        </span>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Manage Orders</h3>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Keep track of orders and access relevant customer and order information.</p>
                        <ul class="space-y-1.5 pt-2 border-t border-border-hairline text-text-muted font-body-sm text-[12px]">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> View live orders</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Track fulfillment</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Customer details &amp; history</li>
                        </ul>
                    </div>

                    {{-- Payments and Earnings --}}
                    <div class="bg-surface-card rounded-xl p-5 lg:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]">payments</span>
                        </span>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Payments &amp; Earnings</h3>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Review available payment, sales, and earnings information for your account.</p>
                        <ul class="space-y-1.5 pt-2 border-t border-border-hairline text-text-muted font-body-sm text-[12px]">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Customer payments</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Sales &amp; earnings ledger</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Partner commissions</li>
                        </ul>
                    </div>

                    {{-- Promotions --}}
                    <div class="bg-surface-card rounded-xl p-5 lg:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]">campaign</span>
                        </span>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Promotions</h3>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Use available promotional tools to help customers discover your products.</p>
                        <ul class="space-y-1.5 pt-2 border-t border-border-hairline text-text-muted font-body-sm text-[12px]">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Create discounts</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Schedule sales</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Boost visibility</li>
                        </ul>
                    </div>

                    {{-- Sales Overview --}}
                    <div class="bg-surface-card rounded-xl p-5 lg:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]">insights</span>
                        </span>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Sales Overview</h3>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Review sales information to understand activity across your products.</p>
                        <ul class="space-y-1.5 pt-2 border-t border-border-hairline text-text-muted font-body-sm text-[12px]">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Track sales</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Monitor growth</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Revenue by product</li>
                        </ul>
                    </div>

                    {{-- Community --}}
                    <div class="bg-surface-card rounded-xl p-5 lg:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]">group</span>
                        </span>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Business Connections</h3>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Build connections with brands, customers, and people interested in selling products.</p>
                        <ul class="space-y-1.5 pt-2 border-t border-border-hairline text-text-muted font-body-sm text-[12px]">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Connect with other brands</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Connect with sales partners</li>
                        </ul>
                    </div>

                    {{-- Reviews & Reputation --}}
                    <div class="bg-surface-card rounded-xl p-5 lg:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-lg bg-surface-subtle text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]">star</span>
                        </span>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Customer Reviews</h3>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Use customer feedback and ratings, where available, to help build trust.</p>
                        <ul class="space-y-1.5 pt-2 border-t border-border-hairline text-text-muted font-body-sm text-[12px]">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Customer reviews</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Business ratings</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[14px]">check</span> Build customer trust</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== 8. COMPARISON MATRIX ==================== --}}
        <section class="w-full py-12 md:py-16 lg:py-24 bg-surface-subtle">
            <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter">
                <div class="text-center max-w-3xl mx-auto mb-8 lg:mb-16">
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">Why KING'S</span>
                    <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl text-on-surface tracking-tight mt-2">
                        A More Connected Way to Do Business.
                    </h2>
                    <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant mt-4">
                        KING'S brings brands, sales partners, and customers into one connected platform, creating more ways for products to be discovered, promoted, and purchased.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-8">

                    {{-- Card 1 --}}
                    <div class="bg-surface-card rounded-2xl p-5 lg:p-8 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-4 lg:mb-6">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-text-muted">Product Discovery</span>
                            <span class="material-symbols-outlined text-primary text-[24px] lg:text-[28px]">search_insights</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-2 lg:mb-3">Make Products Easier to Discover</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-4 lg:mb-6 leading-relaxed">
                            KING'S gives participating brands a place to present their products and story, helping customers and sales partners discover what they offer.
                        </p>
                        <div class="space-y-2 pt-3 lg:pt-4 bg-surface-cream -mx-5 lg:-mx-8 -mb-5 lg:-mb-8 p-4 lg:p-6 rounded-b-2xl">
                            <div class="flex items-center gap-2 text-[11px] lg:text-xs text-text-muted">
                                <span class="material-symbols-outlined text-error text-[16px]">close</span> Other channels can be crowded and hard to navigate
                            </div>
                            <div class="flex items-center gap-2 text-[11px] lg:text-xs text-status-success font-semibold">
                                <span class="material-symbols-outlined text-[16px]">check</span> KING'S: Brand and product discovery in one place
                            </div>
                        </div>
                    </div>

                    {{-- Card 2 --}}
                    <div class="bg-surface-card rounded-2xl p-5 lg:p-8 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-4 lg:mb-6">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-text-muted">Sales Partnerships</span>
                            <span class="material-symbols-outlined text-primary text-[24px] lg:text-[28px]">handshake</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-2 lg:mb-3">Brands and Sales Partners Can Work Together</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-4 lg:mb-6 leading-relaxed">
                            KING'S gives brands and sales partners a way to connect. Partners can help promote products under the terms agreed with each brand.
                        </p>
                        <div class="space-y-2 pt-3 lg:pt-4 bg-surface-cream -mx-5 lg:-mx-8 -mb-5 lg:-mb-8 p-4 lg:p-6 rounded-b-2xl">
                            <div class="flex items-center gap-2 text-[11px] lg:text-xs text-text-muted">
                                <span class="material-symbols-outlined text-error text-[16px]">close</span> Traditional selling often relies on the brand finding every customer
                            </div>
                            <div class="flex items-center gap-2 text-[11px] lg:text-xs text-status-success font-semibold">
                                <span class="material-symbols-outlined text-[16px]">check</span> KING'S: More ways to connect with potential buyers
                            </div>
                        </div>
                    </div>

                    {{-- Card 3 --}}
                    <div class="bg-surface-card rounded-2xl p-5 lg:p-8 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-4 lg:mb-6">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-text-muted">Local Commerce</span>
                            <span class="material-symbols-outlined text-primary text-[24px] lg:text-[28px]">account_balance_wallet</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-2 lg:mb-3">Designed with Nigerian Businesses in Mind</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-4 lg:mb-6 leading-relaxed">
                            KING'S is built to help Nigerian brands, sales partners, and customers connect and do business through a locally relevant platform.
                        </p>
                        <div class="space-y-2 pt-3 lg:pt-4 bg-surface-cream -mx-5 lg:-mx-8 -mb-5 lg:-mb-8 p-4 lg:p-6 rounded-b-2xl">
                            <div class="flex items-center gap-2 text-[11px] lg:text-xs text-text-muted">
                                <span class="material-symbols-outlined text-error text-[16px]">close</span> Different platforms come with different requirements
                            </div>
                            <div class="flex items-center gap-2 text-[11px] lg:text-xs text-status-success font-semibold">
                                <span class="material-symbols-outlined text-[16px]">check</span> KING'S: A platform focused on Nigerian commerce
                            </div>
                        </div>
                    </div>

                    {{-- Card 4 --}}
                    <div class="bg-surface-card rounded-2xl p-5 lg:p-8 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-4 lg:mb-6">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-text-muted">Clear Information</span>
                            <span class="material-symbols-outlined text-primary text-[24px] lg:text-[28px]">verified</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-2 lg:mb-3">Make Informed Decisions</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-4 lg:mb-6 leading-relaxed">
                            Product and brand information helps customers explore their options and make informed choices before ordering.
                        </p>
                        <div class="space-y-2 pt-3 lg:pt-4 bg-surface-cream -mx-5 lg:-mx-8 -mb-5 lg:-mb-8 p-4 lg:p-6 rounded-b-2xl">
                            <div class="flex items-center gap-2 text-[11px] lg:text-xs text-text-muted">
                                <span class="material-symbols-outlined text-error text-[16px]">close</span> Online shopping can leave buyers with unanswered questions
                            </div>
                            <div class="flex items-center gap-2 text-[11px] lg:text-xs text-status-success font-semibold">
                                <span class="material-symbols-outlined text-[16px]">check</span> KING'S: Brand and product details in one place
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== 9. TRI-ROUTE CTA ==================== --}}
        <section class="w-full py-14 md:py-20 lg:py-28 bg-surface-cream relative overflow-hidden">
            <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-96 h-96 bg-primary-container/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-margin-mobile lg:px-gutter relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-8 lg:mb-16">
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-primary font-bold">Choose Your Path</span>
                    <h2 class="font-headline-lg-mobile text-headline-lg-mobile lg:font-display-xl lg:text-display-xl text-on-surface tracking-tight mt-2">
                        There's a Place for You on KING'S.
                    </h2>
                    <p class="font-body-md text-body-md lg:font-body-lg lg:text-body-lg text-on-surface-variant mt-3">
                        Whether you own a brand, want to sell products, or simply want to shop, you can get started with KING'S.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-8">

                    {{-- Route 1: Brand Owner --}}
                    <div class="bg-surface-card rounded-2xl p-6 lg:p-8 shadow-md flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div>
                            <div class="w-12 lg:w-14 h-12 lg:h-14 rounded-xl bg-surface-cream text-primary flex items-center justify-center mb-5 lg:mb-6">
                                <span class="material-symbols-outlined text-[26px] lg:text-[30px]">store</span>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">I Own a Brand</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-5 lg:mb-6">
                                Showcase your products, manage your brand store, and explore opportunities to work with sales partners.
                            </p>
                            <ul class="space-y-2.5 text-[13px] lg:text-sm text-on-surface-variant mb-6 lg:mb-8">
                                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">done</span> Your own brand presence</li>
                                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">done</span> Organised product catalog</li>
                                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">done</span> Sales partnership options</li>
                            </ul>
                        </div>
                        <a href="{{ auth()->check() ? route('dashboard') : route('signup') }}" class="w-full inline-flex items-center justify-center font-label-lg text-label-lg bg-on-surface text-surface font-semibold px-6 py-3 lg:py-3.5 rounded-lg shadow hover:bg-on-surface-variant transition-colors">
                            Join as Brand Owner
                        </a>
                    </div>

                    {{-- Route 2: Sales Partner (Featured) --}}
                    <div class="bg-surface-card rounded-2xl p-6 lg:p-8 shadow-md flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative ring-2 ring-primary-container">
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-primary-container text-on-surface font-label-sm text-[11px] lg:text-label-sm px-3 py-1 rounded-full uppercase tracking-wider font-bold whitespace-nowrap">
                            Featured Option
                        </div>
                        <div>
                            <div class="w-12 lg:w-14 h-12 lg:h-14 rounded-xl bg-primary-container text-on-surface flex items-center justify-center mb-5 lg:mb-6">
                                <span class="material-symbols-outlined text-[26px] lg:text-[30px]">payments</span>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">I Want to Sell</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-5 lg:mb-6">
                                Discover products to promote without holding stock. Earnings and terms depend on the arrangement with each brand.
                            </p>
                            <ul class="space-y-2.5 text-[13px] lg:text-sm text-on-surface-variant mb-6 lg:mb-8">
                                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">done</span> Share product links</li>
                                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">done</span> Understand the agreed terms</li>
                                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">done</span> Focus on promoting products</li>
                            </ul>
                        </div>
                        <a href="{{ auth()->check() ? route('dashboard') : route('signup') }}" class="w-full inline-flex items-center justify-center font-label-lg text-label-lg bg-primary-container text-on-surface font-bold px-6 py-3 lg:py-3.5 rounded-lg shadow hover:bg-tertiary-container transition-colors">
                            Join as Sales Partner
                        </a>
                    </div>

                    {{-- Route 3: Customer --}}
                    <div class="bg-surface-card rounded-2xl p-6 lg:p-8 shadow-md flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div>
                            <div class="w-12 lg:w-14 h-12 lg:h-14 rounded-xl bg-surface-cream text-primary flex items-center justify-center mb-5 lg:mb-6">
                                <span class="material-symbols-outlined text-[26px] lg:text-[30px]">shopping_basket</span>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">I Want to Shop</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-5 lg:mb-6">
                                Browse products from participating brands and find items that suit your needs.
                            </p>
                            <ul class="space-y-2.5 text-[13px] lg:text-sm text-on-surface-variant mb-6 lg:mb-8">
                                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">done</span> Explore brand and product information</li>
                                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">done</span> Review order and payment details</li>
                                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-status-success text-[18px]">done</span> Look out for available offers</li>
                            </ul>
                        </div>
                        <a href="{{ route('brands') }}" class="w-full inline-flex items-center justify-center font-label-lg text-label-lg bg-surface-subtle text-on-surface font-semibold px-6 py-3 lg:py-3.5 rounded-lg shadow-sm hover:bg-surface-cream transition-colors">
                            Start Shopping
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    {{-- ==================== Calculator Script ==================== --}}
    @push('scripts')
        <script>
            (function initCalculator() {
                const slider = document.getElementById('monthly-orders');
                const valLabel = document.getElementById('orders-val');
                const payoutLabel = document.getElementById('calculated-payout');

                if (!slider || !valLabel || !payoutLabel) return;

                const avgOrderValue = 45000;
                const avgMarginPct = 0.25;

                function updateCalc() {
                    const orders = parseInt(slider.value, 10);
                    valLabel.textContent = orders + ' Orders';
                    const total = Math.round(orders * avgOrderValue * avgMarginPct);
                    payoutLabel.textContent = '₦' + total.toLocaleString('en-NG');
                }

                slider.addEventListener('input', updateCalc);
                updateCalc();
            })();
        </script>
    @endpush

@endsection
