@extends('layouts.web')

@section('title')
Home
@endsection

@section('content')

    <section class="relative overflow-hidden bg-premium-dark text-white pt-12 pb-20 md:pt-24 md:pb-32">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff01_1px,transparent_1px),linear-gradient(to_bottom,#ffffff01_1px,transparent_1px)] bg-[size:32px_32px]"></div>
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-brand-primary/5 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-12 gap-12 items-center">

                <!-- Left Content Block -->
                <div class="lg:col-span-6 space-y-6 text-center lg:text-left">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.15] lg:leading-[1.1] tracking-tight">
                        Build Your Brand. <br>Sell More. <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary via-[#f3c293] to-amber-200">Scale Through Dropshippers.</span>
                    </h1>
                    <p class="text-stone-300 text-base md:text-lg lg:text-xl font-normal max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Create your online store, showcase your products, grow a community of customers, and let dropshippers sell for you.
                    </p>
                    <div class="flex sm:flex-row justify-center lg:justify-start gap-4 pt-2">
                        <a href="#" class="text-[.8em] sm:text-[1em] btn-primary px-8 py-3 text-center flex items-center justify-center gap-3">
                            Start Selling Free
                        </a>
                        <a href="#" class="text-[.8em] sm:text-[1em] bg-white/5 hover:bg-white/10 border border-white/10 px-8 py-3 rounded-lg font-semibold text-center transition">
                            Explore Brands
                        </a>
                    </div>
                </div>

                <!-- Right Content Block: Ecosystem Grid Illustration -->
                <div class="lg:col-span-6">
                    <div class="p-6 md:p-8 bg-white/5 rounded-3xl border border-white/5 relative shadow-2xl">
                        <div class="absolute inset-0 items-center justify-center opacity-10 pointer-events-none hidden sm:flex">
                            <i class="fas fa-circle-nodes text-white text-[200px]"></i>
                        </div>

                        <div class="grid grid-cols-2 gap-4 relative z-10">
                            <!-- Node 1: Brand Owner -->
                            <div class="p-5 bg-white/5 backdrop-blur-md rounded-2xl border border-white/5 text-center sm:text-left">
                                <div class="w-10 h-10 bg-brand-primary/20 text-brand-primary rounded-xl flex items-center justify-center text-lg mb-3 mx-auto sm:mx-0"><i class="fas fa-user-tie"></i></div>
                                <h4 class="font-bold text-white text-sm sm:text-base">1. Brand Owner</h4>
                                <p class="text-xs text-stone-400 mt-1">Supplies & Hosts Products</p>
                            </div>
                            <!-- Node 2: Store Hub -->
                            <div class="p-5 bg-white/5 backdrop-blur-md rounded-2xl border border-white/5 text-center sm:text-left">
                                <div class="w-10 h-10 bg-stone-500/20 text-stone-300 rounded-xl flex items-center justify-center text-lg mb-3 mx-auto sm:mx-0"><i class="fas fa-store"></i></div>
                                <h4 class="font-bold text-white text-sm sm:text-base">2. Shared Store</h4>
                                <p class="text-xs text-stone-400 mt-1">Ecom Engine Layer</p>
                            </div>
                            <!-- Node 3: Dropshippers -->
                            <div class="p-5 bg-white/5 backdrop-blur-md rounded-2xl border border-white/5 text-center sm:text-left">
                                <div class="w-10 h-10 bg-brand-secondary/20 text-brand-secondary rounded-xl flex items-center justify-center text-lg mb-3 mx-auto sm:mx-0"><i class="fas fa-people-arrows"></i></div>
                                <h4 class="font-bold text-white text-sm sm:text-base">3. Dropshippers</h4>
                                <p class="text-xs text-stone-400 mt-1">Multiplies Global Reach</p>
                            </div>
                            <!-- Node 4: Customers -->
                            <div class="p-5 bg-white/5 backdrop-blur-md rounded-2xl border border-white/5 text-center sm:text-left">
                                <div class="w-10 h-10 bg-amber-500/20 text-brand-primary rounded-xl flex items-center justify-center text-lg mb-3 mx-auto sm:mx-0"><i class="fas fa-users text-sm"></i></div>
                                <h4 class="font-bold text-white text-sm sm:text-base">4. Happy Customers</h4>
                                <p class="text-xs text-stone-400 mt-1">Buys Directly Securely</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==================== 2. SOCIAL PROOF SECTION ==================== -->
    <section class="py-10 bg-brand-dark border-y border-white/5 relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-8 gap-x-4 text-center divide-x-0 sm:divide-x divide-stone-800">
                <div>
                    <div class="text-2xl sm:text-3xl md:text-4xl font-black text-white">5,200+</div>
                    <div class="text-xs sm:text-sm text-stone-400 font-medium mt-1">Total Verified Brands</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl md:text-4xl font-black text-brand-primary">120,000+</div>
                    <div class="text-xs sm:text-sm text-stone-400 font-medium mt-1">Active Products</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl md:text-4xl font-black text-white">38,000+</div>
                    <div class="text-xs sm:text-sm text-stone-400 font-medium mt-1">Completed Orders</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl md:text-4xl font-black text-brand-secondary">2,400+</div>
                    <div class="text-xs sm:text-sm text-stone-400 font-medium mt-1">Global Dropshippers</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== 3. HOW IT WORKS SECTION ==================== -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-14">
                <span class="text-brand-primary font-bold text-xs uppercase tracking-widest block mb-2">Ecosystem Guide</span>
                <h2 class="text-2xl md:text-4xl font-black text-stone-900 tracking-tight">Three Pillars. Seamless Workflow.</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card A: Brand Owners -->
                <div class="card-interactive p-8 border-t-4 border-t-brand-primary shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-amber-50 text-brand-primary rounded-xl flex items-center justify-center text-xl mb-6"><i class="fas fa-warehouse"></i></div>
                        <h3 class="text-xl font-bold text-stone-900 mb-4">For Brand Owners</h3>
                        <ul class="space-y-3 text-stone-600 text-sm">
                            <li class="flex items-center gap-3"><i class="fas fa-circle-check text-brand-primary text-xs"></i> Create your store easily</li>
                            <li class="flex items-center gap-3"><i class="fas fa-circle-check text-brand-primary text-xs"></i> Upload unlimited products</li>
                            <li class="flex items-center gap-3"><i class="fas fa-circle-check text-brand-primary text-xs"></i> Receive automated orders</li>
                        </ul>
                    </div>
                </div>

                <!-- Card B: Customers -->
                <div class="card-interactive p-8 border-t-4 border-t-brand-secondary shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-stone-100 text-brand-secondary rounded-xl flex items-center justify-center text-xl mb-6"><i class="fas fa-bag-shopping"></i></div>
                        <h3 class="text-xl font-bold text-stone-900 mb-4">For Customers</h3>
                        <ul class="space-y-3 text-stone-600 text-sm">
                            <li class="flex items-center gap-3"><i class="fas fa-circle-check text-brand-secondary text-xs"></i> Discover premium niche brands</li>
                            <li class="flex items-center gap-3"><i class="fas fa-circle-check text-brand-secondary text-xs"></i> Securely checkout products</li>
                            <li class="flex items-center gap-3"><i class="fas fa-circle-check text-brand-secondary text-xs"></i> Leave real authenticated reviews</li>
                        </ul>
                    </div>
                </div>

                <!-- Card C: Dropshippers -->
                <div class="card-interactive p-8 border-t-4 border-t-stone-900 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-stone-900 text-brand-primary rounded-xl flex items-center justify-center text-xl mb-6"><i class="fas fa-share-nodes"></i></div>
                        <h3 class="text-xl font-bold text-stone-900 mb-4">For Dropshippers</h3>
                        <ul class="space-y-3 text-stone-600 text-sm">
                            <li class="flex items-center gap-3"><i class="fas fa-circle-check text-stone-900 text-xs"></i> Clone verified stores in 1-click</li>
                            <li class="flex items-center gap-3"><i class="fas fa-circle-check text-stone-900 text-xs"></i> Promote premium trend items</li>
                            <li class="flex items-center gap-3"><i class="fas fa-circle-check text-stone-900 text-xs"></i> Earn clean split commissions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== 4. FEATURED BRANDS SECTION ==================== -->
    <section class="py-16 bg-[#F5F2EC] border-t border-stone-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-10">
                <div>
                    <span class="text-brand-accent font-bold text-xs uppercase tracking-widest block mb-1">Top Tier Catalogues</span>
                    <h2 class="text-2xl md:text-3xl font-black text-stone-900 tracking-tight">Featured Brand Hubs</h2>
                </div>
                <a href="{{route('brands')}}" class="text-brand-accent font-bold text-sm hover:underline flex items-center gap-1.5 self-end sm:self-auto">
                    View All Verified Brands <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            @if($brands->count() > 0)
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($brands as $brand)
                        <div class="group relative flex flex-col justify-between bg-white border border-stone-200/60 rounded-2xl overflow-hidden hover:shadow-xl hover:border-amber-200/50 transition-all duration-300">

                            <!-- OPTIONAL: Top accent bar/gradient for visual weight -->
                            <div class="h-2"></div>

                            <div class="p-6">
                                <!-- Category Tag (If applicable) -->
                                <div class="mb-4">
                                     <span class="px-2.5 py-0.5 rounded-full bg-stone-100 text-[10px] font-bold uppercase tracking-wider text-stone-500">
                                        {{ $brand->category ?? 'General' }}
                                     </span>
                                </div>

                                <div class="flex items-center gap-4 mb-5">
                                    @if($brand->image)
                                        <img src="{{ Storage::url($brand->image) }}" alt="{{ $brand->brand_name }}" class="h-14 w-14 rounded-xl object-cover shadow-sm">
                                    @else
                                        <div class="h-14 w-14 rounded-xl flex items-center justify-center bg-stone-100 text-stone-500 text-xl font-bold">
                                            {{ substr($brand->brand_name, 0, 1) }}
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <h3 class="font-bold text-stone-900 text-base leading-tight truncate">{{$brand->brand_name}}</h3>
                                        <p class="text-[11px] text-stone-400 mt-0.5 uppercase tracking-wide font-medium">Verified Brand</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 text-xs font-medium text-stone-500 py-3 border-y border-stone-100">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-star text-amber-400"></i>
                                        <span class="text-stone-800">{{$brand->ratings()->avg('rating') > 0 ? number_format($brand->ratings()->avg('rating'), 1) : '0.0'}}</span>
                                    </div>
                                    <div class="w-px h-3 bg-stone-200"></div>
                                    <div><span class="text-stone-800">{{$brand->products->count()}}</span> Product{{$brand->products->count() == 1 ? '' : 's'}} </div>
                                </div>
                            </div>

                            <div class="p-6 pt-0">
                                <a href="{{route('shop', $brand)}}" class="block w-full text-center bg-stone-900 text-white font-semibold text-xs py-3 rounded-xl hover:bg-amber-600 transition-colors">
                                    Visit Store
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
                        <h3 class="text-lg font-black text-stone-900 tracking-tight">
                            We're Growing Our Brand Network
                        </h3>
                        <p class="text-xs text-brand-muted leading-relaxed max-w-xs mx-auto">
                            No active brands are available right now. As new businesses join and publish their stores, they'll appear here for you to discover and shop from.
                        </p>
                    </div>

                    <!-- Clean Action Buttons -->
                    <div class="pt-2 flex flex-row items-center justify-center gap-3">
                        <a href="{{route('brands')}}" class="w-full sm:w-auto bg-brand-dark hover:bg-stone-800 text-white text-xs font-bold px-5 py-3 rounded-xl transition shadow-sm">
                            View Brands
                        </a>
                    </div>

                </div>
            @endif
        </div>
    </section>

    <!-- ==================== 5. BROWSE CATEGORIES SECTION ==================== -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-12">
                <h2 class="text-2xl md:text-3xl font-black text-stone-900 tracking-tight">
                    Browse Marketplace Categories
                </h2>
                <p class="text-sm text-stone-500 mt-2">
                    Discover brands, products, and opportunities across multiple business categories.
                </p>
            </div>

            @if($categories->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-4">
                @foreach($categories as $category)
                    <a href="{{route('home')}}" class="card-interactive p-5 text-center cursor-pointer flex flex-col items-center justify-center gap-3 group">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-brand-primary flex items-center justify-center transition duration-300 group-hover:scale-110">
                            <i class="{{$category->icon}} text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-stone-800">{{$category->name}}</span>
                    </a>
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
                        <h3 class="text-lg font-black text-stone-900 tracking-tight">
                            No Categories Found.
                        </h3>
                        <p class="text-xs text-brand-muted leading-relaxed max-w-xs mx-auto">
                            Please check back later.
                        </p>
                    </div>

                    <!-- Clean Action Buttons -->
                    <div class="pt-2 flex flex-row items-center justify-center gap-3">
                        <a href="{{route('brands')}}" class="w-full sm:w-auto bg-brand-dark hover:bg-stone-800 text-white text-xs font-bold px-5 py-3 rounded-xl transition shadow-sm">
                            View Brands
                        </a>
                    </div>

                </div>
            @endif

        </div>
    </section>

    <!-- ==================== 6. WHY SELL WITH US SECTION ==================== -->
    <section class="py-16 md:py-24 bg-brand-canvas border-y border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-14">
                <span class="text-brand-secondary font-bold text-xs uppercase tracking-widest block mb-2">Why Choose Us</span>
                <h2 class="text-2xl md:text-3xl font-black text-stone-900 tracking-tight">Everything You Need in One Platform</h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Repeating Item Structure -->
                @php
                    $features = [
                        [
                            'icon' => 'shopping-bag',
                            'title' => 'Online Store',
                            'desc' => 'Create a beautiful online store and start selling in minutes.'
                        ],
                        [
                            'icon' => 'share',
                            'title' => 'Dropshipping',
                            'desc' => 'Add products from trusted suppliers and fulfill orders automatically.'
                        ],
                        [
                            'icon' => 'inbox',
                            'title' => 'Customer Reviews',
                            'desc' => 'Collect and display reviews to build trust with new customers.'
                        ],
                        [
                            'icon' => 'tag',
                            'title' => 'Promotions',
                            'desc' => 'Run discounts, coupons, and special offers to increase sales.'
                        ],
                        [
                            'icon' => 'chart-pie',
                            'title' => 'Analytics',
                            'desc' => 'Track sales, orders, and customer activity from one dashboard.'
                        ],
                        [
                            'icon' => 'users',
                            'title' => 'Customer Management',
                            'desc' => 'Manage customers, orders, and communication with ease.'
                        ],
                    ];
                @endphp

                @foreach($features as $feature)
                    <div class="bg-white p-6 rounded-2xl border border-stone-200/60 shadow-sm flex gap-4">
                        <!-- Uniform Icon Container -->
                        <div class="w-10 h-10 bg-amber-50 text-brand-primary rounded-xl flex items-center justify-center shrink-0">
                            <flux:icon name="{{ $feature['icon'] }}" class="w-5 h-5" />
                        </div>
                        <div>
                            <h4 class="font-bold text-stone-900 mb-1">{{ $feature['title'] }}</h4>
                            <p class="text-xs text-stone-500 leading-relaxed">{{ $feature['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==================== 7. TOP PRODUCTS SECTION ==================== -->
    <section class="py-16 md:py-24 bg-brand-dark text-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-12">
                <span class="text-brand-primary font-bold text-xs uppercase tracking-widest block mb-1">
                    Best Sellers
                </span>
                <h2 class="text-2xl md:text-3xl font-black tracking-tight">
                    Top Selling Products
                </h2>

                <p class="text-sm text-stone-400 mt-2">
                    Discover products customers are buying the most right now.
                </p>
            </div>


            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Product Card Structure (Dark Variant) -->
                <div class="card-interactive-dark flex flex-col justify-between overflow-hidden group">
                    <div class="relative overflow-hidden aspect-video bg-stone-800">
                        <div class="absolute inset-0 flex items-center justify-center text-stone-600"><i class="far fa-image text-3xl"></i></div>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-start gap-2">
                            <h3 class="font-bold text-white text-sm line-clamp-1 group-hover:text-brand-primary transition">Minimalist Leather Chronograph</h3>
                            <span class="text-brand-primary font-extrabold text-base">$89</span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-stone-400">
                            <span>By VoltForge</span>
                            <span class="text-brand-primary"><i class="fas fa-star mr-1"></i>4.9</span>
                        </div>
                        <button class="w-full bg-white/5 hover:bg-white/10 text-white font-semibold text-xs py-2.5 rounded-xl border border-white/10 transition">Push To Your Store</button>
                    </div>
                </div>

                <div class="card-interactive-dark flex flex-col justify-between overflow-hidden group">
                    <div class="relative overflow-hidden aspect-video bg-stone-800">
                        <div class="absolute inset-0 flex items-center justify-center text-stone-600"><i class="far fa-image text-3xl"></i></div>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-start gap-2">
                            <h3 class="font-bold text-white text-sm line-clamp-1 group-hover:text-brand-primary transition">Heavyweight Organic Hoodie</h3>
                            <span class="text-brand-primary font-extrabold text-base">$65</span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-stone-400">
                            <span>By Aura Wear</span>
                            <span class="text-brand-primary"><i class="fas fa-star mr-1"></i>5.0</span>
                        </div>
                        <button class="w-full bg-white/5 hover:bg-white/10 text-white font-semibold text-xs py-2.5 rounded-xl border border-white/10 transition">Push To Your Store</button>
                    </div>
                </div>

                <div class="card-interactive-dark flex flex-col justify-between overflow-hidden group">
                    <div class="relative overflow-hidden aspect-video bg-stone-800">
                        <div class="absolute inset-0 flex items-center justify-center text-stone-600"><i class="far fa-image text-3xl"></i></div>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-start gap-2">
                            <h3 class="font-bold text-white text-sm line-clamp-1 group-hover:text-brand-primary transition">Sonic-Blast ANC Headset</h3>
                            <span class="text-brand-primary font-extrabold text-base">$120</span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-stone-400">
                            <span>By VoltForge</span>
                            <span class="text-brand-primary"><i class="fas fa-star mr-1"></i>4.7</span>
                        </div>
                        <button class="w-full bg-white/5 hover:bg-white/10 text-white font-semibold text-xs py-2.5 rounded-xl border border-white/10 transition">Push To Your Store</button>
                    </div>
                </div>

                <div class="card-interactive-dark flex flex-col justify-between overflow-hidden group">
                    <div class="relative overflow-hidden aspect-video bg-stone-800">
                        <div class="absolute inset-0 flex items-center justify-center text-stone-600"><i class="far fa-image text-3xl"></i></div>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-start gap-2">
                            <h3 class="font-bold text-white text-sm line-clamp-1 group-hover:text-brand-primary transition">Matte Thermal Mug Array</h3>
                            <span class="text-brand-primary font-extrabold text-base">$28</span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-stone-400">
                            <span>By EcoLife Labs</span>
                            <span class="text-brand-primary"><i class="fas fa-star mr-1"></i>4.8</span>
                        </div>
                        <button class="w-full bg-white/5 hover:bg-white/10 text-white font-semibold text-xs py-2.5 rounded-xl border border-white/10 transition">Push To Your Store</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== 8. SUCCESS STORIES SECTION ==================== -->
    <section class="py-16 md:py-24 bg-white overflow-hidden relative w-full">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-px h-12 bg-gradient-to-b from-stone-200 to-transparent"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4 mb-10">
            <span class="text-brand-accent font-bold text-xs uppercase tracking-widest block">Social Validation</span>
            <h2 class="text-2xl md:text-3xl font-black text-stone-900 tracking-tight">Verified Growth Across the Network</h2>
        </div>

        <!-- Swiper Container Framework with explicit width rules -->
        <div class="max-w-4xl mx-auto px-4 sm:px-12 relative w-full overflow-hidden">
            <div class="swiper testimonialSwiper pb-14 w-full">
                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide w-full">
                        <div class="space-y-6 max-w-2xl mx-auto text-center px-4">
                            <div class="text-brand-primary text-xl flex justify-center gap-1">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <blockquote class="text-lg sm:text-2xl font-medium text-stone-800 italic leading-relaxed">
                                "We increased sales by 40% after allowing dropshippers to sell our products. The single ledger split-settlement system completely streamlined our logistics management operational stress."
                            </blockquote>
                            <div class="pt-2">
                                <div class="font-extrabold text-stone-950 text-base">Sarah Jenkins</div>
                                <div class="text-xs text-brand-muted font-medium mt-0.5">Founder & CEO, Aura Wear Premium</div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide w-full">
                        <div class="space-y-6 max-w-2xl mx-auto text-center px-4">
                            <div class="text-brand-primary text-xl flex justify-center gap-1">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <blockquote class="text-lg sm:text-2xl font-medium text-stone-800 italic leading-relaxed">
                                "Cloning pre-vetted brand hubs in a single click saved me months of negotiation. I processed over $45k in volume this month alone without holding a single piece of physical inventory."
                            </blockquote>
                            <div class="pt-2">
                                <div class="font-extrabold text-stone-950 text-base">Marcus Vance</div>
                                <div class="text-xs text-brand-muted font-medium mt-0.5">Independent Store Architect, ScaleOps Media</div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide w-full">
                        <div class="space-y-6 max-w-2xl mx-auto text-center px-4">
                            <div class="text-brand-primary text-xl flex justify-center gap-1">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <blockquote class="text-lg sm:text-2xl font-medium text-stone-800 italic leading-relaxed">
                                "The transparency layer is exactly what our enterprise division was waiting for. Automated routing rules handle distributed payments elegantly, giving us massive security at scale."
                            </blockquote>
                            <div class="pt-2">
                                <div class="font-extrabold text-stone-950 text-base">David Kovic</div>
                                <div class="text-xs text-brand-muted font-medium mt-0.5">Director of Logistics, VoltForge Global</div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Custom Brand-Tailored Navigation Dot Matrix -->
                <div class="swiper-pagination"></div>
            </div>

            <!-- Left & Right Arrow Triggers -->
            <button class="swiper-button-prev-custom absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-stone-50 hover:bg-amber-50 border border-stone-200 text-stone-600 hover:text-brand-accent flex items-center justify-center transition shadow-sm z-20 hidden sm:flex" aria-label="Previous Slide">
                <i class="fas fa-chevron-left text-xs"></i>
            </button>
            <button class="swiper-button-next-custom absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-stone-50 hover:bg-amber-50 border border-stone-200 text-stone-600 hover:text-brand-accent flex items-center justify-center transition shadow-sm z-20 hidden sm:flex" aria-label="Next Slide">
                <i class="fas fa-chevron-right text-xs"></i>
            </button>
        </div>

        <style>
            .testimonialSwiper .swiper-pagination-bullet {
                background: #8C7A6B !important;
                opacity: 0.2;
                width: 8px;
                height: 8px;
                transition: all 0.3s ease;
            }
            .testimonialSwiper .swiper-pagination-bullet-active {
                background: #e9a35d !important;
                opacity: 1 !important;
                width: 24px;
                border-radius: 4px;
            }
        </style>
    </section>

    <!-- ==================== 9. BECOME A DROPSHIPPER SECTION ==================== -->
    <section class="py-16 md:py-24 bg-brand-canvas border-t border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-brand-dark via-[#2D251E] to-brand-dark rounded-3xl p-8 md:p-12 text-white border border-stone-800 shadow-xl relative overflow-hidden">
                <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-brand-primary/5 rounded-full blur-[80px] pointer-events-none"></div>

                <div class="grid lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-5 space-y-4 text-center lg:text-left">
                        <span class="bg-brand-primary/10 text-brand-primary border border-brand-primary/20 text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Dropshipping Made Simple</span>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight">Sell Products Without Stocking Them</h2>
                        <p class="text-stone-300 text-sm md:text-base max-w-sm mx-auto lg:mx-0">Create your account, clone a brand's store, and start selling online. When you get an order, the brand owner handles fulfillment for you. </p></p>
                        <div class="pt-2">
                            <a href="#" class="inline-block bg-brand-primary text-brand-dark font-bold text-sm px-6 py-3.5 rounded-xl hover:bg-amber-400 transition shadow-lg shadow-amber-500/10">Get Started</a>
                        </div>
                    </div>

                    <!-- Steps Architecture -->
                    <div class="lg:col-span-7 grid sm:grid-cols-5 gap-4 text-center sm:text-left">
                        <div class="space-y-1 bg-white/5 p-4 rounded-xl border border-white/5">
                            <div class="font-black text-brand-primary text-xl">01</div>
                            <h4 class="font-bold text-white text-xs">Create Profile</h4>
                        </div>
                        <div class="space-y-1 bg-white/5 p-4 rounded-xl border border-white/5">
                            <div class="font-black text-brand-primary text-xl">02</div>
                            <h4 class="font-bold text-white text-xs">Find Brands</h4>
                        </div>
                        <div class="space-y-1 bg-white/5 p-4 rounded-xl border border-white/5">
                            <div class="font-black text-brand-primary text-xl">03</div>
                            <h4 class="font-bold text-white text-xs">Clone Store</h4>
                        </div>
                        <div class="space-y-1 bg-white/5 p-4 rounded-xl border border-white/5">
                            <div class="font-black text-brand-primary text-xl">04</div>
                            <h4 class="font-bold text-white text-xs">Start Selling</h4>
                        </div>
                        <div class="space-y-1 bg-white/5 p-4 rounded-xl border border-white/5">
                            <div class="font-black text-white text-xl">05</div>
                            <h4 class="font-bold text-white text-xs">Earn Profit</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== 10. FINAL CTA SECTION ==================== -->
    <section class="py-20 md:py-28 bg-premium-dark text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff01_1px,transparent_1px),linear-gradient(to_bottom,#ffffff01_1px,transparent_1px)] bg-[size:40px_40px]"></div>

        <div class="max-w-2xl mx-auto px-4 relative z-10 space-y-6">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight">Ready to Grow Your Business?</h2>
            <p class="text-stone-300 text-sm md:text-base max-w-md mx-auto">Create your store in minutes and start configuring your distribution network today.</p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                <a href="#" class="btn-primary px-8 py-3.5 w-full sm:w-auto text-center text-sm">Create Store</a>
                <a href="#" class="bg-white/5 hover:bg-white/10 text-white font-semibold border border-white/10 px-8 py-3.5 rounded-xl w-full sm:w-auto text-center transition text-sm">Explore Brands</a>
            </div>
        </div>
    </section>

@endsection

