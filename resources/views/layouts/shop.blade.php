<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Shop' }} | {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500i|plus-jakarta-sans:300,400,500,600" rel="stylesheet" />

    <!-- Font Awesome (Using verified stable CDN for all free basic styles) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css'])

    @fluxAppearance
    @livewireStyles

    <style>
        :root {
            /* Fallback to original color theme styles if settings are unconfigured */
            --primary: {{ $brand->brandSetting->primary_color ?? '#b55a3b' }};
            --secondary: {{ $brand->brandSetting->secondary_color ?? '#e7dfd7' }};

            /* Build dynamic translucent overlays directly using hex-alpha matching */
            --primary-muted: {{ ($brand->brandSetting->primary_color ?? '#b55a3b') . '1A' }}; /* '1A' adds an implicit 10% opacity in hex */

            --surface: #fcfbfa;
            --text-main: #191615;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--surface);
            color: var(--text-main);
        }

        .serif-display {
            font-family: 'Playfair Display', serif;
        }

        /* Fluid Premium Elevation Styles */
        .card-smooth {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.03);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .card-smooth:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.05);
            border-color: var(--primary);
        }

        /* Clean custom scrollbar removal */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased selection:bg-[var(--primary)] selection:text-white">

<!-- Elegant Sticky Navigation Overlay -->
<header class="bg-white/70 backdrop-blur-xl sticky top-0 z-40 border-b border-neutral-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-24">

            <!-- Dynamic Modular Logo Section -->
            <a href="{{route('shop', $brand)}}" class="text-2xl font-light tracking-widest uppercase serif-display">
                ELIXIR<span class="text-[var(--primary)] font-bold">.</span>
            </a>

            <!-- Balanced Centered Minimalist Menu Links -->
            <nav class="hidden md:flex items-center gap-10 text-xs font-medium tracking-widest uppercase text-neutral-500">
                <a href="{{route('shop', $brand)}}" class="hover:text-[var(--primary)] transition-colors tracking-widest">Shop</a>
                <a href="{{route('shop.about', $brand)}}" class="hover:text-[var(--primary)] transition-colors tracking-widest">About Us</a>
            </nav>

            <!-- Utility Action Controls Drawer -->
            <div class="flex items-center gap-3">

                <!-- Wishlist Trigger Interface -->
                <button class="w-11 h-11 text-neutral-700 hover:text-[var(--primary)] hover:bg-neutral-50 rounded-full transition-all flex items-center justify-center">
                    <i class="fa-regular fa-heart text-base"></i>
                </button>

                <!-- Cart Anchor interface element -->
                <a
                    href="{{ route('cart', ['brand' => $brand->slug]) }}"
                    class="relative w-11 h-11 text-neutral-700 hover:text-[var(--primary)] hover:bg-neutral-50 rounded-full transition-all flex items-center justify-center"
                >
                    <i class="fa-solid fa-bag-shopping text-base"></i>
                    <span
                        x-data="{ count: 0 }"
                        x-on:cart-updated.window="count = $event.detail.count"
                        x-show="count > 0"
                        x-transition
                        class="absolute top-1.5 right-1.5 bg-[var(--primary)] text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center shadow-md"
                    >
                        <span x-text="count"></span>
                    </span>
                </a>

                <!-- User Interactive State Layout Trigger -->
                @auth
                    <div class="relative ml-1" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-[var(--secondary)] border border-white flex items-center justify-center shadow-sm">
                                <span class="text-xs font-semibold text-neutral-800 uppercase">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-xl border border-neutral-100 py-2 z-50">
                            <a href="#" class="block px-5 py-2.5 text-xs font-medium text-neutral-600 hover:bg-neutral-50">My Orders</a>
                            <hr class="my-1.5 border-neutral-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-5 py-2.5 text-xs font-medium text-rose-600 hover:bg-rose-50/50">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-semibold tracking-widest uppercase text-neutral-700 hover:text-[var(--primary)] transition-colors px-4 py-2.5 rounded-full hover:bg-neutral-50">Login</a>
                @endauth
            </div>
        </div>
    </div>
</header>

