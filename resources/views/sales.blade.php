@extends('layouts.web')

@section('title')
    Sales
@endsection

@section('content')

    <!-- ==================== HERO HEADER ==================== -->
    <header class="bg-premium-dark text-white pt-14 pb-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff01_1px,transparent_1px),linear-gradient(to_bottom,#ffffff01_1px,transparent_1px)] bg-[size:32px_32px]"></div>
        <div class="absolute top-1/2 left-1/3 w-[400px] h-[400px] bg-brand-primary/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-6">
            <div class="space-y-2">
            <span class="text-brand-primary font-bold text-xs uppercase tracking-widest block">
                Sales
            </span>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight max-w-3xl mx-auto leading-tight">
                    Discover the Best Deals
                </h1>

                <p class="text-stone-400 text-sm max-w-xl mx-auto">
                    Browse ongoing sales, exclusive discounts, and limited-time offers from brands across our platform.
                </p>
            </div>
        </div>
    </header>

    <!-- ==================== LIVE SALES MATRIX ==================== -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 space-y-16">

        <!-- Filter Bar / Quick Counts -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-stone-200 pb-5">
            <div>
                <h2 class="text-xl font-black text-stone-900 tracking-tight">Current Sales & Promotions</h2>
                <p class="text-xs text-stone-400 mt-0.5">
                    Explore the latest discounts and special offers from businesses on our platform.
                </p>
            </div>
{{--            <div class="flex items-center gap-2 bg-stone-100 p-1 rounded-xl border border-stone-200/60 text-xs font-bold text-stone-600">--}}
{{--                <button class="bg-white text-stone-900 px-4 py-1.5 rounded-lg shadow-sm">All Deals</button>--}}
{{--                <button class="hover:text-stone-900 px-4 py-1.5 transition">Clothing</button>--}}
{{--                <button class="hover:text-stone-900 px-4 py-1.5 transition">Lifestyle</button>--}}
{{--            </div>--}}
        </div>

        @if($sales->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($sales as $sale)
                    <div class="brand-sale-card p-6 flex flex-col justify-between space-y-2">
                        <!-- Header Info -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-stone-900 text-brand-primary rounded-xl flex items-center justify-center overflow-hidden shadow-sm">
                                        @if($sale->brand->image)
                                            <img
                                                src="{{ Storage::url($sale->brand->image) }}"
                                                alt="{{ $sale->brand->brand_name }}"
                                                class="w-full h-full object-cover"
                                            >
                                        @else
                                            <span class="font-black text-lg">
                                                {{ strtoupper(substr($sale->brand->brand_name, 0, 1)) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-extrabold text-stone-900 text-base leading-tight">{{$sale->name}}</h3>
                                        <span class="text-[11px] text-stone-400 font-semibold"><i class="fas fa-tags mr-1"></i> {{$sale->brand->brand_name}}</span>
                                    </div>
                                </div>
                                @if($sale->sale_mode == 'generic')
                                    <span class="text-[11px] font-extrabold uppercase text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
                                        @if($sale->discount_type === 'percentage')
                                            {{ number_format($sale->discount_value, 0) }}% OFF
                                        @else
                                            ₦{{ number_format($sale->discount_value, 0) }} OFF
                                        @endif
                                    </span>
                                @else
                                    <span class="text-[11px] font-extrabold uppercase text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
                                        Customized
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-brand-muted leading-relaxed">
                                {{$sale->description}}
                            </p>

                        </div>

                        <!-- Product Preview Row -->
                        @if($sale->starts_at->isFuture())
                            <div class="h-full rounded-2xl border border-[#e9a35d]/30 bg-[#e9a35d]/10 flex flex-col items-center justify-center text-center p-6">
                                <div class="w-14 h-14 rounded-full bg-[#e9a35d]/20 text-[#e9a35d] flex items-center justify-center mb-4">
                                    <i class="fas fa-hourglass-half text-xl"></i>
                                </div>

                                <h3 class="text-[1rem] font-bold text-stone-900">
                                    Sale Starts Soon
                                </h3>

                                <p class="text-sm text-stone-600 mt-2 max-w-xs leading-relaxed">
                                    This sale is scheduled to begin on
                                    <span class="font-semibold text-[#e9a35d]">
                                        {{ $sale->starts_at->format('M d, Y \a\t h:i A') }}
                                    </span>.
                                </p>
                            </div>
                        @else
                            <div class="grid grid-cols-3 gap-3">
                                @foreach($sale->products->take(3) as $product)
                                    <div class="aspect-square bg-stone-100 rounded-xl overflow-hidden border border-stone-200/40 relative group">
                                        @if($product->images->count() > 0)
                                            <img
                                                src="{{ $product->primary_image_url }}"
                                                alt="{{ $product->name }}"
                                                class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
                                            >
                                        @else
                                            <div class="w-full h-full bg-stone-200 flex items-center justify-center">
                                                <span class="text-lg font-bold text-stone-500">
                                                    {{ strtoupper(substr($product->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif

                                        <div class="absolute inset-0 bg-stone-900/70 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                            <span class="text-xs font-bold text-white text-center">
                                                <span class="line-through text-stone-300">
                                                    ₦{{ number_format($product->price, 0) }}
                                                </span>
                                                <br>
                                                <span class="text-[#e9a35d]">
                                                    ₦{{ number_format($product->sales_price, 0) }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($sale->ongoing)
                            @php
                                $totalDuration = $sale->starts_at->diffInSeconds($sale->ends_at);
                                $elapsed = $sale->starts_at->diffInSeconds(now());
                                $percentage = min(100, max(0, ($elapsed / $totalDuration) * 100));
                            @endphp
                            <div class="mt-3 pt-3">
                                <div class="flex justify-between text-xs text-gray-400 mb-1">
                                    <span>Sale progress</span>
                                    <span>{{ round($percentage) }}% complete</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-1.5">
                                    <div class="bg-green-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    Ends {{ $sale->ends_at->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                        <!-- Action Area -->
                        <div class="pt-2 border-t border-stone-100 flex items-center justify-between text-xs font-bold">
                            <span class="text-stone-400"><i class="fas fa-clock mr-1 text-[10px]"></i>Ends: {{ $sale->ends_at->format('M d, Y h:i A') }}</span>
                            <a href="{{route('shop', $sale->brand)}}" class="text-brand-accent hover:text-stone-900 transition flex items-center gap-1.5">
                                Shop This Store <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
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
                    <a href="{{route('brands')}}" class="w-full sm:w-auto bg-white border border-stone-200 hover:bg-stone-50 text-stone-700 text-xs font-bold px-5 py-3 rounded-xl transition">
                        View All Brands
                    </a>
                </div>

            </div>
        @endif
        <div class="mt-12">
            {{ $sales->links() }}
        </div>
    </main>

@endsection


