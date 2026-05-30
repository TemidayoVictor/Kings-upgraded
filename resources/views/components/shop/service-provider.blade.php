<div class="pb-24 bg-neutral-50/50">

    <!-- Dynamic Theme Color Injection for this Specific Hero Component Container -->
    <style>
        :root {
            --primary: {{ $brand->brandSetting->primary_color ?? '#000000' }};
            --secondary: {{ $brand->brandSetting->secondary_color ?? '#f7f6f2' }};
        }
        /* Custom dynamic utility rules for clean code integration */
        .bg-brand-primary { background-color: var(--primary); }
        .text-brand-primary { color: var(--primary); }
        .border-brand-primary { border-color: var(--primary); }
        .hover\:bg-brand-primary:hover { background-color: var(--primary); }
        .hover\:border-brand-primary:hover { border-color: var(--primary); }
        .focus\:border-brand-primary:focus { border-color: var(--primary); }
        .focus\:ring-brand-primary:focus { --tw-ring-color: var(--primary); }
        .accent-brand-primary { accent-color: var(--primary); }
    </style>

    <!-- Editorial Split Hero Configuration Layer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <div class="bg-[var(--secondary)] rounded-[1.5em] overflow-hidden grid grid-cols-1 lg:grid-cols-12 items-center min-h-[540px] relative border border-neutral-200/40 shadow-xs">
            <div class="absolute inset-0 bg-gradient-to-tr from-white/40 via-transparent to-black/[0.02] pointer-events-none"></div>

            <!-- Left Text Content -->
            <div class="p-8 sm:p-12 lg:p-20 lg:col-span-7 relative z-10 space-y-6 order-2 lg:order-1">
                <span class="text-xs font-bold tracking-[4px] uppercase text-neutral-500 block">
                    {{ $brand->brandSetting->hero_tagline ?? 'Bespoke Professional Consultations & Care' }}
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-light tracking-tight text-neutral-900 leading-[1.05] serif-display">
                    {{ $brand->brandSetting->hero_title_line_1 ?? 'Elevate your' }}
                    <br>
                    <span class="text-brand-primary font-normal italic">
                        {{ $brand->brandSetting->hero_title_line_2_italic ?? 'everyday experience.' }}
                    </span>
                </h1>

                <p class="text-sm sm:text-base text-neutral-600 max-w-md font-light leading-relaxed">
                    {{ $brand->brandSetting->hero_description ?? 'Expertly designed sessions, specialized techniques, and personalized attention. Crafted seamlessly to match your lifestyle and wellness goals.' }}
                </p>

                <div class="pt-4">
                    <button class="w-full sm:w-auto justify-center bg-neutral-950 text-white text-xs font-medium tracking-widest uppercase px-8 py-4.5 rounded-full hover:bg-brand-primary transition-all duration-300 shadow-lg hover:-translate-y-1 flex items-center gap-3 group cursor-pointer">
                        {{ $brand->brandSetting->hero_button_text ?? 'Explore Services' }}
                        <i class="fa-solid fa-arrow-right-long transition-transform group-hover:translate-x-1.5"></i>
                    </button>
                </div>
            </div>

            <!-- Right Visual Layout Box -->
            <div class="block lg:col-span-5 h-64 sm:h-80 lg:h-full relative self-stretch overflow-hidden order-1 lg:order-2">
                @if($brand->image)
                    <!-- Full-Bleed Brand Image Layer with subtle gradient protection overlay -->
                    <img
                        src="{{ asset('storage/' . $brand->image) }}"
                        alt="{{ $brand->brand_name }} Service Showcase"
                        class="absolute inset-0 w-full h-full object-cover object-center"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-[var(--secondary)]/20 to-transparent lg:hidden"></div>
                @else
                    <!-- Balanced Glassmorphism Centered Placeholder -->
                    <div class="absolute inset-0 flex items-center justify-center p-6 sm:p-12 bg-neutral-950/5">
                        <div class="w-full h-full rounded-[24px] sm:rounded-[32px] border border-white/30 bg-gradient-to-b from-white/10 to-transparent backdrop-blur-md shadow-2xl flex items-center justify-center">
                            <i class="fa-solid fa-sparkles text-5xl sm:text-7xl text-brand-primary opacity-60 animate-pulse"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Core Dynamic Catalog Interface Container Framework -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">

        <!-- Modern Layout: Left Filter Sidebar, Right Service Menu Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

            <!-- Structural Sidebar Panel Left (Desktop Filters) -->
            <div class="lg:col-span-3 sticky top-28 space-y-8 hidden lg:block">
                <!-- Search Component Segment -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-400">Service Directory</h4>
                    <div class="relative">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search treatments & sessions..."
                            class="w-full bg-white text-neutral-800 text-xs rounded-xl border border-neutral-200 outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary px-5 py-4 pl-11 transition-all shadow-2xs"
                        >
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 text-xs"></i>
                    </div>
                </div>

                <!-- Structural List Categories -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-400">Categories</h4>
                    <div class="flex flex-col gap-1.5">
                        <button
                            wire:click="$set('selectedSection', 'all')"
                            class="w-full text-left px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition-all flex items-center justify-between cursor-pointer {{ $selectedSection === 'all' ? 'bg-brand-primary text-white font-semibold shadow-xs' : 'text-neutral-600 bg-white border border-neutral-100 hover:bg-neutral-50' }}"
                        >
                            <span>All Services</span>
                            <i class="fa-solid fa-layer-group text-[10px] opacity-80"></i>
                        </button>
                        @foreach($sections as $section)
                            <button
                                wire:click="$set('selectedSection', {{ $section->id }})"
                                class="w-full text-left px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition-all flex items-center justify-between cursor-pointer {{ $selectedSection == $section->id ? 'bg-brand-primary text-white font-semibold shadow-xs' : 'text-neutral-600 bg-white border border-neutral-100 hover:bg-neutral-50' }}"
                            >
                                <span class="truncate">{{ $section->name }}</span>
                                <i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range Component Segment -->
                <div class="pt-4 border-t border-neutral-200/60 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-400">Filter By Rate</h4>
                    <div class="bg-white p-5 rounded-2xl border border-neutral-200/60 space-y-4 shadow-2xs">
                        <div class="flex items-center justify-between text-xs text-neutral-600 font-semibold">
                            <span class="bg-neutral-50 border border-neutral-100 rounded-md px-2 py-1">₦{{ number_format($priceRange[0]) }}</span>
                            <span class="bg-neutral-50 border border-neutral-100 rounded-md px-2 py-1">₦{{ number_format($priceRange[1]) }}</span>
                        </div>
                        <div class="flex flex-col gap-3">
                            <input
                                type="range"
                                wire:model.live="priceRange.0"
                                min="{{ $minPrice }}"
                                max="{{ $maxPrice }}"
                                class="w-full accent-brand-primary cursor-pointer"
                            >
                            <input
                                type="range"
                                wire:model.live="priceRange.1"
                                min="{{ $minPrice }}"
                                max="{{ $maxPrice }}"
                                class="w-full accent-brand-primary cursor-pointer"
                            >
                        </div>
                    </div>
                </div>

                <!-- Sorting Segment -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-400">Sort By</h4>
                    <select
                        wire:model.live="sortBy"
                        class="w-full bg-white text-neutral-700 text-xs font-medium px-4 py-3.5 rounded-xl border border-neutral-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary outline-none shadow-2xs cursor-pointer"
                    >
                        <option value="newest">Newly Listed</option>
                        <option value="price_low">Rate: Low to High</option>
                        <option value="price_high">Rate: High to Low</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>

            <!-- Right Segment Content Panel (Service Menu Display) -->
            <div class="lg:col-span-9 space-y-8">

                <!-- Toolbar Header Control Block (Mobile Navigation Layer Only) -->
                <div class="bg-[var(--secondary)] p-4 rounded-2xl border border-neutral-200/60 flex flex-col gap-3 items-center justify-between lg:hidden shadow-xs">

                    <!-- Search Input element container -->
                    <div class="w-full relative">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search offering..."
                            class="w-full bg-white text-neutral-800 text-xs rounded-xl border border-neutral-200 px-4 py-3 pl-10 focus:border-brand-primary focus:ring-1 focus:ring-brand-primary"
                        >
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-neutral-400 text-xs"></i>
                    </div>

                    <!-- Sorting options dropdown element container -->
                    <div class="w-full">
                        <select
                            wire:model.live="sortBy"
                            class="w-full bg-white text-neutral-700 text-xs font-medium px-4 py-3 rounded-xl border border-neutral-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary outline-none"
                        >
                            <option value="newest">Newly Listed</option>
                            <option value="price_low">Rate: Low to High</option>
                            <option value="price_high">Rate: High to Low</option>
                            <option value="popular">Most Popular</option>
                        </select>
                    </div>

                    <!-- Category Pills Display layout wrapper view -->
                    <div class="w-full overflow-x-auto no-scrollbar flex gap-2 pt-1 border-t border-neutral-200/40">
                        <button
                            wire:click="$set('selectedSection', 'all')"
                            class="text-xs px-4 py-2.5 shrink-0 rounded-xl font-medium transition-all {{ $selectedSection === 'all' ? 'bg-brand-primary text-white shadow-xs' : 'bg-white text-neutral-600 border border-neutral-100' }}"
                        >
                            All Services
                        </button>
                        @foreach($sections as $section)
                            <button
                                wire:click="$set('selectedSection', {{ $section->id }})"
                                class="text-xs px-4 py-2.5 shrink-0 rounded-xl font-medium transition-all {{ $selectedSection == $section->id ? 'bg-brand-primary text-white shadow-xs' : 'bg-white text-neutral-600 border border-neutral-100' }}"
                            >
                                {{ $section->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Services Grid Element -->
                <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
                    @forelse($products as $product)
                        <div
                            wire:key="service-{{ $product->id }}"
                            class="group rounded-2xl overflow-hidden flex flex-col justify-between relative h-full bg-white border border-neutral-200/50 hover:border-brand-primary transition-all duration-300 shadow-2xs"
                        >
                            <div class="relative aspect-[4/5] bg-neutral-50 flex items-center justify-center border-b border-neutral-100 overflow-hidden">
                                @if($product->primary_image_url)
                                    <img
                                        src="{{ $product->primary_image_url }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-neutral-100/60">
                                        <i class="fa-regular fa-id-card text-2xl sm:text-4xl text-neutral-300"></i>
                                    </div>
                                @endif

                                <!-- Hover Overlay Info Frame Screen Links -->
                                <div class="absolute inset-0 bg-neutral-950/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden sm:flex items-center justify-center backdrop-blur-xs">
                                    <button
                                        wire:click="quickView({{ $product->id }})"
                                        class="bg-white text-neutral-900 text-xs font-semibold px-5 py-3 rounded-xl shadow-xl hover:bg-brand-primary hover:text-white transition-all transform translate-y-2 group-hover:translate-y-0 duration-500 cursor-pointer"
                                    >
                                        View Details
                                    </button>
                                </div>

                                <button
                                    wire:click="quickView({{ $product->id }})"
                                    class="absolute inset-0 w-full h-full sm:hidden focus:outline-none cursor-pointer"
                                    title="Quick view service details"
                                ></button>

                                @if($product->discount_price || $product->sale_status)
                                    <div class="absolute top-2 left-2 sm:top-4 sm:left-4 bg-brand-primary text-white text-[8px] sm:text-[9px] font-bold tracking-widest uppercase px-2.5 py-1.5 rounded-lg shadow-xs z-10">
                                        Offer
                                    </div>
                                @endif
                            </div>

                            <!-- Service Text Body -->
                            <div class="p-4 sm:p-5 space-y-3 sm:space-y-4 flex-1 flex flex-col justify-between bg-white">
                                <div class="space-y-1">
                                    <span class="text-[8px] sm:text-[10px] uppercase font-bold tracking-wider text-brand-primary">
                                        {{ $product->section->name ?? 'Specialty Service' }}
                                    </span>
                                    <h3 class="text-xs sm:text-sm font-medium text-neutral-800 line-clamp-1 group-hover:text-brand-primary transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                </div>

                                <div class="flex items-center justify-between pt-2 border-t border-neutral-100 gap-1">
                                    <div class="flex flex-wrap items-baseline gap-1.5">
                                        @if($product->sale_status)
                                            <span class="text-sm sm:text-base font-semibold text-neutral-900">₦{{ number_format($product->sales_price) }}</span>
                                            <span class="text-[10px] sm:text-xs text-neutral-400 line-through">₦{{ number_format($product->price) }}</span>
                                        @else
                                            <span class="text-sm sm:text-base font-semibold text-neutral-900">₦{{ number_format($product->price) }}</span>
                                        @endif
                                    </div>

                                    <div class="relative shrink-0">
                                        <div class="flex gap-1.5">
                                            <!-- maps to addToCart logic, repurposed visually for reserving / scheduling selection -->
                                            <button
                                                wire:click="addToCart({{ $product->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="addToCart({{ $product->id }})"
                                                class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-neutral-50 hover:bg-brand-primary border border-neutral-200/70 hover:border-brand-primary text-neutral-700 hover:text-white flex items-center justify-center transition-all duration-300 cursor-pointer"
                                                title="Book service slot"
                                            >
                                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                                    <i class="fa-regular fa-calendar-plus text-[10px] sm:text-xs"></i>
                                                </span>
                                                <span wire:loading wire:target="addToCart({{ $product->id }})">
                                                    <i class="fa-solid fa-spinner animate-spin text-[10px] sm:text-xs"></i>
                                                </span>
                                            </button>

                                            <button
                                                wire:click="addToWishlist({{ $product->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="addToWishlist({{ $product->id }})"
                                                class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-neutral-50 hover:bg-brand-primary border border-neutral-200/70 hover:border-brand-primary text-neutral-700 hover:text-white flex items-center justify-center transition-all duration-300 cursor-pointer"
                                                title="Save to interested services"
                                            >
                                                <span wire:loading.remove wire:target="addToWishlist({{ $product->id }})">
                                                    <i class="fa-regular fa-bookmark text-[10px] sm:text-xs"></i>
                                                </span>
                                                <span wire:loading wire:target="addToWishlist({{ $product->id }})">
                                                    <i class="fa-solid fa-spinner animate-spin text-[10px] sm:text-xs"></i>
                                                </span>
                                            </button>
                                        </div>

                                        @if($addedToCart === $product->id)
                                            <div class="absolute -top-8 -right-1 bg-emerald-600 text-white w-5 h-5 rounded-full shadow-md flex items-center justify-center animate-bounce z-10">
                                                <i class="fa-solid fa-check text-[8px]"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-neutral-100 shadow-2xs">
                            <div class="max-w-xs mx-auto space-y-4">
                                <div class="w-14 h-14 bg-neutral-50 rounded-full flex items-center justify-center mx-auto border border-neutral-100 text-neutral-400">
                                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                                </div>
                                <h3 class="text-base font-medium text-neutral-900">No services found</h3>
                                <p class="text-xs text-neutral-400 font-light">
                                    Adjust your search filters or browse alternative dynamic categories.
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Nav Links -->
                <div class="pt-6">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Core Service Pillars Info Banner Box -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-32">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 bg-[var(--secondary)] p-8 rounded-[2.5em] border border-neutral-200/40 shadow-xs">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 text-brand-primary shadow-3xs">
                    <i class="fa-solid fa-user-tie text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Certified Experts</h4>
                    <p class="text-xs text-neutral-500 mt-0.5 font-light">Vetted specialist care practitioners</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 text-brand-primary shadow-3xs">
                    <i class="fa-solid fa-calendar-check text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Flexible Booking</h4>
                    <p class="text-xs text-neutral-500 mt-0.5 font-light">Seamlessly modify schedules online</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 text-brand-primary shadow-3xs">
                    <i class="fa-solid fa-handshake-angle text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Bespoke Sessions</h4>
                    <p class="text-xs text-neutral-500 mt-0.5 font-light">Tailored accurately to dynamic preferences</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 text-brand-primary shadow-3xs">
                    <i class="fa-solid fa-shield-halved text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Secure Experience</h4>
                    <p class="text-xs text-neutral-500 mt-0.5 font-light">100% data and consultation privacy guaranteed</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Overlay Dialog Node Module Modal -->
    @if($showQuickView && $quickViewProduct)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            x-data="{ activePreview: '{{ $quickViewProduct->primary_image_url }}' }"
            x-show="$wire.showQuickView"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="$wire.closeQuickView()"
        >
            <div class="absolute inset-0 bg-neutral-950/40 backdrop-blur-md" @click="$wire.closeQuickView()"></div>

            <div class="relative bg-white rounded-[2em] max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-neutral-100 z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-10">

                    <div class="space-y-4">
                        <div class="aspect-square bg-neutral-50 rounded-2xl overflow-hidden p-6 flex items-center justify-center border border-neutral-200/60 relative">
                            <img :src="activePreview" alt="{{ $quickViewProduct->name }}" class="w-full h-full object-contain mix-blend-multiply transition-all duration-300">

                            @if($quickViewProduct->sale_status)
                                <div class="absolute top-4 left-4 bg-brand-primary text-white text-[9px] font-bold tracking-widest uppercase px-3 py-1.5 rounded-md shadow-xs">
                                    Special Offer
                                </div>
                            @endif
                        </div>

                        @if($quickViewProduct->images->isNotEmpty())
                            <div class="flex gap-2.5 overflow-x-auto pb-1 no-scrollbar">
                                @foreach($quickViewProduct->images as $index => $extraImg)
                                    @php $imageAssetPath = asset('storage/' . $extraImg->image_path); @endphp
                                    <button
                                        type="button"
                                        @click="activePreview = '{{ $imageAssetPath }}'"
                                        class="w-16 h-16 rounded-xl border-2 p-1 bg-white shrink-0 overflow-hidden transition-all cursor-pointer"
                                        :class="activePreview === '{{ $imageAssetPath }}' ? 'border-brand-primary ring-1 ring-brand-primary' : 'border-neutral-200 hover:border-neutral-400'"
                                    >
                                        <img src="{{ $imageAssetPath }}" alt="Thumbnail link {{ $index }}" class="w-full h-full object-cover mix-blend-multiply rounded-md">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col justify-between py-2">
                        <div class="space-y-4">
                            <div>
                                <span class="text-[10px] uppercase font-bold tracking-widest text-brand-primary">
                                    {{ $quickViewProduct->section->name ?? 'Specialty Service' }}
                                </span>
                                <h2 class="text-2xl sm:text-3xl font-light text-neutral-900 tracking-tight serif-display mt-1">
                                    {{ $quickViewProduct->name }}
                                </h2>
                            </div>

                            <div class="flex items-center gap-3">
                                @if($quickViewProduct->sale_status)
                                    <span class="text-2xl font-semibold text-neutral-900">₦{{ number_format($quickViewProduct->sales_price) }}</span>
                                    <span class="text-sm text-neutral-400 line-through">₦{{ number_format($quickViewProduct->price) }}</span>
                                    <span class="bg-[var(--secondary)] text-brand-primary border border-brand-primary/20 text-[10px] font-bold px-2.5 py-1 rounded-md">-{{ $quickViewProduct->discount_percentage }}%</span>
                                @else
                                    <span class="text-2xl font-semibold text-neutral-900">₦{{ number_format($quickViewProduct->price) }}</span>
                                @endif
                            </div>

                            <p class="text-xs text-neutral-500 font-light leading-relaxed">{{ $quickViewProduct->description }}</p>

                            <div class="pt-2">
                                <!-- stock variable maps natively to appointment opening/availability layout thresholds -->
                                @if($quickViewProduct->stock > 0)
                                    <span class="inline-flex items-center gap-2 text-emerald-700 bg-emerald-50 text-[11px] font-medium px-3 py-1.5 rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                        Available Booking Status ({{ $quickViewProduct->stock }} slots open)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 text-rose-600 bg-rose-50 text-[11px] font-medium px-3 py-1.5 rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                        Fully Booked / Unavailable Currently
                                    </span>
                                @endif
                            </div>

                            @if($quickViewProduct->options)
                                <div class="space-y-3 pt-2">
                                    @foreach($quickViewProduct->options as $optionName => $values)
                                        <!-- Keeps customized session options (like duration, location tier, tier type) fully dynamic -->
                                        <div>
                                            <label class="text-[10px] font-bold uppercase tracking-wider text-neutral-400 block mb-1.5">{{ $optionName }}</label>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($values as $value)
                                                    <span class="text-xs px-3 py-1.5 bg-neutral-50 border border-neutral-200 text-neutral-700 rounded-lg font-medium">
                                                        {{ $value }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Main Modal Wire Action Buttons Segment Container -->
                        <div class="pt-6 mt-6 border-t border-neutral-100 flex items-center gap-3">
                            <button
                                wire:click="addToCart({{ $quickViewProduct->id }})"
                                class="flex-1 bg-neutral-950 text-white text-xs font-medium tracking-widest uppercase py-4 rounded-xl hover:bg-brand-primary transition-colors cursor-pointer text-center"
                            >
                                Schedule Appointment
                            </button>

                            <button
                                wire:click="addToWishlist({{ $quickViewProduct->id }})"
                                class="w-12 h-12 rounded-xl bg-neutral-50 hover:bg-brand-primary border border-neutral-200 hover:border-brand-primary text-neutral-600 hover:text-white flex items-center justify-center transition-colors cursor-pointer"
                                title="Bookmark Session"
                            >
                                <i class="fa-regular fa-bookmark text-sm"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif

</div>
