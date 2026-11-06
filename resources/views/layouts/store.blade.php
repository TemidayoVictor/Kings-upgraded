<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $store->store_name }} | {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @fluxAppearance
    @stack('styles')

    <style>
        :root {
            --store-primary: #a73818;
            --store-primary-hover: #872102;
            --store-bg: #faf8fe;
            --store-surface: #f4f3f8;
            --store-surface-alt: #efedf3;
            --store-text: #1a1b1f;
            --store-text-muted: #58423c;
        }
        body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }
        ::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="antialiased bg-[var(--store-bg)] text-[var(--store-text)] min-h-screen flex flex-col selection:bg-[var(--store-primary)]/20">

<header class="sticky top-0 z-40 bg-white/90 backdrop-blur-xl border-b border-stone-200/60 shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20 gap-3">

            <a href="{{ route('dropshipper-store', $store) }}" class="flex items-center gap-2.5 sm:gap-3 shrink-0">
                @if($store->image)
                    <img src="{{ Storage::url($store->image) }}" alt="{{ $store->store_name }}"
                         class="h-9 w-9 sm:h-11 sm:w-11 rounded-xl object-cover ring-2 ring-[var(--store-primary)]/20 ring-offset-2">
                @else
                    <div class="h-9 w-9 sm:h-11 sm:w-11 bg-[var(--store-primary)] rounded-xl flex items-center justify-center text-white text-base sm:text-lg font-bold shadow-sm">
                        {{ substr($store->store_name, 0, 1) }}
                    </div>
                @endif
                <div class="max-w-[140px] sm:max-w-xs truncate">
                    <h1 class="text-sm sm:text-lg font-semibold tracking-tight leading-tight truncate">{{ $store->store_name }}</h1>
                    <p class="text-[10px] sm:text-xs text-stone-500 sm:block truncate">by {{ $store->dropshipper->user->name }}</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm font-medium text-stone-600">
                <a href="{{ route('dropshipper-store', ['store' => $store]) }}"
                   class="hover:text-[var(--store-primary)] transition-colors {{ request()->routeIs('dropshipper-store') ? 'text-[var(--store-primary)] font-semibold' : '' }}">
                    Home
                </a>
                <a href="{{ route('dropshipper-cart', ['store' => $store]) }}"
                   class="hover:text-[var(--store-primary)] transition-colors {{ request()->routeIs('dropshipper-cart') ? 'text-[var(--store-primary)] font-semibold' : '' }}">
                    Cart
                </a>
            </nav>

            <a href="{{ route('dropshipper-cart', ['store' => $store]) }}"
               class="relative p-2 text-stone-700 hover:text-[var(--store-primary)] transition-colors w-10 h-10 flex items-center justify-center">
                <i class="fa-solid fa-bag-shopping text-lg sm:text-xl"></i>

                @if(session('cart_'.$store->id))
                    <span class="absolute top-0.5 right-0.5 bg-[var(--store-primary)] text-white text-[10px] font-bold min-w-[16px] h-4 rounded-full flex items-center justify-center px-1 shadow-sm">
                        {{ session('cart_'.$store->id)->item_count ?? 0 }}
                    </span>
                @endif

                <span
                    x-data="{ count: 0 }"
                    x-on:cart-updated.window="count = $event.detail.count"
                    x-show="count > 0"
                    x-transition
                    class="absolute top-0.5 right-0.5 bg-[var(--store-primary)] text-white text-[10px] font-bold min-w-[16px] h-4 rounded-full flex items-center justify-center px-1 shadow-sm"
                    style="display: none;"
                >
                    <span x-text="count"></span>
                </span>
            </a>
        </div>
    </div>
</header>

<main class="flex-1">
    <x-toast position="top-right" duration="5000" />
    {{ $slot }}
</main>

<footer class="bg-[var(--store-surface)] border-t border-stone-200/60 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 items-center">
            <div>
                <h3 class="font-semibold text-stone-950 text-base">{{ $store->store_name }}</h3>
                <p class="text-xs sm:text-sm text-stone-600 mt-1.5 max-w-md leading-relaxed">
                    Thank you for shopping with us. We appreciate your business.
                </p>
            </div>
            <div class="md:text-right border-t md:border-t-0 border-stone-300/50 pt-4 md:pt-0">
                <p class="text-xs text-stone-500">
                    &copy; {{ date('Y') }} {{ $store->store_name }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

@stack('modals')
@livewireScripts
@stack('scripts')
</body>
</html>