<!-- Main Container Content Injector -->
<main>
    <x-toast position="top-right" duration="5000" />
    {{ $slot }}
</main>

<!-- High-End Structural Footer Layer -->
<footer class="bg-neutral-950 text-neutral-400 w-full border-t border-neutral-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">

        <!-- Main Link Network Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10 md:gap-8 lg:gap-12">

            <!-- Column 1: Core Brand Statement Frame (Wider profile allocation) -->
            <div class="space-y-5 sm:col-span-2 lg:col-span-2">
                <h5 class="text-xl font-bold tracking-wider text-white uppercase">
                    {{ config('app.name') }}<span class="text-neutral-500">.</span>
                </h5>
                <p class="text-xs sm:text-sm text-neutral-400 max-w-sm leading-relaxed font-light">
                    Providing seamless e-commerce solutions and premium storefront interfaces. Crafted to deliver high-quality, dependable framework execution for modern digital ecosystems.
                </p>
                <!-- Universal Social Media Anchor Nodes -->
                <div class="flex gap-2.5 pt-1">
                    <a href="#" aria-label="Instagram" class="w-9 h-9 rounded-xl bg-neutral-900 border border-neutral-800/60 flex items-center justify-center text-neutral-400 hover:text-white hover:border-neutral-700 transition-all active:scale-95">
                        <i class="fa-brands fa-instagram text-sm"></i>
                    </a>
                    <a href="#" aria-label="Facebook" class="w-9 h-9 rounded-xl bg-neutral-900 border border-neutral-800/60 flex items-center justify-center text-neutral-400 hover:text-white hover:border-neutral-700 transition-all active:scale-95">
                        <i class="fa-brands fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" aria-label="X / Twitter" class="w-9 h-9 rounded-xl bg-neutral-900 border border-neutral-800/60 flex items-center justify-center text-neutral-400 hover:text-white hover:border-neutral-700 transition-all active:scale-95">
                        <i class="fa-brands fa-x-twitter text-sm"></i>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="w-9 h-9 rounded-xl bg-neutral-900 border border-neutral-800/60 flex items-center justify-center text-neutral-400 hover:text-white hover:border-neutral-700 transition-all active:scale-95">
                        <i class="fa-brands fa-linkedin-in text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2: Generic Collection Array -->
            <div class="space-y-4">
                <h5 class="text-xs font-semibold uppercase text-white tracking-widest">Shop & Explore</h5>
                <ul class="space-y-2.5 text-xs font-light tracking-wide">
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">All Collections</a></li>
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">Featured Products</a></li>
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">New Arrivals</a></li>
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">Exclusive Offers</a></li>
                </ul>
            </div>

            <!-- Column 3: Universal Customer Success Desk -->
            <div class="space-y-4">
                <h5 class="text-xs font-semibold uppercase text-white tracking-widest">Customer Support</h5>
                <ul class="space-y-2.5 text-xs font-light tracking-wide">
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">Help & FAQs</a></li>
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">Shipping & Delivery</a></li>
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">Returns & Exchanges</a></li>
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">Track Your Order</a></li>
                </ul>
            </div>

            <!-- Column 4: Corporate / Company Node -->
            <div class="space-y-4">
                <h5 class="text-xs font-semibold uppercase text-white tracking-widest">Our Company</h5>
                <ul class="space-y-2.5 text-xs font-light tracking-wide">
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">About Us</a></li>
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">Contact Directory</a></li>
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">Careers Channel</a></li>
                    <li><a href="#" class="hover:text-white transition-colors py-0.5 block">Corporate Responsibility</a></li>
                </ul>
            </div>

        </div>

        <!-- Lower Metadata Legal Agreement Bar -->
        <div class="mt-16 pt-8 border-t border-neutral-900/80 flex flex-col-reverse sm:flex-row items-center justify-between gap-4 text-xs text-neutral-500 font-light tracking-wider">
            <p class="text-center sm:text-left">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2">
                <a href="#" class="hover:text-neutral-400 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-neutral-400 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-neutral-400 transition-colors">Cookie Configurations</a>
            </div>
        </div>

    </div>
</footer>

@fluxScripts
@vite(['resources/js/app.js'])
</body>
</html>
