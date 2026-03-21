{{-- resources/views/layouts/dropshipper-store.blade.php --}}
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $store->store_name }} | {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="font-sans antialiased bg-[#f7f5f2]">
<!-- Store Header -->
<header class="bg-white border-b border-[#e5dbd2] sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo & Store Name -->
            <div class="flex items-center gap-4">
                <a href="{{ route('dropshipper-store', $store) }}" class="flex items-center gap-3">
                    @if($store->image)
                        <img src="{{ Storage::url($store->image) }}" alt="{{ $store->store_name }}" class="h-12 w-12 rounded-full object-cover border-2 border-[#b55a3b]">
                    @else
                        <div class="h-12 w-12 bg-[#b55a3b] rounded-full flex items-center justify-center text-white text-xl font-bold">
                            {{ substr($store->store_name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="text-xl font-semibold text-[#1e1b1b]">{{ $store->store_name }}</h1>
                        <p class="text-xs text-[#94897f]">by {{ $store->dropshipper->user->name }}</p>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="" class="text-[#2c2420] hover:text-[#b55a3b] transition-colors font-medium">Home</a>
                <a href="" class="text-[#2c2420] hover:text-[#b55a3b] transition-colors font-medium">Shop</a>
                <a href="" class="text-[#2c2420] hover:text-[#b55a3b] transition-colors font-medium">About</a>
                <a href="" class="text-[#2c2420] hover:text-[#b55a3b] transition-colors font-medium">Contact</a>
            </nav>

            <!-- Cart & Account -->
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-[#2c2420] hover:text-[#b55a3b] transition-colors">
                    <i class="fa-regular fa-magnifying-glass text-xl"></i>
                </button>

                <a href="" class="relative p-2 text-[#2c2420] hover:text-[#b55a3b] transition-colors">
                    <i class="fa-regular fa-bag-shopping text-xl"></i>
                    @if(session('cart_'.$store->id))
                        <span class="absolute -top-1 -right-1 bg-[#b55a3b] text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                {{ session('cart_'.$store->id)->item_count ?? 0 }}
                            </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main>
    {{ $slot }}
</main>

<!-- Store Footer -->
<footer class="bg-[#eae1d7] border-t border-[#dfcfc0] mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="font-semibold text-[#1e1b1b] mb-4">{{ $store->store_name }}</h3>
                <p class="text-sm text-[#4c3f37] leading-relaxed">
                    A curated selection of quality products, brought to you by {{ $store->dropshipper->user->name }}.
                </p>
            </div>

            <div>
                <h4 class="font-medium text-[#1e1b1b] mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-[#4c3f37] hover:text-[#b55a3b] transition-colors">About Us</a></li>
                    <li><a href="#" class="text-[#4c3f37] hover:text-[#b55a3b] transition-colors">Contact</a></li>
                    <li><a href="#" class="text-[#4c3f37] hover:text-[#b55a3b] transition-colors">Shipping Info</a></li>
                    <li><a href="#" class="text-[#4c3f37] hover:text-[#b55a3b] transition-colors">Returns</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-medium text-[#1e1b1b] mb-4">Categories</h4>
                <ul class="space-y-2 text-sm">
                    @foreach($sections ?? [] as $section)
                        <li><a href="#" class="text-[#4c3f37] hover:text-[#b55a3b] transition-colors">{{ $section->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-medium text-[#1e1b1b] mb-4">Connect</h4>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#2c2420] hover:text-[#b55a3b] hover:shadow-md transition-all">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#2c2420] hover:text-[#b55a3b] hover:shadow-md transition-all">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#2c2420] hover:text-[#b55a3b] hover:shadow-md transition-all">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-[#dfcfc0] mt-8 pt-8 text-center text-sm text-[#4c3f37]">
            <p>&copy; {{ date('Y') }} {{ $store->store_name }}. All rights reserved. Powered by KING'S.</p>
        </div>
    </div>
</footer>

@stack('modals')
@livewireScripts
@stack('scripts')
</body>
</html>
