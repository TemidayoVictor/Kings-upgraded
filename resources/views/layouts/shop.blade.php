<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Shop' }} | {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css'])

    <style>
        /* Custom styles for the warm aesthetic */
        .bg-warm {
            background: #f7f5f2;
        }

        .bg-warm-light {
            background: #eae1d7;
        }

        .text-terracotta {
            color: #b55a3b;
        }

        .border-warm {
            border-color: #e5dbd2;
        }

        .hover-terracotta:hover {
            color: #b55a3b;
        }

        .bg-terracotta {
            background-color: #b55a3b;
        }

        .card-shadow {
            box-shadow: 0 12px 28px -8px rgba(0,0,0,0.06);
        }

        .card-shadow:hover {
            box-shadow: 0 30px 40px -14px rgba(98, 64, 48, 0.15);
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#f7f5f2] text-[#1e1b1b]">
<!-- Header with blur effect -->
<header class="bg-white/85 backdrop-blur-md sticky top-0 z-50 border-b border-[#e0d6cc]/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="/" class="text-3xl font-light text-[#2c2420] tracking-tight">
                ELIXIR<span class="text-[#b55a3b] font-medium">.</span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-10">
                <a href="#" class="text-[#2c2420] hover:text-[#b55a3b] transition-colors border-b border-transparent hover:border-[#b55a3b] pb-1">Shop</a>
                <a href="#" class="text-[#2c2420] hover:text-[#b55a3b] transition-colors border-b border-transparent hover:border-[#b55a3b] pb-1">New</a>
                <a href="#" class="text-[#2c2420] hover:text-[#b55a3b] transition-colors border-b border-transparent hover:border-[#b55a3b] pb-1">Serums</a>
                <a href="#" class="text-[#2c2420] hover:text-[#b55a3b] transition-colors border-b border-transparent hover:border-[#b55a3b] pb-1">Bestsellers</a>
            </nav>

            <!-- Right Navigation -->
            <div class="flex items-center gap-6">
                <!-- Cart Icon with Count -->
                <button
                    x-data
                    @click="$dispatch('open-cart')"
                    class="relative p-2 text-[#2c2420] hover:text-[#b55a3b] transition-colors"
                >
                    <i class="fa-regular fa-bag-shopping text-xl"></i>
                    <span
                        x-data="{ count: 0 }"
                        x-on:cart-updated.window="count = $event.detail.count"
                        x-show="count > 0"
                        x-transition
                        class="absolute -top-1 -right-1 bg-[#b55a3b] text-white text-xs w-5 h-5 rounded-full flex items-center justify-center shadow-lg"
                    >
                                <span x-text="count"></span>
                            </span>
                </button>

                <!-- Wishlist Icon -->
                <i class="fa-regular fa-heart text-xl text-[#2c2420] hover:text-[#b55a3b] transition-colors cursor-pointer hidden sm:block"></i>
                <a href="{{ route('cart', ['brand' => $brand->slug]) }}" class="relative">
                    <i class="fa-regular fa-bag-shopping text-2xl text-[#2c2420] hover:text-[#b55a3b] transition-colors"></i>
                    <span
                        x-data="{ count: 0 }"
                        x-on:cart-updated.window="count = $event.detail.count"
                        x-show="count > 0"
                        x-transition
                        class="absolute -top-2 -right-2 bg-[#b55a3b] text-white text-xs w-5 h-5 rounded-full flex items-center justify-center"
                    >
                            <span x-text="count"></span>
                        </span>
                </a>
                <!-- User Menu -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-full bg-[#eae1d7] flex items-center justify-center border-2 border-white shadow-md">
                                <span class="text-sm font-medium text-[#2c2420]">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </button>
                        <!-- Dropdown menu -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-[#e5dbd2] py-2">
                            <a href="#" class="block px-4 py-2 text-[#2c2420] hover:bg-[#f7f5f2]">Profile</a>
                            <a href="#" class="block px-4 py-2 text-[#2c2420] hover:bg-[#f7f5f2]">Orders</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-[#2c2420] hover:bg-[#f7f5f2]">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-[#2c2420] hover:text-[#b55a3b] transition-colors">Sign In</a>
                @endauth

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-2xl text-[#2c2420]">
                    <i class="fa-regular fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main>
    <x-toast position="top-right" duration="5000" />
    {{ $slot }}
</main>

<!-- Footer -->
<footer class="bg-[#f0eae4] rounded-t-[40px] mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <h5 class="text-xl font-medium text-[#2e251f] mb-6">ELIXIR.</h5>
                <p class="text-[#4c3f37] mb-6">slow beauty, modern rituals.<br>inspired by nature.</p>
                <div class="flex gap-6">
                    <i class="fa-brands fa-instagram text-2xl text-[#5b4b40] hover:text-[#b55a3b] transition-colors cursor-pointer"></i>
                    <i class="fa-brands fa-facebook text-2xl text-[#5b4b40] hover:text-[#b55a3b] transition-colors cursor-pointer"></i>
                    <i class="fa-brands fa-pinterest text-2xl text-[#5b4b40] hover:text-[#b55a3b] transition-colors cursor-pointer"></i>
                </div>
            </div>
            <div>
                <h5 class="font-medium text-[#2e251f] mb-6">explore</h5>
                <ul class="space-y-3">
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">shop all</a></li>
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">bestsellers</a></li>
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">new arrivals</a></li>
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">gift cards</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-medium text-[#2e251f] mb-6">help</h5>
                <ul class="space-y-3">
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">contact</a></li>
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">shipping</a></li>
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">returns</a></li>
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-medium text-[#2e251f] mb-6">journal</h5>
                <ul class="space-y-3">
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">skin glossary</a></li>
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">rituals</a></li>
                    <li><a href="#" class="text-[#5b4b40] hover:text-[#b55a3b]">sustainability</a></li>
                </ul>
            </div>
        </div>
        <p class="text-center text-[#7f6e63] text-sm mt-12 pt-8 border-t border-[#dfcfc0]">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</footer>

@fluxScripts
@vite(['resources/js/app.js'])
</body>
</html>
