@extends('layouts.web')

@section('title')
    Sales
@endsection

@section('content')

    <!-- ==================== HERO HEADER ==================== -->
    <header class="bg-premium-dark text-white pt-20 pb-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff01_1px,transparent_1px),linear-gradient(to_bottom,#ffffff01_1px,transparent_1px)] bg-[size:40px_40px]"></div>
        <div class="max-w-5xl mx-auto px-4 text-center space-y-4 relative z-10">
            <span class="text-brand-primary font-bold text-xs uppercase tracking-widest block bg-white/5 w-fit mx-auto px-3 py-1 rounded-full border border-white/10">Limited Time Offers</span>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight leading-tight">
                Discover Brands <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-amber-200">Currently On Sale</span>
            </h1>
            <p class="text-stone-400 text-xs sm:text-sm max-w-lg mx-auto leading-relaxed">
                Browse top collections and active deals direct from verified brand creators.
            </p>
        </div>
    </header>

    <!-- ==================== LIVE SALES MATRIX ==================== -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 space-y-16">

        <!-- Filter Bar / Quick Counts -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-stone-200 pb-5">
            <div>
                <h2 class="text-xl font-black text-stone-900 tracking-tight">Active Store Offers</h2>
                <p class="text-xs text-stone-400 mt-0.5">Showing live discount campaigns run by real business owners.</p>
            </div>
            <div class="flex items-center gap-2 bg-stone-100 p-1 rounded-xl border border-stone-200/60 text-xs font-bold text-stone-600">
                <button class="bg-white text-stone-900 px-4 py-1.5 rounded-lg shadow-sm">All Deals</button>
                <button class="hover:text-stone-900 px-4 py-1.5 transition">Clothing</button>
                <button class="hover:text-stone-900 px-4 py-1.5 transition">Lifestyle</button>
            </div>
        </div>

        <!-- Brands Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- BRAND CARD 1 -->
            <div class="brand-sale-card p-6 flex flex-col justify-between space-y-6">
                <!-- Header Info -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-stone-900 text-brand-primary rounded-xl flex items-center justify-center font-black text-lg shadow-sm">
                                A
                            </div>
                            <div>
                                <h3 class="font-extrabold text-stone-900 text-base leading-tight">Aura Studios</h3>
                                <span class="text-[11px] text-stone-400 font-semibold"><i class="fas fa-tags mr-1"></i> Premium Minimalist Apparel</span>
                            </div>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
              30% OFF
            </span>
                    </div>
                    <p class="text-xs text-brand-muted leading-relaxed">
                        Handcrafted luxury essentials designed for everyday comfort. Complete lookbook lines marked down this week.
                    </p>
                </div>

                <!-- Product Preview Row -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="aspect-square bg-stone-100 rounded-xl relative overflow-hidden group border border-stone-200/40">
                        <div class="absolute inset-0 bg-stone-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                            <span class="text-[9px] text-white font-bold">$42 <span class="line-through text-stone-300">$60</span></span>
                        </div>
                        <div class="w-full h-full bg-stone-200 flex items-center justify-center text-stone-400 text-xs"><i class="fas fa-shirt"></i></div>
                    </div>
                    <div class="aspect-square bg-stone-100 rounded-xl relative overflow-hidden group border border-stone-200/40">
                        <div class="absolute inset-0 bg-stone-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                            <span class="text-[9px] text-white font-bold">$70 <span class="line-through text-stone-300">$100</span></span>
                        </div>
                        <div class="w-full h-full bg-stone-200 flex items-center justify-center text-stone-400 text-xs"><i class="fas fa-vest"></i></div>
                    </div>
                    <div class="aspect-square bg-stone-100 rounded-xl relative overflow-hidden group border border-stone-200/40">
                        <div class="absolute inset-0 bg-stone-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                            <span class="text-[9px] text-white font-bold">$28 <span class="line-through text-stone-300">$40</span></span>
                        </div>
                        <div class="w-full h-full bg-stone-200 flex items-center justify-center text-stone-400 text-xs"><i class="fas fa-hat-cowboy"></i></div>
                    </div>
                </div>

                <!-- Action Area -->
                <div class="pt-2 border-t border-stone-100 flex items-center justify-between text-xs font-bold">
                    <span class="text-stone-400"><i class="fas fa-clock mr-1 text-[10px]"></i> Ends in 2 days</span>
                    <a href="#" class="text-brand-accent hover:text-stone-900 transition flex items-center gap-1.5">
                        Shop This Store <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- BRAND CARD 2 -->
            <div class="brand-sale-card p-6 flex flex-col justify-between space-y-6">
                <!-- Header Info -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-stone-100 text-stone-800 rounded-xl flex items-center justify-center font-black text-lg shadow-sm border border-stone-200/50">
                                O
                            </div>
                            <div>
                                <h3 class="font-extrabold text-stone-900 text-base leading-tight">Onyx Goods</h3>
                                <span class="text-[11px] text-stone-400 font-semibold"><i class="fas fa-tags mr-1"></i> Leather Accessories</span>
                            </div>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
              45% OFF
            </span>
                    </div>
                    <p class="text-xs text-brand-muted leading-relaxed">
                        Genuine private-label goods and items. Bulk catalog lines available for immediate dropship cloning.
                    </p>
                </div>

                <!-- Product Preview Row -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="aspect-square bg-stone-100 rounded-xl relative overflow-hidden group border border-stone-200/40">
                        <div class="absolute inset-0 bg-stone-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                            <span class="text-[9px] text-white font-bold">$55 <span class="line-through text-stone-300">$100</span></span>
                        </div>
                        <div class="w-full h-full bg-stone-200 flex items-center justify-center text-stone-400 text-xs"><i class="fas fa-wallet"></i></div>
                    </div>
                    <div class="aspect-square bg-stone-100 rounded-xl relative overflow-hidden group border border-stone-200/40">
                        <div class="absolute inset-0 bg-stone-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                            <span class="text-[9px] text-white font-bold">$110 <span class="line-through text-stone-300">$200</span></span>
                        </div>
                        <div class="w-full h-full bg-stone-200 flex items-center justify-center text-stone-400 text-xs"><i class="fas fa-briefcase"></i></div>
                    </div>
                    <div class="aspect-square bg-stone-100 rounded-xl relative overflow-hidden group border border-stone-200/40">
                        <div class="absolute inset-0 bg-stone-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                            <span class="text-[9px] text-white font-bold">$33 <span class="line-through text-stone-300">$60</span></span>
                        </div>
                        <div class="w-full h-full bg-stone-200 flex items-center justify-center text-stone-400 text-xs"><i class="fas fa-belt"></i></div>
                    </div>
                </div>

                <!-- Action Area -->
                <div class="pt-2 border-t border-stone-100 flex items-center justify-between text-xs font-bold">
                    <span class="text-stone-400"><i class="fas fa-clock mr-1 text-[10px]"></i> Ends in 5 days</span>
                    <a href="#" class="text-brand-accent hover:text-stone-900 transition flex items-center gap-1.5">
                        Shop This Store <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- BRAND CARD 3 -->
            <div class="brand-sale-card p-6 flex flex-col justify-between space-y-6">
                <!-- Header Info -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-amber-500 text-stone-900 rounded-xl flex items-center justify-center font-black text-lg shadow-sm">
                                V
                            </div>
                            <div>
                                <h3 class="font-extrabold text-stone-900 text-base leading-tight">Velvet & Co.</h3>
                                <span class="text-[11px] text-stone-400 font-semibold"><i class="fas fa-tags mr-1"></i> Luxury Home Decor</span>
                            </div>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
              25% OFF
            </span>
                    </div>
                    <p class="text-xs text-brand-muted leading-relaxed">
                        Premium home aesthetics and minimal styling pieces. High profit margins for approved dropship partners.
                    </p>
                </div>

                <!-- Product Preview Row -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="aspect-square bg-stone-100 rounded-xl relative overflow-hidden group border border-stone-200/40">
                        <div class="absolute inset-0 bg-stone-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                            <span class="text-[9px] text-white font-bold">$75 <span class="line-through text-stone-300">$100</span></span>
                        </div>
                        <div class="w-full h-full bg-stone-200 flex items-center justify-center text-stone-400 text-xs"><i class="fas fa-rug"></i></div>
                    </div>
                    <div class="aspect-square bg-stone-100 rounded-xl relative overflow-hidden group border border-stone-200/40">
                        <div class="absolute inset-0 bg-stone-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                            <span class="text-[9px] text-white font-bold">$150 <span class="line-through text-stone-300">$200</span></span>
                        </div>
                        <div class="w-full h-full bg-stone-200 flex items-center justify-center text-stone-400 text-xs"><i class="fas fa-chair"></i></div>
                    </div>
                    <div class="aspect-square bg-stone-100 rounded-xl relative overflow-hidden group border border-stone-200/40">
                        <div class="absolute inset-0 bg-stone-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                            <span class="text-[9px] text-white font-bold">$45 <span class="line-through text-stone-300">$60</span></span>
                        </div>
                        <div class="w-full h-full bg-stone-200 flex items-center justify-center text-stone-400 text-xs"><i class="fas fa-lightbulb"></i></div>
                    </div>
                </div>

                <!-- Action Area -->
                <div class="pt-2 border-t border-stone-100 flex items-center justify-between text-xs font-bold">
                    <span class="text-stone-400"><i class="fas fa-clock mr-1 text-[10px]"></i> Ends in 12 hours</span>
                    <a href="#" class="text-brand-accent hover:text-stone-900 transition flex items-center gap-1.5">
                        Shop This Store <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- ==================== BEAUTIFUL EMPTY STATE ==================== -->
        <div class="max-w-md mx-auto text-center py-16 px-4 space-y-6">

            <!-- Subtle Icon Stack -->
            <div class="relative w-20 h-20 mx-auto flex items-center justify-center">
                <!-- Light Decorative Background Glow Layer -->
                <div class="absolute inset-0 bg-amber-500/5 rounded-full blur-xl"></div>

                <!-- Central Icon Design -->
                <div class="relative w-16 h-16 bg-white border border-stone-200/80 rounded-2xl flex items-center justify-center text-stone-400 shadow-sm">
                    <i class="fas fa-store-slash text-xl text-stone-300"></i>
                    <!-- Tiny Accent Dot -->
                    <span class="absolute top-2 right-2 w-2 h-2 bg-brand-primary rounded-full animate-pulse"></span>
                </div>
            </div>

            <!-- Descriptive Text Elements -->
            <div class="space-y-2">
                <h3 class="text-lg font-black text-stone-900 tracking-tight">No Active Sales Found</h3>
                <p class="text-xs text-brand-muted leading-relaxed max-w-xs mx-auto">
                    We couldn't find any brands running price discounts matching your choice right now.
                </p>
            </div>

            <!-- Clean Action Buttons -->
            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                <button onclick="window.location.reload();" class="w-full sm:w-auto bg-brand-dark hover:bg-stone-800 text-white text-xs font-bold px-5 py-3 rounded-xl transition shadow-sm">
                    Clear All Filters
                </button>
                <a href="#" class="w-full sm:w-auto bg-white border border-stone-200 hover:bg-stone-50 text-stone-700 text-xs font-bold px-5 py-3 rounded-xl transition">
                    View All Brands
                </a>
            </div>

        </div>
    </main>

@endsection


