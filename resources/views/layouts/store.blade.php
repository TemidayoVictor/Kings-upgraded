{{-- resources/views/layouts/dropshipper-store.blade.php --}}
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $store->store_name }} | {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @fluxAppearance
    @stack('styles')

    <style>
        :root {
            --store-primary: #b55a3b;        /* Brand accents & CTA elements */
            --store-primary-hover: #96462b;  /* Button interactive states */
            --store-bg: #f8f6f4;             /* Universal page canvas tint */
            --store-surface: #eae1d7;        /* Footer backgrounds and structured strips */
        }
    </style>
</head>
<body class="font-sans antialiased bg-[var(--store-bg)] text-stone-900 selection:bg-amber-100">

<header class="bg-white border-b border-stone-200 sticky top-0 z-40 shadow-sm/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-4">

            <div class="flex items-center shrink-0">
                <a href="{{ route('dropshipper-store', $store) }}" class="flex items-center gap-2.5 sm:gap-3">
                    @if($store->image)
                        <img src="{{ Storage::url($store->image) }}" alt="{{ $store->store_name }}" class="h-10 w-10 sm:h-11 sm:w-11 rounded-xl object-cover ring-2 ring-[var(--store-primary)] ring-offset-2">
                    @else
                        <div class="h-10 w-10 sm:h-11 sm:w-11 bg-[var(--store-primary)] rounded-xl flex items-center justify-center text-white text-lg font-bold shadow-sm">
                            {{ substr($store->store_name, 0, 1) }}
                        </div>
                    @endif
                    <div class="max-w-[140px] sm:max-w-xs truncate">
                        <h1 class="text-base sm:text-lg font-semibold text-stone-950 tracking-tight leading-tight truncate">{{ $store->store_name }}</h1>
                        <p class="text-[10px] sm:text-xs text-stone-500 hidden sm:block truncate">by {{ $store->dropshipper->user->name }}</p>
                    </div>
                </a>
            </div>

            <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm font-medium text-stone-600">
                <a href="#" class="hover:text-[var(--store-primary)] transition-colors">Home</a>
                <a href="#" class="hover:text-[var(--store-primary)] transition-colors text-[var(--store-primary)]">Shop</a>
                <a href="#" class="hover:text-[var(--store-primary)] transition-colors">About</a>
                <a href="#" class="hover:text-[var(--store-primary)] transition-colors">Contact</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                <button class="p-2 text-stone-700 hover:text-[var(--store-primary)] transition-colors text-center w-9 h-9 flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </button>

                <a href="{{ route('dropshipper-cart', ['store' => $store]) }}" class="relative p-2 text-stone-700 hover:text-[var(--store-primary)] transition-colors w-10 h-10 flex items-center justify-center">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>

                    @if(session('cart_'.$store->id))
                        <span class="absolute top-1 right-1 bg-[var(--store-primary)] text-white text-[10px] font-bold w-4.5 h-4.5 rounded-full flex items-center justify-center shadow-sm">
                            {{ session('cart_'.$store->id)->item_count ?? 0 }}
                        </span>
                    @endif

                    <span
                        x-data="{ count: 0 }"
                        x-on:cart-updated.window="count = $event.detail.count"
                        x-show="count > 0"
                        x-transition
                        class="absolute top-1 right-1 bg-[var(--store-primary)] text-white text-[10px] font-bold w-4.5 h-4.5 rounded-full flex items-center justify-center shadow-sm"
                        style="display: none;"
                    >
                        <span x-text="count"></span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</header>

<main>
    <x-toast position="top-right" duration="5000" />
    {{ $slot }}
</main>

<footer class="bg-[var(--store-surface)] border-t border-stone-300/60 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <div class="sm:col-span-2 md:col-span-1">
                <h3 class="font-semibold text-stone-950 mb-3 text-base">{{ $store->store_name }}</h3>
                <p class="text-xs sm:text-sm text-stone-700 leading-relaxed max-w-xs">
                    A curated selection of quality products, brought to you by {{ $store->dropshipper->user->name }}.
                </p>
            </div>

            <div>
                <h4 class="font-medium text-stone-900 mb-3 text-sm tracking-wide uppercase">Quick Links</h4>
                <ul class="space-y-2 text-xs sm:text-sm">
                    <li><a href="#" class="text-stone-700 hover:text-[var(--store-primary)] transition-colors">About Us</a></li>
                    <li><a href="#" class="text-stone-700 hover:text-[var(--store-primary)] transition-colors">Contact Information</a></li>
                    <li><a href="#" class="text-stone-700 hover:text-[var(--store-primary)] transition-colors">Shipping Framework</a></li>
                    <li><a href="#" class="text-stone-700 hover:text-[var(--store-primary)] transition-colors">Returns & Exchanges</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-medium text-stone-900 mb-3 text-sm tracking-wide uppercase">Categories</h4>
                <ul class="space-y-2 text-xs sm:text-sm">
                    @foreach($sections ?? [] as $section)
                        <li><a href="#" class="text-stone-700 hover:text-[var(--store-primary)] transition-colors">{{ $section->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-medium text-stone-900 mb-3 text-sm tracking-wide uppercase">Connect</h4>
                <div class="flex gap-2.5">
                    <a href="#" class="w-9 h-9 bg-white rounded-xl flex items-center justify-center text-stone-800 hover:text-[var(--store-primary)] hover:shadow-sm transition-all border border-stone-200">
                        <i class="fa-brands fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 bg-white rounded-xl flex items-center justify-center text-stone-800 hover:text-[var(--store-primary)] hover:shadow-sm transition-all border border-stone-200">
                        <i class="fa-brands fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 bg-white rounded-xl flex items-center justify-center text-stone-800 hover:text-[var(--store-primary)] hover:shadow-sm transition-all border border-stone-200">
                        <i class="fa-brands fa-x-twitter text-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-stone-300/50 mt-8 pt-6 text-center text-xs text-stone-600">
            <p>&copy; {{ date('Y') }} {{ $store->store_name }}. All rights reserved. Powered by KING'S.</p>
        </div>
    </div>
</footer>

@stack('modals')
@livewireScripts
@stack('scripts')
</body>
</html>
