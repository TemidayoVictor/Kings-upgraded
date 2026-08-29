@extends('layouts.web')

@section('title')
    What We Do
@endsection

@section('content')

    <!-- ==================== HERO HEADER ==================== -->
    <header class="bg-premium-dark text-white pt-24 pb-28 relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff01_1px,transparent_1px),linear-gradient(to_bottom,#ffffff01_1px,transparent_1px)] bg-[size:40px_40px]"></div>

        <div class="max-w-5xl mx-auto px-4 text-center space-y-6 relative z-10">

            <span class="text-white font-bold text-xs uppercase tracking-widest block bg-white/5 w-fit mx-auto px-4 py-1.5 rounded-full border border-white/10">
                What We Do
            </span>

            <h1 class="text-4xl text-brand-primary sm:text-5xl font-black tracking-tight leading-tight max-w-3xl mx-auto">
                Everything Your Business Needs to
                <span class="text-white bg-clip-text bg-gradient-to-r from-brand-primary to-amber-200">
                    Get Seen, Sell & Grow
                </span>
            </h1>

            <p class="text-stone-400 text-xs sm:text-sm md:text-base max-w-xl mx-auto">
                KING'S gives businesses a place to showcase what they do, build trust with customers,
                sell their products, and reach more people through Dropshippers.
            </p>

        </div>
    </header>


    <!-- ==================== FEATURES ==================== -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 space-y-20">


        <!-- BLOCK 1: BUSINESS PRESENCE -->
        <div class="space-y-6">

            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-xl font-black text-stone-900 tracking-tight">
                    1. Build Your Business Presence
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Business Profile -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">

                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                            <i class="fas fa-store"></i>
                        </div>

                        <h3 class="font-extrabold text-stone-900 text-sm">
                            Your Business Profile
                        </h3>

                        <p class="text-xs text-brand-muted leading-relaxed">
                            Tell people about your business and give them one place to learn about what you offer.
                        </p>

                    </div>

                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Business information</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Logo and business details</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Social media links</li>
                    </ul>
                </div>


                <!-- Online Store -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">

                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                            <i class="fas fa-shop"></i>
                        </div>

                        <h3 class="font-extrabold text-stone-900 text-sm">
                            Your Online Store
                        </h3>

                        <p class="text-xs text-brand-muted leading-relaxed">
                            Create a store where customers can see your products, add items to their cart, and place orders.
                        </p>

                    </div>

                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Add your products</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Organize your store</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Accept customer orders</li>
                    </ul>
                </div>


                <!-- Discover Businesses -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">

                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                            <i class="fas fa-compass"></i>
                        </div>

                        <h3 class="font-extrabold text-stone-900 text-sm">
                            Get Discovered
                        </h3>

                        <p class="text-xs text-brand-muted leading-relaxed">
                            Let new customers discover your business and the products or services you offer.
                        </p>

                    </div>

                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Business discovery</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Product discovery</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Browse by category</li>
                    </ul>
                </div>


                <!-- Reviews -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">

                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                            <i class="fas fa-star"></i>
                        </div>

                        <h3 class="font-extrabold text-stone-900 text-sm">
                            Reviews & Ratings
                        </h3>

                        <p class="text-xs text-brand-muted leading-relaxed">
                            Let customers share their experience and help new customers buy with confidence.
                        </p>

                    </div>

                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Customer reviews</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Business ratings</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Build customer trust</li>
                    </ul>
                </div>

            </div>
        </div>


        <!-- BLOCK 2: DropshipperS -->
        <div class="space-y-6">

            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-xl font-black text-stone-900 tracking-tight">
                    2. Grow Through Dropshippers
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">

                <!-- Dropshipper Network -->
                <div class="feature-card p-6 border-l-4 border-l-brand-primary space-y-3">

                    <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-accent text-sm">
                        <i class="fas fa-people-arrows"></i>
                    </div>

                    <h3 class="font-black text-stone-900 text-base">
                        Dropshipper Network
                    </h3>

                    <p class="text-xs text-brand-muted leading-relaxed">
                        Give other people the opportunity to sell your products. Approved dropshippers can promote your products and earn from the sales they make.
                    </p>

                    <div class="text-[11px] text-stone-600 space-y-1 pt-2">
                        <div>
                            <i class="fas fa-arrow-right text-brand-primary text-[10px] mr-1"></i>
                            Reach more customers
                        </div>

                        <div>
                            <i class="fas fa-arrow-right text-brand-primary text-[10px] mr-1"></i>
                            Work with approved dropshippers
                        </div>

                        <div>
                            <i class="fas fa-arrow-right text-brand-primary text-[10px] mr-1"></i>
                            Increase your sales opportunities
                        </div>
                    </div>

                </div>


                <!-- Partner Stores -->
                <div class="feature-card p-6 border-l-4 border-l-stone-900 space-y-3">

                    <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                        <i class="fas fa-clone"></i>
                    </div>

                    <h3 class="font-black text-stone-900 text-base">
                        Dropshipper Stores
                    </h3>

                    <p class="text-xs text-brand-muted leading-relaxed">
                        With the business owner's approval, a dropshipper can create a store featuring the business's products and start selling them.
                    </p>

                    <div class="text-[11px] text-stone-600 space-y-1 pt-2">
                        <div>
                            <i class="fas fa-arrow-right text-stone-900 text-[10px] mr-1"></i>
                            Partner with existing businesses
                        </div>

                        <div>
                            <i class="fas fa-arrow-right text-stone-900 text-[10px] mr-1"></i>
                            Sell products without holding stock
                        </div>

                        <div>
                            <i class="fas fa-arrow-right text-stone-900 text-[10px] mr-1"></i>
                            Earn from every successful sale
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <!-- BLOCK 3: ORDERS & PAYMENTS -->
        <div class="space-y-6">

            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-xl font-black text-stone-900 tracking-tight">
                    3. Sell & Manage Orders
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">

                <!-- Orders -->
                <div class="feature-card p-6 space-y-3">

                    <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                        <i class="fas fa-boxes-packing"></i>
                    </div>

                    <h3 class="font-extrabold text-stone-900 text-sm">
                        Manage Your Orders
                    </h3>

                    <p class="text-xs text-brand-muted leading-relaxed">
                        Keep track of customer orders from the moment they are placed until they are fulfilled.
                    </p>

                    <div class="grid grid-cols-2 gap-2 text-[11px] text-stone-600 pt-2">
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> View orders</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Track fulfillment</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Order history</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Customer details</div>
                    </div>

                </div>


                <!-- Payments -->
                <div class="feature-card p-6 space-y-3">

                    <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                        <i class="fas fa-credit-card"></i>
                    </div>

                    <h3 class="font-extrabold text-stone-900 text-sm">
                        Payments & Earnings
                    </h3>

                    <p class="text-xs text-brand-muted leading-relaxed">
                        Make it easy for customers to pay and keep track of your sales, earnings, and partner commissions.
                    </p>

                    <div class="grid grid-cols-2 gap-2 text-[11px] text-stone-600 pt-2">
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Customer payments</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Sales earnings</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Partner commissions</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Payment history</div>
                    </div>

                </div>

            </div>
        </div>


        <!-- BLOCK 4: BUSINESS GROWTH -->
        <div class="space-y-6">

            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-xl font-black text-stone-900 tracking-tight">
                    4. Understand & Grow Your Business
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Marketing -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">

                    <div class="space-y-3">

                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                            <i class="fas fa-bullhorn"></i>
                        </div>

                        <h3 class="font-extrabold text-stone-900 text-sm">
                            Promote Your Products
                        </h3>

                        <p class="text-xs text-brand-muted leading-relaxed">
                            Create offers and promotions that can help attract more customers to your products.
                        </p>

                    </div>

                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Create discounts</li>
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Promote products</li>
                    </ul>

                </div>


                <!-- Analytics -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">

                    <div class="space-y-3">

                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                            <i class="fas fa-chart-line"></i>
                        </div>

                        <h3 class="font-extrabold text-stone-900 text-sm">
                            Sales Insights
                        </h3>

                        <p class="text-xs text-brand-muted leading-relaxed">
                            See how your business and products are performing and understand where your sales are coming from.
                        </p>

                    </div>

                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Track sales</li>
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Monitor growth</li>
                    </ul>

                </div>


                <!-- Community -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">

                    <div class="space-y-3">

                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                            <i class="fas fa-users"></i>
                        </div>

                        <h3 class="font-extrabold text-stone-900 text-sm">
                            Business Community
                        </h3>

                        <p class="text-xs text-brand-muted leading-relaxed">
                            Connect with other businesses, customers, and people looking for products to sell.
                        </p>

                    </div>

                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Meet other businesses</li>
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Connect with Dropshippers</li>
                    </ul>

                </div>


                <!-- Trust -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">

                    <div class="space-y-3">

                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm">
                            <i class="fas fa-shield-halved"></i>
                        </div>

                        <h3 class="font-extrabold text-stone-900 text-sm">
                            Build Your Reputation
                        </h3>

                        <p class="text-xs text-brand-muted leading-relaxed">
                            Give customers more confidence by building a strong business profile and collecting genuine reviews.
                        </p>

                    </div>

                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Customer feedback</li>
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Business reputation</li>
                    </ul>

                </div>

            </div>
        </div>

    </main>


    <!-- ==================== CALL TO ACTION ==================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">

        <div class="bg-brand-dark bg-premium-dark rounded-3xl p-8 md:p-12 text-center text-white space-y-6 relative border border-white/5 shadow-xl">

            <div class="max-w-2xl mx-auto space-y-3">

                <h2 class="text-3xl font-black tracking-tight text-brand-primary">
                    Ready to Grow Your Business?
                </h2>

                <p class="text-white text-xs sm:text-sm">
                    Create your business on KING'S and start getting discovered, building trust, and selling to more customers.
                </p>

            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">

                <a href="{{ route('brands') }}"
                   class="w-full sm:w-auto bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold text-xs px-6 py-3.5 rounded-xl transition">
                    Discover Businesses
                </a>

            </div>

        </div>

    </section>

@endsection
