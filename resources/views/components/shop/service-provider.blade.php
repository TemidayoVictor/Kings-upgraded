<div class="pb-20 bg-[var(--surface)]">

    {{-- ==================== BRAND ACCENT SYSTEM ==================== --}}
    <style>
        /* Gradient accent bar — primary to secondary */
        .brand-accent-bar {
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
        }

        /* Safe "brand fill" — darkened mix so white text stays readable */
        .brand-sale-badge {
            background: color-mix(in srgb, var(--primary) 85%, #000 15%);
            color: #ffffff;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
        }

        /* Hover fill using brand primary — for buttons */
        .hover-brand-primary {
            transition: background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-brand-primary:hover {
            background-color: color-mix(in srgb, var(--primary) 85%, #000 15%);
            color: #ffffff;
            box-shadow: 0 4px 14px color-mix(in srgb, var(--primary) 30%, transparent);
        }

        /* Brand-tinted hover glow for product cards */
        .brand-card-hover-glow {
            transition: box-shadow 0.35s ease, transform 0.35s ease;
        }
        .brand-card-hover-glow:hover {
            box-shadow: 0 10px 30px -12px color-mix(in srgb, var(--primary) 35%, transparent);
        }
    </style>

    {{-- ==================== SERVICE PROVIDER MASTHEAD ==================== --}}
    <section class="relative w-full overflow-hidden bg-[var(--surface-low)] px-4 py-12 sm:px-8 sm:py-16">

        {{-- Subtle decorative accents --}}
        <div class="pointer-events-none absolute -top-24 -right-20 h-64 w-64 rounded-full opacity-[0.07] blur-3xl"
             style="background: var(--primary);"></div>

        <div class="pointer-events-none absolute -bottom-24 -left-20 h-64 w-64 rounded-full opacity-[0.07] blur-3xl"
             style="background: var(--secondary);"></div>

        <div class="relative mx-auto flex max-w-7xl flex-col items-center text-center">

            {{-- Provider identity --}}
            <div class="mb-5 inline-flex max-w-full items-center gap-2 rounded-full bg-[var(--surface)] px-4 py-2 shadow-sm">
            <span class="h-1.5 w-1.5 shrink-0 rounded-full"
                  style="background: var(--secondary);"></span>

                <span class="truncate text-[10px] font-semibold uppercase tracking-[0.18em] text-[var(--on-surface-variant)]">
                {{ $brand->brand_name }} · Service Provider
            </span>
            </div>

            {{-- Main heading --}}
            <h1 class="mb-4 max-w-4xl font-editorial text-3xl uppercase leading-tight tracking-tight text-[var(--on-surface)] sm:text-4xl lg:text-5xl">
                Discover Our Services
            </h1>

            {{-- Description --}}
            @if($brand->description)
                <p class="mb-7 max-w-2xl text-sm font-light leading-relaxed text-[var(--on-surface-variant)] sm:text-base">
                    {{ strip_tags($brand->description) }}
                </p>
            @else
                <p class="mb-7 max-w-2xl text-sm font-light leading-relaxed text-[var(--on-surface-variant)] sm:text-base">
                    Explore our range of professional services and find the right solution for your needs.
                    We're here to help you get started.
                </p>
            @endif

            {{-- Service assurance --}}
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3">

                <div class="inline-flex items-center gap-2 rounded-full bg-[var(--surface)] px-4 py-2.5 shadow-sm">
                    <i class="fa-solid fa-handshake text-xs" style="color: var(--secondary);"></i>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-[var(--on-surface)]">
                    Professional Service
                </span>
                </div>

                <div class="inline-flex items-center gap-2 rounded-full bg-[var(--surface)] px-4 py-2.5 shadow-sm">
                    <i class="fa-solid fa-calendar-check text-xs" style="color: var(--secondary);"></i>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-[var(--on-surface)]">
                    Easy Enquiries
                </span>
                </div>

            </div>

        </div>
    </section>

    {{-- Filters + grid --}}
    <section id="services-grid" class="w-full max-w-7xl mx-auto px-4 sm:px-8 pt-12 pb-12">

        {{-- Search --}}
        <div class="w-full mb-6">
            <div class="relative w-full max-w-3xl mx-auto">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[var(--outline)] text-sm"></i>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search treatments, sessions, or services..."
                    class="w-full bg-white text-[var(--on-surface)] placeholder:text-[var(--outline)] pl-12 pr-10 py-3.5 rounded-full text-sm shadow-sm focus:outline-none border border-[var(--outline-variant)]/30 focus:border-[var(--on-surface)] transition-colors"
                >
            </div>
        </div>

        {{-- Category pills + sort --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-4">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-2 lg:pb-0">
                <button
                    wire:click="$set('selectedSection', 'all')"
                    class="px-4 py-2 rounded-full text-[10px] uppercase tracking-wider whitespace-nowrap transition-all font-semibold {{ $selectedSection === 'all' ? 'bg-[var(--on-surface)] text-white shadow-sm' : 'bg-[var(--surface-container)] text-[var(--on-surface-variant)] hover:bg-[var(--surface-high)]' }}"
                >
                    All Services
                </button>
                @foreach($sections as $section)
                    <button
                        wire:click="$set('selectedSection', {{ $section->id }})"
                        class="px-4 py-2 rounded-full text-[10px] uppercase tracking-wider whitespace-nowrap transition-all font-semibold {{ $selectedSection == $section->id ? 'bg-[var(--on-surface)] text-white shadow-sm' : 'bg-[var(--surface-container)] text-[var(--on-surface-variant)] hover:bg-[var(--surface-high)]' }}"
                    >
                        {{ $section->name }} ({{ $section->products_count }})
                    </button>
                @endforeach
            </div>

            <div class="flex items-center justify-between sm:justify-end gap-4">
                <div class="relative inline-flex items-center">
                    <span class="text-[10px] tracking-wider uppercase text-[var(--outline)] mr-2 font-semibold">Sort:</span>
                    <select
                        wire:model.live="sortBy"
                        class="bg-[var(--surface-container)] text-[var(--on-surface)] text-sm px-3 py-1.5 rounded-lg focus:outline-none cursor-pointer"
                    >
                        <option value="newest">Newly Listed</option>
                        <option value="price_low">Rate: Low to High</option>
                        <option value="price_high">Rate: High to Low</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Price range strip + Reset --}}
        <div class="mb-6 bg-[var(--surface-container)]/60 px-4 py-3 rounded-lg flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-[10px] uppercase tracking-widest text-[var(--outline)] font-semibold">Rate Range:</span>
                <div class="flex items-center gap-2">
                    <span class="text-xs px-2 py-1 bg-white rounded border border-[var(--outline-variant)]/30">₦{{ number_format($priceRange[0]) }}</span>
                    <span class="text-xs text-[var(--outline)]">—</span>
                    <span class="text-xs px-2 py-1 bg-white rounded border border-[var(--outline-variant)]/30">₦{{ number_format($priceRange[1]) }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <input type="range"
                           wire:model.live="priceRange.0"
                           min="{{ $minPrice }}" max="{{ $maxPrice }}"
                           class="w-24 accent-[var(--on-surface)] cursor-pointer">
                    <input type="range"
                           wire:model.live="priceRange.1"
                           min="{{ $minPrice }}" max="{{ $maxPrice }}"
                           class="w-24 accent-[var(--on-surface)] cursor-pointer">
                </div>
            </div>
            <a href="{{ route('shop', $brand) }}" wire:navigate
               class="text-[10px] uppercase tracking-wider font-semibold text-[var(--secondary)] hover:underline">
                Reset All
            </a>
        </div>

        {{-- Services grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($products as $product)
                <article
                    wire:key="service-{{ $product->id }}"
                    class="group flex flex-col bg-[var(--surface)] rounded-xl overflow-hidden hover:shadow-md transition-all duration-300"
                >
                    <div class="relative aspect-[3/4] w-full overflow-hidden bg-[var(--surface-high)]">
                        @if($product->primary_image_url)
                            <img src="{{ $product->primary_image_url }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-[var(--surface-high)]">
                                <i class="fa-regular fa-id-card text-2xl text-[var(--outline)]"></i>
                            </div>
                        @endif

                        @if($product->discount_price || $product->sale_status)
                            <div class="absolute top-3 left-3">
                                <span class="bg-[var(--on-surface)] text-white text-[9px] font-semibold tracking-wider uppercase px-2.5 py-1 rounded-full shadow-sm">
                                    Offer
                                </span>
                            </div>
                        @endif

                        {{-- Save to interested services --}}
                        <button
                            wire:click="addToWishlist({{ $product->id }})"
                            wire:loading.attr="disabled"
                            wire:target="addToWishlist({{ $product->id }})"
                            aria-label="Save to interested services"
                            class="absolute top-3 right-3 w-8 h-8 rounded-full bg-[var(--surface)]/90 backdrop-blur-md flex items-center justify-center text-[var(--on-surface)] hover:text-[var(--secondary)] transition-colors"
                        >
                            <span wire:loading.remove wire:target="addToWishlist({{ $product->id }})"><i class="fa-regular fa-bookmark text-sm"></i></span>
                            <span wire:loading wire:target="addToWishlist({{ $product->id }})"><i class="fa-solid fa-spinner animate-spin text-sm"></i></span>
                        </button>

                        {{-- Quick view (desktop flyout) --}}
                        <div class="absolute inset-x-3 bottom-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden sm:block">
                            <button
                                wire:click="quickView({{ $product->id }})"
                                class="w-full bg-[var(--on-surface)] text-white py-3 rounded-lg text-[10px] uppercase tracking-widest hover:bg-[var(--secondary)] transition-all flex items-center justify-center gap-2"
                            >
                                <i class="fa-solid fa-eye text-xs"></i>
                                <span>View Details</span>
                            </button>
                        </div>

                        {{-- Mobile: tap to quick view --}}
                        <button
                            wire:click="quickView({{ $product->id }})"
                            class="absolute inset-0 w-full h-full sm:hidden focus:outline-none"
                            title="View service details"
                        ></button>
                    </div>

                    <div class="p-4 sm:p-5 flex flex-col flex-1 justify-between gap-3">
                        <div>
                            <span class="text-[9px] uppercase tracking-[0.2em] text-[var(--outline)] block mb-1">
                                {{ $product->section->name ?? 'Specialty Service' }}
                            </span>
                            <h3 class="text-sm text-[var(--on-surface)] font-medium leading-snug line-clamp-2 group-hover:text-[var(--secondary)] transition-colors">
                                {{ $product->name }}
                            </h3>
                        </div>

                        <div class="flex items-baseline justify-between pt-1 gap-2">
                            <div class="flex items-baseline gap-1.5 flex-wrap">
                                @if($product->sale_status)
                                    <span class="text-sm sm:text-base font-semibold text-[var(--on-surface)]">₦{{ number_format($product->sales_price) }}</span>
                                    <span class="text-[11px] text-[var(--outline)] line-through">₦{{ number_format($product->price) }}</span>
                                @else
                                    <span class="text-sm sm:text-base font-semibold text-[var(--on-surface)]">₦{{ number_format($product->price) }}</span>
                                @endif
                            </div>

                            <button
                                wire:click="addToCart({{ $product->id }})"
                                wire:loading.attr="disabled"
                                wire:target="addToCart({{ $product->id }})"
                                title="Book service slot"
                                class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[var(--surface-lowest)] text-[var(--on-surface)] flex items-center justify-center shadow-md hover:bg-[var(--on-surface)] hover:text-white active:scale-95 transition-all shrink-0"
                            >
                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})"><i class="fa-regular fa-calendar-plus text-xs"></i></span>
                                <span wire:loading wire:target="addToCart({{ $product->id }})"><i class="fa-solid fa-spinner animate-spin text-xs"></i></span>
                            </button>
                        </div>

                        @if($addedToCart === $product->id)
                            <div class="text-[10px] text-emerald-600 font-semibold uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-check"></i> Slot Reserved
                            </div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="col-span-full py-20 text-center bg-[var(--surface-lowest)] rounded-3xl border border-[var(--outline-variant)]/30">
                    <div class="max-w-xs mx-auto space-y-4">
                        <div class="w-14 h-14 bg-[var(--surface-low)] rounded-full flex items-center justify-center mx-auto border border-[var(--outline-variant)]/30 text-[var(--outline)]">
                            <i class="fa-solid fa-magnifying-glass text-lg"></i>
                        </div>
                        <h3 class="text-base font-medium text-[var(--on-surface)]">No services found</h3>
                        <p class="text-xs text-[var(--outline)]">Adjust your filters or try a different search.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </section>

    {{-- Service pillars strip --}}
    <section class="w-full bg-[var(--surface-high)] py-12 px-4 sm:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                ['fa-user-tie', 'Certified Experts', 'Vetted specialist care practitioners'],
                ['fa-calendar-check', 'Flexible Booking', 'Seamlessly modify schedules online'],
                ['fa-handshake-angle', 'Bespoke Sessions', 'Tailored to your preferences'],
                ['fa-shield-halved', 'Secure Experience', '100% data and consultation privacy'],
            ] as [$icon, $title, $copy])
                <div class="flex items-center gap-3 p-5 bg-[var(--surface)] rounded-xl shadow-xs">
                    <div class="w-11 h-11 rounded-2xl bg-[var(--secondary-container)]/60 text-[var(--secondary)] flex items-center justify-center shrink-0">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold uppercase tracking-wider text-[var(--on-surface)]">{{ $title }}</h4>
                        <p class="text-[11px] text-[var(--on-surface-variant)] font-light leading-relaxed mt-0.5">{{ $copy }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Quick View modal --}}
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
            <div class="absolute inset-0 bg-black/40 backdrop-blur-md" @click="$wire.closeQuickView()"></div>

            <div class="relative bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-[var(--outline-variant)]/30 z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 sm:p-10">

                    {{-- Gallery --}}
                    <div class="space-y-4">
                        <div class="aspect-square bg-[var(--surface-low)] rounded-xl overflow-hidden p-6 flex items-center justify-center border border-[var(--outline-variant)]/30 relative">
                            <img :src="activePreview" alt="{{ $quickViewProduct->name }}"
                                 class="w-full h-full object-contain mix-blend-multiply">
                            @if($quickViewProduct->sale_status)
                                <div class="absolute top-4 left-4 bg-[var(--on-surface)] text-white text-[9px] font-semibold tracking-widest uppercase px-3 py-1.5 rounded-md">
                                    Special Offer
                                </div>
                            @endif
                        </div>

                        @if($quickViewProduct->images->isNotEmpty())
                            <div class="flex gap-2.5 overflow-x-auto no-scrollbar">
                                @foreach($quickViewProduct->images as $extraImg)
                                    @php $imageAssetPath = asset('storage/' . $extraImg->image_path); @endphp
                                    <button type="button"
                                            @click="activePreview = '{{ $imageAssetPath }}'"
                                            class="w-16 h-16 rounded-lg border-2 p-1 bg-white shrink-0 overflow-hidden transition-all"
                                            :class="activePreview === '{{ $imageAssetPath }}' ? 'border-[var(--on-surface)]' : 'border-[var(--outline-variant)]/30 hover:border-[var(--outline-variant)]'">
                                        <img src="{{ $imageAssetPath }}" alt=""
                                             class="w-full h-full object-cover mix-blend-multiply rounded">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="flex flex-col justify-between py-2">
                        <div class="space-y-4">
                            <div>
                                <span class="text-[10px] uppercase font-bold tracking-widest text-[var(--secondary)]">
                                    {{ $quickViewProduct->section->name ?? 'Specialty Service' }}
                                </span>
                                <h2 class="font-editorial text-2xl sm:text-3xl text-[var(--on-surface)] tracking-tight mt-1">
                                    {{ $quickViewProduct->name }}
                                </h2>
                            </div>

                            <div class="flex items-center gap-3">
                                @if($quickViewProduct->sale_status)
                                    <span class="text-2xl font-semibold text-[var(--on-surface)]">₦{{ number_format($quickViewProduct->sales_price) }}</span>
                                    <span class="text-sm text-[var(--outline)] line-through">₦{{ number_format($quickViewProduct->price) }}</span>
                                @else
                                    <span class="text-2xl font-semibold text-[var(--on-surface)]">₦{{ number_format($quickViewProduct->price) }}</span>
                                @endif
                            </div>

                            <p class="text-xs text-[var(--on-surface-variant)] font-light leading-relaxed">
                                {{ $quickViewProduct->description }}
                            </p>

                            <div class="pt-2">
                                @if($quickViewProduct->stock > 0)
                                    <span class="inline-flex items-center gap-2 text-emerald-700 bg-emerald-50 text-[11px] font-medium px-3 py-1.5 rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                        Available Booking Status ({{ $quickViewProduct->stock }} slots open)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 text-rose-600 bg-rose-50 text-[11px] font-medium px-3 py-1.5 rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                        Fully Booked / Unavailable
                                    </span>
                                @endif
                            </div>

                            @if($quickViewProduct->options)
                                <div class="space-y-3 pt-2">
                                    @foreach($quickViewProduct->options as $optionName => $values)
                                        <div>
                                            <label class="block text-[10px] font-bold text-[var(--outline)] uppercase tracking-wider mb-2">{{ $optionName }}</label>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($values as $value)
                                                    <span class="text-xs px-3 py-1.5 bg-[var(--surface-low)] border border-[var(--outline-variant)]/40 text-[var(--on-surface)] rounded-lg font-medium">
                                                        {{ $value }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="pt-6 mt-6 border-t border-[var(--outline-variant)]/30 flex items-center gap-3">
                            <button
                                wire:click="addToCart({{ $quickViewProduct->id }})"
                                wire:loading.attr="disabled"
                                class="flex-1 bg-[var(--on-surface)] text-white text-xs font-medium tracking-widest uppercase py-4 rounded-xl hover:bg-[var(--secondary)] transition-colors flex items-center justify-center gap-2"
                            >
                                <span wire:loading.remove wire:target="addToCart({{ $quickViewProduct->id }})">Schedule Appointment</span>
                                <span wire:loading wire:target="addToCart({{ $quickViewProduct->id }})">Scheduling...</span>
                                <i class="fa-regular fa-calendar-plus text-xs"></i>
                            </button>

                            <button
                                wire:click="addToWishlist({{ $quickViewProduct->id }})"
                                class="w-12 h-12 rounded-xl bg-[var(--surface-lowest)] border border-[var(--outline-variant)]/40 text-[var(--on-surface)] hover:bg-[var(--on-surface)] hover:text-white transition-colors flex items-center justify-center"
                                title="Save to interested services"
                            >
                                <i class="fa-regular fa-bookmark text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button wire:click="closeQuickView"
                        class="absolute top-5 right-5 text-[var(--outline)] hover:text-[var(--on-surface)] w-10 h-10 rounded-full flex items-center justify-center hover:bg-[var(--surface-low)]">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        </div>
    @endif
</div>
