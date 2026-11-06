<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Shop' }} | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $brand->image) }}">

    @vite(['resources/css/app.css'])
    @fluxAppearance
    @livewireStyles

    <style>
        :root {
            --primary: {{ $brand->brandSetting->primary_color ?? '#0a0a0a' }};
            --secondary: {{ $brand->brandSetting->secondary_color ?? '#785928' }};
            --surface: #f9f9f7;
            --surface-lowest: #ffffff;
            --surface-low: #f4f4f2;
            --surface-container: #eeeeec;
            --surface-high: #e8e8e6;
            --on-surface: #1a1c1b;
            --on-surface-variant: #4b4640;
            --on-primary: #ffffff;
            --outline: #7c766f;
            --outline-variant: #cdc5bd;
            --secondary-container: #fed397;
            --on-secondary-container: #785a29;
        }
        html, body { margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--surface);
            color: var(--on-surface);
            overscroll-behavior: none;
            -webkit-font-smoothing: antialiased;
        }
        .font-editorial { font-family: 'Bodoni Moda', serif; }
        ::-webkit-scrollbar { display: none; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body>

<header class="fixed top-0 left-0 right-0 z-50 bg-[var(--surface)]/90 backdrop-blur-md shadow-[0_1px_8px_rgba(0,0,0,0.03)]"
        x-data="{ mobileMenuOpen: false }">

    {{-- Announcement bar --}}
    <div class="bg-[var(--surface-low)] px-4 sm:px-8 py-2 border-b border-[var(--outline-variant)]/20">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 text-[10px] uppercase tracking-[0.22em] font-semibold">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 text-[var(--on-secondary-container)] tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-[var(--secondary)]"></span>
                    King's Verified Merchant
                </span>
            </div>
            <div class="hidden md:block truncate text-center text-[var(--on-surface)] tracking-widest uppercase font-medium">
{{--                Complimentary Courier Across Lagos--}}
            </div>
            <div class="flex items-center gap-4 text-[var(--on-surface-variant)]">
                <span class="font-semibold text-[var(--on-surface)]">NGN (₦)</span>
            </div>
        </div>
    </div>

    {{-- Main header --}}
    <div class="h-20 w-full px-4 sm:px-8">
        <div class="max-w-7xl h-full mx-auto flex items-center justify-between gap-4">

            <a href="{{ route('shop', $brand) }}" class="flex items-center gap-3 group min-w-0">
                @if($brand->image)
                    <img src="{{ asset('storage/' . $brand->image) }}"
                         alt="{{ $brand->brand_name }}"
                         class="h-8 w-auto object-contain shrink-0">
                @endif
                <div class="flex flex-col min-w-0">
                    <span class="font-editorial text-base sm:text-xl uppercase tracking-widest text-[var(--on-surface)] leading-none truncate group-hover:opacity-80 transition-opacity">
                        {{ $brand->brand_name }}
                    </span>
                    <span class="text-[9px] tracking-[0.24em] text-[var(--on-surface-variant)] uppercase mt-1 truncate">
                        Est. {{ $brand->created_at?->format('Y') ?? date('Y') }}
                    </span>
                </div>
            </a>

            @php
                // Builds the class string for a nav link based on the current route
                $navLinkClass = function (array $routes) {
                    $active = request()->routeIs(...$routes);
                    return $active
                        ? 'uppercase tracking-[0.2em] py-2 text-[12px] font-semibold text-[var(--on-surface)] border-b border-[var(--on-surface)]'
                        : 'uppercase tracking-[0.2em] py-2 text-[12px] font-semibold text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors';
                };
            @endphp

            <nav class="hidden md:flex items-center gap-8 lg:gap-10">
                <a href="{{ route('shop', $brand) }}"
                   class="{{ $navLinkClass(['shop', 'cart', 'checkout']) }}">Shop</a>

                <a href="{{ route('catalog', $brand) }}"
                   class="{{ $navLinkClass(['catalog']) }}">Catalog</a>

                <a href="{{ route('shop.about', $brand) }}"
                   class="{{ $navLinkClass(['shop.about']) }}">About Us</a>

                @auth
                    <a href="{{ route('shop.orders', $brand) }}"
                       class="{{ $navLinkClass(['shop.orders']) }}">My Orders</a>
                @endauth

                <a href="{{ route('shop.ratings', $brand) }}"
                   class="{{ $navLinkClass(['shop.ratings']) }}">Reviews</a>
            </nav>

            <div class="flex items-center gap-3 sm:gap-5">
                <a href="{{ route('wishlist') }}" aria-label="Wishlist"
                   class="text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors flex items-center">
                    <i class="fa-regular fa-heart text-lg"></i>
                </a>

                <a href="{{ route('cart', ['brand' => $brand->slug]) }}" aria-label="Cart"
                   class="relative text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors flex items-center">
                    <i class="fa-solid fa-bag-shopping text-lg"></i>
                    <span x-data="{ count: 0 }"
                          x-on:cart-updated.window="count = $event.detail.count"
                          x-show="count > 0" x-transition x-cloak
                          class="absolute -top-1.5 -right-2 bg-[var(--on-surface)] text-[var(--on-primary)] text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                        <span x-text="count"></span>
                    </span>
                </a>

                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="flex items-center focus:outline-none cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-[var(--on-surface)] border border-white flex items-center justify-center shadow-xs">
                                <span class="text-xs font-semibold text-white uppercase">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition x-cloak
                             class="absolute right-0 mt-3 w-52 bg-white rounded-lg shadow-xl border border-[var(--outline-variant)]/40 py-2 z-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="block w-full text-left px-5 py-2.5 text-xs font-medium text-rose-600 hover:bg-rose-50/50 cursor-pointer">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="text-[11px] font-semibold tracking-[0.2em] uppercase text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors">
                        Login
                    </a>
                @endauth

                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" aria-label="Toggle menu"
                        class="md:hidden inline-flex items-center justify-center w-10 h-10 text-[var(--on-surface)] focus:outline-none cursor-pointer">
                    <i class="fa-solid fa-bars-staggered text-lg" x-show="!mobileMenuOpen"></i>
                    <i class="fa-solid fa-xmark text-lg" x-show="mobileMenuOpen" x-cloak></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileMenuOpen" x-transition @click.away="mobileMenuOpen = false" x-cloak
         class="md:hidden bg-[var(--surface-lowest)] border-t border-[var(--outline-variant)]/20 absolute top-full left-0 w-full z-50 shadow-xl">
        @php
            $mobileNavClass = function (array $routes) {
                $active = request()->routeIs(...$routes);
                return $active
                    ? 'py-2.5 block pl-3 border-l-2 border-[var(--on-surface)] text-[var(--on-surface)] font-bold'
                    : 'py-2.5 block pl-3 border-l-2 border-transparent text-[var(--on-surface-variant)] hover:text-[var(--secondary)] transition-colors';
            };
        @endphp

        <nav class="px-6 py-6 flex flex-col gap-4 text-xs font-semibold uppercase tracking-widest">
            <a href="{{ route('shop', $brand) }}" @click="mobileMenuOpen = false"
               class="{{ $mobileNavClass(['shop', 'cart', 'checkout']) }}">Shop</a>

            <a href="{{ route('catalog', $brand) }}" @click="mobileMenuOpen = false"
               class="{{ $mobileNavClass(['shop.catalog']) }}">Catalog</a>

            <a href="{{ route('shop.about', $brand) }}" @click="mobileMenuOpen = false"
               class="{{ $mobileNavClass(['shop.about']) }}">About Us</a>

            @auth
                <a href="{{ route('shop.orders', $brand) }}" @click="mobileMenuOpen = false"
                   class="{{ $mobileNavClass(['shop.orders']) }}">My Orders</a>
            @endauth

            <a href="{{ route('shop.ratings', $brand) }}" @click="mobileMenuOpen = false"
               class="{{ $mobileNavClass(['shop.ratings']) }}">Reviews</a>
        </nav>
    </div>
</header>

<main class="w-full pt-28 min-h-screen">
    <x-toast position="top-right" duration="5000" />
    {{ $slot }}
</main>

<footer class="w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 pt-16 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 pb-16">

            {{-- Brand --}}
            <div class="md:col-span-4 space-y-4">
                <span class="font-editorial text-xl uppercase tracking-widest text-[var(--on-surface)] block">
                    {{ $brand->brand_name }}
                </span>

                <p class="text-sm text-[var(--on-surface-variant)] max-w-sm font-light leading-relaxed">
                    {{ $brand->motto || $brand->description
                        ? strip_tags($brand->motto ?? $brand->description)
                        : 'Discover products and services from ' . $brand->brand_name . '.' }}
                </p>

                @if($brand->instagram || $brand->facebook || $brand->twitter || $brand->youtube || $brand->tiktok || $brand->linkedin || $brand->website)
                    <div class="flex flex-wrap gap-2 pt-2">
                        @foreach([
                            'instagram' => 'fa-brands fa-instagram',
                            'facebook'  => 'fa-brands fa-facebook-f',
                            'twitter'   => 'fa-brands fa-x-twitter',
                            'youtube'   => 'fa-brands fa-youtube',
                            'tiktok'    => 'fa-brands fa-tiktok',
                            'linkedin'  => 'fa-brands fa-linkedin-in',
                            'website'   => 'fa-solid fa-globe',
                        ] as $field => $icon)
                            @if($brand->{$field})
                                <a href="{{ $brand->{$field} }}" target="_blank" rel="noopener noreferrer"
                                   aria-label="{{ ucfirst($field) }}"
                                   class="w-9 h-9 rounded-full bg-[var(--surface-lowest)] border border-[var(--outline-variant)]/30 flex items-center justify-center text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] hover:border-[var(--outline-variant)] transition-all active:scale-95">
                                    <i class="{{ $icon }} text-sm"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Shop --}}
            <div class="md:col-span-2 space-y-3">
                <h4 class="text-xs font-semibold uppercase tracking-widest text-[var(--on-surface)]">Shop</h4>
                <ul class="space-y-2.5 text-sm font-light">
                    <li><a href="{{ route('shop', $brand) }}" class="text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors">All Products</a></li>
                    <li><a href="{{ route('shop', $brand) }}" class="text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors">Categories</a></li>
                    <li><a href="{{ route('shop', $brand) }}" class="text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors">Featured Products</a></li>
                    <li><a href="{{ route('shop', $brand) }}" class="text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors">New Arrivals</a></li>
                </ul>
            </div>

            {{-- Information --}}
            <div class="md:col-span-2 space-y-3">
                <h4 class="text-xs font-semibold uppercase tracking-widest text-[var(--on-surface)]">Information</h4>
                <ul class="space-y-2.5 text-sm font-light">
                    <li><a href="{{ route('shop.about', $brand) }}" class="text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors">About Us</a></li>
                    <li><a href="#" class="text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors">Contact Us</a></li>
                    <li><a href="#" class="text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors">Shipping & Delivery</a></li>
                    <li><a href="#" class="text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] transition-colors">Returns & Exchanges</a></li>
                </ul>
            </div>

            {{-- Reviews --}}
            <div class="md:col-span-4 space-y-3">
                <h4 class="text-xs font-semibold uppercase tracking-widest text-[var(--on-surface)]">Reviews</h4>
                <p class="text-sm text-[var(--on-surface-variant)] font-light leading-relaxed">
                    See what customers are saying about {{ $brand->brand_name }}.
                </p>
                <a href="{{ route('shop.ratings', $brand) }}"
                   class="inline-block text-xs uppercase tracking-widest text-[var(--secondary)] hover:underline">
                    Read Reviews →
                </a>
            </div>
        </div>

        <div class="pt-8 border-t border-[var(--outline-variant)]/30 flex flex-col sm:flex-row items-center justify-between gap-4 text-[10px] uppercase tracking-widest text-[var(--on-surface-variant)]">
            <p>&copy; {{ date('Y') }} {{ $brand->brand_name }}. All rights reserved.</p>
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2">
                <a href="#" class="hover:text-[var(--on-surface)] transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-[var(--on-surface)] transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

@fluxScripts
@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>
