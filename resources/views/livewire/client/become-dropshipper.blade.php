<section class="w-full text-white">
    @include('partials.client-dropshipper-heading')

    <div class="text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff03_1px,transparent_1px),linear-gradient(to_bottom,#ffffff03_1px,transparent_1px)] bg-[size:40px_40px]"></div>
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-brand-primary/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-[1em]  text-center relative z-10">

            <div class="w-14 h-14 mx-auto mb-6 rounded-2xl bg-white/[0.03] border border-white/10 shadow-lg shadow-black/50 flex items-center justify-center text-brand-primary text-xl backdrop-blur-md">
                <img class="w-8 h-8" src="{{ asset('images/Logo-Crown.svg') }}" alt="">
            </div>

            <span class="inline-block text-brand-primary font-bold text-xs uppercase tracking-widest px-3 py-1 rounded-full bg-brand-primary/10 border border-brand-primary/25">
                Become a Dropshipper
            </span>

            <h1 class="mt-6 text-4xl sm:text-5xl font-black tracking-tight leading-tight max-w-3xl mx-auto">
                Sell Products Without
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-amber-200">
                    Keeping Inventory
                </span>
            </h1>

            <p class="mt-6 text-stone-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Find brand owners on KING'S, apply to dropship their products, and start selling once you are approved.
                Sell through your own store and earn your profit on every sale.
            </p>

            <div class="mt-8">
                <flux:button
                    size="sm"
                    variant="primary"
                    wire:click="submit"
                >
                    Become a Dropshipper
                </flux:button>
            </div>

        </div>
    </div>


    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">

        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-2xl md:text-3xl font-black text-white">
                How It Works
            </h2>

            <p class="mt-3 text-sm text-stone-400">
                Getting started as a dropshipper is simple.
            </p>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="feature-card p-6 text-center rounded-2xl bg-white/[0.02] border border-white/10 backdrop-blur-sm transition-all duration-300 hover:border-brand-primary/40 hover:bg-white/[0.04] shadow-xl flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 mx-auto rounded-xl bg-white/[0.05] border border-white/10 flex items-center justify-center text-brand-primary shadow-inner">
                        <i class="fas fa-magnifying-glass"></i>
                    </div>

                    <div class="mt-5">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-brand-primary">
                            Step 01
                        </span>

                        <h3 class="mt-2 font-extrabold text-white">
                            Find Brand Owners
                        </h3>
                    </div>
                </div>

                <p class="mt-2 text-xs text-stone-400 leading-relaxed">
                    Browse brand owners on KINGS and find businesses you would like to work with.
                </p>
            </div>


            <div class="feature-card p-6 text-center rounded-2xl bg-white/[0.02] border border-white/10 backdrop-blur-sm transition-all duration-300 hover:border-brand-primary/40 hover:bg-white/[0.04] shadow-xl flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 mx-auto rounded-xl bg-white/[0.05] border border-white/10 flex items-center justify-center text-brand-primary shadow-inner">
                        <i class="fas fa-cart-plus"></i>
                    </div>

                    <div class="mt-5">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-brand-primary">
                            Step 02
                        </span>

                        <h3 class="mt-2 font-extrabold text-white">
                            Apply & Get Approved
                        </h3>
                    </div>
                </div>

                <p class="mt-2 text-xs text-stone-400 leading-relaxed">
                    Apply to dropship for a brand owner. Once approved, you can clone their store and start selling.
                </p>
            </div>


            <div class="feature-card p-6 text-center rounded-2xl bg-white/[0.02] border border-white/10 backdrop-blur-sm transition-all duration-300 hover:border-brand-primary/40 hover:bg-white/[0.04] shadow-xl flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 mx-auto rounded-xl bg-white/[0.05] border border-white/10 flex items-center justify-center text-brand-primary shadow-inner">
                        <i class="fas fa-money-bill-trend-up"></i>
                    </div>

                    <div class="mt-5">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-brand-primary">
                            Step 03
                        </span>

                        <h3 class="mt-2 font-extrabold text-white">
                            Earn Your Profit
                        </h3>
                    </div>
                </div>

                <p class="mt-2 text-xs text-stone-400 leading-relaxed">
                    Get orders from your customers, push the orders to the brand owner, and keep your profit.
                </p>
            </div>

        </div>
    </div>


    <section class="border-white/10 relative rounded-lg">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div>
                    <span class="inline-block text-brand-primary font-bold text-xs uppercase tracking-widest px-3 py-1 rounded-full bg-brand-primary/10 border border-brand-primary/25">
                        Why Dropship With Us
                    </span>
                    <h2 class="mt-4 text-2xl md:text-3xl font-black text-white leading-tight">
                        Everything You Need to Start Selling
                    </h2>
                    <p class="mt-4 text-sm text-stone-400 leading-relaxed max-w-lg">
                        KINGS connects you with brand owners who are open to working with dropshippers.
                        Find a brand, get approved, clone their store, and start selling.
                    </p>

                    <div class="my-[1rem]">
                        <h3 class="font-extrabold text-white">
                            How dropshipping works on KINGS
                        </h3>

                        <p class="mt-2 text-sm text-stone-400 leading-relaxed">
                            Find a brand owner you want to work with and apply to become their dropshipper.
                            Once the brand owner approves your request, you can clone their store and start selling their products.
                        </p>

                        <p class="mt-3 text-sm text-stone-400 leading-relaxed">
                            When a customer places an order through your store, you send the order to the brand owner.
                            The brand owner handles the product, while you keep your profit from the sale.
                        </p>
                    </div>
                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="bg-white/[0.02] rounded-2xl border border-white/10 p-5 shadow-xl backdrop-blur-sm transition-all duration-300 hover:border-white/20">

                        <div class="w-9 h-9 rounded-lg bg-white/[0.05] border border-white/10 flex items-center justify-center text-brand-primary text-sm">
                            <i class="fas fa-box-open"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-extrabold text-white">
                            Access Products
                        </h3>

                        <h3 class="mt-4 text-sm font-extrabold text-white">
                            Find Brand Owners
                        </h3>

                        <p class="mt-2 text-xs text-stone-400 leading-relaxed">
                            Find brand owners who are available to work with dropshippers.
                        </p>

                    </div>


                    <div class="bg-white/[0.02] rounded-2xl border border-white/10 p-5 shadow-xl backdrop-blur-sm transition-all duration-300 hover:border-white/20">

                        <div class="w-9 h-9 rounded-lg bg-white/[0.05] border border-white/10 flex items-center justify-center text-brand-primary text-sm">
                            <i class="fas fa-store"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-extrabold text-white">
                            Your Own Store
                        </h3>

                        <h3 class="mt-4 text-sm font-extrabold text-white">
                            Clone Approved Stores
                        </h3>

                        <p class="mt-2 text-xs text-stone-400 leading-relaxed">
                            Once approved, clone the brand owner's store and sell their products through your own store.
                        </p>

                    </div>


                    <div class="bg-white/[0.02] rounded-2xl border border-white/10 p-5 shadow-xl backdrop-blur-sm transition-all duration-300 hover:border-white/20">

                        <div class="w-9 h-9 rounded-lg bg-white/[0.05] border border-white/10 flex items-center justify-center text-brand-primary text-sm">
                            <i class="fas fa-arrows-rotate"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-extrabold text-white">
                            Product Updates
                        </h3>

                        <h3 class="mt-4 text-sm font-extrabold text-white">
                            Work With Brands
                        </h3>

                        <p class="mt-2 text-xs text-stone-400 leading-relaxed">
                            Build relationships with brand owners and sell their products as an approved dropshipper.
                        </p>

                    </div>


                    <div class="bg-white/[0.02] rounded-2xl border border-white/10 p-5 shadow-xl backdrop-blur-sm transition-all duration-300 hover:border-white/20">

                        <div class="w-9 h-9 rounded-lg bg-white/[0.05] border border-white/10 flex items-center justify-center text-brand-primary text-sm">
                            <i class="fas fa-chart-line"></i>
                        </div>

                        <h3 class="mt-4 text-sm font-extrabold text-white">
                            Manage Your Orders
                        </h3>

                        <p class="mt-2 text-xs text-stone-400 leading-relaxed">
                            Track your customer orders and push them to the brand owner for fulfillment.
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

        <div class="bg-gradient-to-b from-[#111] to-[#080808] rounded-3xl p-8 md:p-12 text-center text-white relative overflow-hidden border border-white/10 shadow-2xl">

            <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff03_1px,transparent_1px),linear-gradient(to_bottom,#ffffff03_1px,transparent_1px)] bg-[size:40px_40px]"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-brand-primary/10 via-transparent to-amber-500/10 opacity-50 pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl mx-auto">

                <div class="w-12 h-12 mx-auto rounded-xl bg-white/[0.05] border border-white/10 flex items-center justify-center text-brand-primary shadow-lg backdrop-blur-md">
                    <i class="fas fa-handshake"></i>
                </div>

                <h2 class="mt-5 text-2xl md:text-3xl font-black">
                    Ready to Start Selling?
                </h2>

                <p class="mt-3 text-sm text-stone-400">
                    Become a KINGS dropshipper, partner with brand owners, and start selling through your own store.
                </p>

                <div class="mt-7">

                    <flux:button
                        size="sm"
                        variant="primary"
                        wire:click="submit"
                    >
                        Become a Dropshipper
                    </flux:button>
                </div>
            </div>
        </div>
    </section>
</section>
