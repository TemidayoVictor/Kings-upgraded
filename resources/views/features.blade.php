@extends('layouts.web')

@section('title')
    Brands
@endsection

@section('content')
    <!-- ==================== HERO HEADER ==================== -->
    <header class="bg-premium-dark text-white pt-24 pb-28 relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff01_1px,transparent_1px),linear-gradient(to_bottom,#ffffff01_1px,transparent_1px)] bg-[size:40px_40px]"></div>
        <div class="max-w-5xl mx-auto px-4 text-center space-y-6 relative z-10">
            <span class="text-brand-primary font-bold text-xs uppercase tracking-widest block bg-white/5 w-fit mx-auto px-4 py-1.5 rounded-full border border-white/10">What We Do</span>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight leading-tight max-w-3xl mx-auto">
                Everything You Need to Build Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-amber-200">Online Business</span>
            </h1>
            <p class="text-stone-400 text-xs sm:text-sm md:text-base max-w-xl mx-auto leading-relaxed">
                Our tools help brand owners, dropshippers, and customers connect and sell products in one place.
            </p>
        </div>
    </header>

    <!-- ==================== FEATURES GRID ==================== -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 space-y-20">

        <!-- BLOCK 1: STORES & PROFILES -->
        <div class="space-y-6">
            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-xl font-black text-stone-900 tracking-tight">1. Setup & Discovery</h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 1: Store & Brand System -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-shop"></i></div>
                        <h3 class="font-extrabold text-stone-900 text-sm">Store & Brand System</h3>
                        <p class="text-xs text-brand-muted leading-relaxed">Create your own online shop, upload products, and set up your brand layout.</p>
                    </div>
                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Make your own store</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Upload products</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Organize catalogs</li>
                    </ul>
                </div>

                <!-- Feature 7: Multi-User Ecosystem -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-users-gear"></i></div>
                        <h3 class="font-extrabold text-stone-900 text-sm">Multi-User System</h3>
                        <p class="text-xs text-brand-muted leading-relaxed">Our platform has space for everyone: Brand Owners, Dropshippers, and Customers.</p>
                    </div>
                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Brand Owner tools</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Dropshipper tools</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Separate user roles</li>
                    </ul>
                </div>

                <!-- Feature 10: Marketplace / Brand Discovery -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-signs-post"></i></div>
                        <h3 class="font-extrabold text-stone-900 text-sm">Marketplace Directory</h3>
                        <p class="text-xs text-brand-muted leading-relaxed">See all different stores and products in one space, sorted easily by categories.</p>
                    </div>
                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Browse all brands</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Category browsing</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Discover products</li>
                    </ul>
                </div>

                <!-- Feature 11: Account & Profile System -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-id-card-clip"></i></div>
                        <h3 class="font-extrabold text-stone-900 text-sm">Account & Profiles</h3>
                        <p class="text-xs text-brand-muted leading-relaxed">Easy log in and registration pages for you and your business team.</p>
                    </div>
                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Fast user login</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Business profiles</li>
                        <li><i class="fas fa-check text-brand-accent text-[9px] mr-1"></i> Contact details</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- BLOCK 2: DROPSHIPPING & CLONING -->
        <div class="space-y-6">
            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-xl font-black text-stone-900 tracking-tight">2. Dropshipping & Store Cloning</h2>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <!-- Feature 2: Dropshipping System -->
                <div class="feature-card p-6 border-l-4 border-l-brand-primary space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-accent text-sm"><i class="fas fa-diagram-predecessor"></i></div>
                    <h3 class="font-black text-stone-900 text-base">Dropshipping Tools</h3>
                    <p class="text-xs text-brand-muted leading-relaxed">
                        Let other people sell your items. You get more sales without handling extra shipping or packing work yourself.
                    </p>
                    <div class="text-[11px] text-stone-600 space-y-1 pt-2">
                        <div><i class="fas fa-arrow-right text-brand-primary text-[10px] mr-1"></i> Let others sell your inventory</div>
                        <div><i class="fas fa-arrow-right text-brand-primary text-[10px] mr-1"></i> Track reseller sales activity</div>
                        <div><i class="fas fa-arrow-right text-brand-primary text-[10px] mr-1"></i> Grow your business footprint</div>
                    </div>
                </div>

                <!-- Feature 8: Dropshipping / Store Cloning Engine -->
                <div class="feature-card p-6 border-l-4 border-l-stone-900 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-clone"></i></div>
                    <h3 class="font-black text-stone-900 text-base">Store Cloning Engine</h3>
                    <p class="text-xs text-brand-muted leading-relaxed">
                        Approved users can copy existing stores instantly. All product data and images sync automatically for fast resale.
                    </p>
                    <div class="text-[11px] text-stone-600 space-y-1 pt-2">
                        <div><i class="fas fa-arrow-right text-stone-900 text-[10px] mr-1"></i> Copy whole stores easily</div>
                        <div><i class="fas fa-arrow-right text-stone-900 text-[10px] mr-1"></i> Auto-sync product details</div>
                        <div><i class="fas fa-arrow-right text-stone-900 text-[10px] mr-1"></i> Reseller friendly layout</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOCK 3: ORDERS & PAYMENTS -->
        <div class="space-y-6">
            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-xl font-black text-stone-900 tracking-tight">3. Orders & Cash Flow</h2>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <!-- Feature 3: Order Management System -->
                <div class="feature-card p-6 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-boxes-packing"></i></div>
                    <h3 class="font-extrabold text-stone-900 text-sm">Order Management</h3>
                    <p class="text-xs text-brand-muted leading-relaxed">
                        See new customer orders the moment they buy. Track shipping and view purchase records instantly on one dashboard.
                    </p>
                    <div class="grid grid-cols-2 gap-2 text-[11px] text-stone-600 pt-2">
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Real-time tracking</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Manage fulfillments</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Full order histories</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Fast buyer checkout</div>
                    </div>
                </div>

                <!-- Feature 4: Payment & Earnings System -->
                <div class="feature-card p-6 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-credit-card"></i></div>
                    <h3 class="font-extrabold text-stone-900 text-sm">Payments & Earnings</h3>
                    <p class="text-xs text-brand-muted leading-relaxed">
                        Safe payment processing options for clients. Track your income and manage dropshipper commissions without errors.
                    </p>
                    <div class="grid grid-cols-2 gap-2 text-[11px] text-stone-600 pt-2">
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Secure checkouts</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Earnings dashboards</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> Commission splits</div>
                        <div><i class="fas fa-circle text-[5px] text-brand-primary mr-1"></i> History tracking</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOCK 4: GROWTH & NETWORK -->
        <div class="space-y-6">
            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-xl font-black text-stone-900 tracking-tight">4. Tools, Insights & Community</h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 5: Reviews & Ratings -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-star-half-stroke"></i></div>
                        <h3 class="font-extrabold text-stone-900 text-sm">Reviews & Ratings</h3>
                        <p class="text-xs text-brand-muted leading-relaxed">Customers leave honest feedback on your shop products to help build online trust.</p>
                    </div>
                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Public star scores</li>
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Build buyer trust</li>
                    </ul>
                </div>

                <!-- Feature 6: Sales & Marketing Tools -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-rectangle-ad"></i></div>
                        <h3 class="font-extrabold text-stone-900 text-sm">Marketing Tools</h3>
                        <p class="text-xs text-brand-muted leading-relaxed">Run custom discount sales campaigns to show your items to more buyers.</p>
                    </div>
                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Create discounts</li>
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Boost views easily</li>
                    </ul>
                </div>

                <!-- Feature 9: Analytics & Insights -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-chart-line-up"></i></div>
                        <h3 class="font-extrabold text-stone-900 text-sm">Analytics & Reports</h3>
                        <p class="text-xs text-brand-muted leading-relaxed">Simple charts showing your store sales, total growth, and visitor counts.</p>
                    </div>
                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Track store sales</li>
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> View store growth</li>
                    </ul>
                </div>

                <!-- Feature 12: Community Ecosystem -->
                <div class="feature-card p-6 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-stone-50 border border-stone-100 flex items-center justify-center text-brand-dark text-sm"><i class="fas fa-circle-nodes"></i></div>
                        <h3 class="font-extrabold text-stone-900 text-sm">Shared Community</h3>
                        <p class="text-xs text-brand-muted leading-relaxed">A growing network connecting brand makers directly with top product sellers.</p>
                    </div>
                    <ul class="text-[11px] text-stone-600 space-y-1 pt-2 border-t border-stone-100">
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Seller network</li>
                        <li><i class="fas fa-check text-brand-primary text-[10px] mr-1"></i> Shared market space</li>
                    </ul>
                </div>
            </div>
        </div>

    </main>

    <!-- ==================== CALL TO ACTION ==================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="bg-brand-dark bg-premium-dark rounded-3xl p-8 md:p-12 text-center text-white space-y-6 relative border border-white/5 shadow-xl">
            <div class="max-w-2xl mx-auto space-y-3">
                <h2 class="text-2xl font-black tracking-tight">Ready to Setup Your Store?</h2>
                <p class="text-stone-400 text-xs sm:text-sm">Join our platform today to start building or selling items online.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="#" class="w-full sm:w-auto bg-brand-primary hover:bg-amber-400 text-brand-dark font-bold text-xs px-6 py-3.5 rounded-xl transition">Create Your Store</a>
                <a href="#" class="w-full sm:w-auto bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold text-xs px-6 py-3.5 rounded-xl transition">See All Brands</a>
            </div>
        </div>
    </section>
@endsection
