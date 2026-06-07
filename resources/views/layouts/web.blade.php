<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>KING'S — @yield('title')</title>

    <!-- Google Fonts + Tailwind + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper.js Stylesheets & Script Engines -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo-Crown.svg') }}">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <!-- Reusable Design Tokens via Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            canvas: '#FAF8F5', /* Warm luxury stone cream */
                            dark: '#1A1612',   /* Deep premium espresso */
                            cardDark: '#26201A', /* Soft dark chocolate panel */
                            primary: '#e9a35d',  /* YOUR LOGO COLOR: Honey Amber */
                            secondary: '#8C7A6B', /* Elegant warm taupe */
                            accent: '#D97706',   /* Rich deeper amber for contrast text */
                            muted: '#8A847F'     /* Neutral stone gray */
                        }
                    }
                }
            }
        }
    </script>

    <!-- Reusable Global UI Component Styles -->
    <style>
        body {
            background-color: #FAF8F5;
        }

        /* Reusable Component: Frosted Glass Navigation */
        .nav-glass {
            background: rgba(250, 248, 245, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Reusable Component: Dark Premium Backgrounds */
        .bg-premium-dark {
            background: radial-gradient(133.44% 100% at 50% 0%, #2D251E 0%, #1A1612 100%);
        }

        /* Reusable Component: Interactive Grid Cards */
        .card-interactive {
            background: #FFFFFF;
            border: 1px solid #EFECE6;
            border-radius: 1rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-interactive:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -15px rgba(26, 22, 18, 0.05);
            border-color: #DFDACF;
        }

        /* Reusable Component: Interactive Dark Mode Grid Cards */
        .card-interactive-dark {
            background: rgba(38, 32, 26, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 1rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-interactive-dark:hover {
            transform: translateY(-5px);
            background: rgba(38, 32, 26, 0.9);
            border-color: rgba(233, 163, 93, 0.3);
        }

        /* Reusable Component: Buttons */
        .btn-primary {
            background-color: #e9a35d;
            color: #1A1612;
            font-weight: 700;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #DB924A;
            box-shadow: 0 0 20px rgba(233, 163, 93, 0.35);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #FFFFFF;
            color: #26201A;
            font-weight: 600;
            border: 1px solid #EFECE6;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }
        .btn-secondary:hover {
            background-color: #FAF8F5;
            border-color: #DFDACF;
        }

        /* Responsive Mobile Menu Animation Rules */
        #mobile-menu {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
        }
        #mobile-menu.open {
            max-height: 500px;
            opacity: 1;
        }

        @media (max-width: 1024px) {
            body {
                padding-bottom: 70px; /* Ensures content isn't hidden behind the bottom nav */
            }
        }
    </style>
</head>
<body class="antialiased text-stone-900 font-sans">

<!-- ==================== GLOBAL NAVIGATION ==================== -->
<nav class="nav-glass border-b border-stone-200/60 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between">
            <!-- App Logo Architecture -->
            <a href="/" class="flex items-center gap-2.5">
                <img class="w-8 h-8" src="{{ asset('images/Logo-Crown.svg') }}" alt="">
                <span class="text-xl font-[900] tracking-tight text-amber-900">KING'S</span>
            </a>

            <!-- Desktop Links (Hidden on Mobile) -->
            <div class="hidden lg:flex items-center space-x-8 text-[15px] font-semibold text-stone-600">
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'text-brand-primary border-b-2 border-brand-primary pb-1' : 'text-stone-600 hover:text-brand-primary' }}">
                    Home
                </a>
                <a href="{{ route('brands') }}"
                   class="{{ request()->routeIs('brands') ? 'text-brand-primary border-b-2 border-brand-primary pb-1' : 'text-stone-600 hover:text-brand-primary' }}">
                    Brands
                </a>
                <a href="{{ route('sales') }}"
                   class="{{ request()->routeIs('sales') ? 'text-brand-primary border-b-2 border-brand-primary pb-1' : 'text-stone-600 hover:text-brand-primary' }}">
                    Sales
                </a>
                <a href="{{ route('features') }}"
                   class="{{ request()->routeIs('features') ? 'text-brand-primary border-b-2 border-brand-primary pb-1' : 'text-stone-600 hover:text-brand-primary' }}">
                    Features
                </a>
            </div>

            @auth
                <div class="relative" x-data="{ open: false }">
                    <!-- Profile Trigger: High contrast border -->
                    <button @click="open = !open" type="button" class="group flex items-center focus:outline-none cursor-pointer">
                        <div class="w-10 h-10 rounded-full bg-stone-900 border-2 border-stone-100 flex items-center justify-center shadow-sm transition-transform hover:scale-105">
                            <span class="text-[12px] font-bold text-white uppercase">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-2xl border border-stone-200 p-2 z-50"
                         x-cloak>

                        <a href="{{route('dashboard')}}" class="block px-4 py-2.5 text-xs font-medium text-stone-600 hover:bg-stone-50 rounded-xl transition-colors">Dashboard</a>

                        <div class="my-1 border-t border-stone-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50/50 rounded-xl transition-colors">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Auth Buttons: High Contrast for White/Light Backgrounds -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}" class="text-stone-900 text-[12px] font-bold px-3 py-2 hover:text-[var(--store-primary)] transition-colors">
                        Log In
                    </a>
                    <a href="{{ route('signup') }}" class="bg-stone-950 text-white text-[12px] font-bold px-5 py-2.5 rounded-xl shadow-md hover:bg-stone-800 transition-all active:scale-95">
                        Sign Up
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<!-- ==================== MOBILE BOTTOM NAVIGATION ==================== -->
<div class="lg:hidden fixed bottom-0 left-0 right-0 nav-glass border-t border-stone-200/60 z-50 px-6 py-3">
    <div class="flex justify-between items-center max-w-md mx-auto">
        <a href="{{ route('home') }}"
           class="flex flex-col items-center gap-1 {{ request()->routeIs('home') ? 'text-brand-primary' : 'text-stone-500' }}">
            <i class="fas fa-house text-lg"></i>
            <span class="text-[9px] font-bold uppercase tracking-wider">Home</span>
        </a>

        <a href="{{ route('brands') }}"
           class="flex flex-col items-center gap-1 {{ request()->routeIs('brands') ? 'text-brand-primary' : 'text-stone-500' }}">
            <i class="fas fa-tags text-lg"></i>
            <span class="text-[9px] font-bold uppercase tracking-wider">Brands</span>
        </a>

        <a href="{{ route('sales') }}"
           class="flex flex-col items-center gap-1 {{ request()->routeIs('sales') ? 'text-brand-primary' : 'text-stone-500' }}">
            <i class="fas fa-bolt text-lg"></i>
            <span class="text-[9px] font-bold uppercase tracking-wider">Sales</span>
        </a>

        <a href="{{ route('features') }}"
           class="flex flex-col items-center gap-1 {{ request()->routeIs('features') ? 'text-brand-primary' : 'text-stone-500' }}">
            <i class="fas fa-circle-info text-lg"></i>
            <span class="text-[9px] font-bold uppercase tracking-wider">Features</span>
        </a>
    </div>
</div>

<main>
    @yield('content')
</main>

<!-- ==================== GLOBAL FOOTER LAYER ==================== -->
<footer class="bg-brand-dark text-stone-400 py-16 border-t border-white/5 text-sm relative overflow-hidden">
    <!-- Subtle warm glow behind footer elements -->
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-brand-primary/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- Top Section: Core Brand Info & Links Mapping -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-12 gap-8 pb-12 border-b border-stone-800/80">

            <!-- Column 1: Brand Identifier (Spans 4 columns on large viewports) -->
            <div class="col-span-2 md:col-span-4 lg:col-span-4 space-y-4">
                <a href="#" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 bg-brand-primary rounded-lg flex items-center justify-center shadow-md shadow-amber-500/10">
                        <i class="fas fa-cubes text-brand-dark text-base"></i>
                    </div>
                    <span class="font-extrabold text-xl tracking-tight text-white">
              Nexus<span class="text-brand-primary">Hub</span>
            </span>
                </a>
                <p class="text-xs text-stone-500 max-w-sm leading-relaxed">
                    The decentralized distribution engine connecting premium brand suppliers with thousands of high-velocity dropshipping storefronts worldwide.
                </p>
                <!-- Social Media Vector Footprint -->
                <div class="flex items-center gap-3 pt-2">
                    <a href="#" class="w-8 h-8 rounded-lg bg-white/5 border border-white/5 hover:border-brand-primary/40 text-stone-400 hover:text-brand-primary flex items-center justify-center transition-all" aria-label="Twitter"><i class="fab fa-twitter text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-white/5 border border-white/5 hover:border-brand-primary/40 text-stone-400 hover:text-brand-primary flex items-center justify-center transition-all" aria-label="LinkedIn"><i class="fab fa-linkedin-in text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-white/5 border border-white/5 hover:border-brand-primary/40 text-stone-400 hover:text-brand-primary flex items-center justify-center transition-all" aria-label="Instagram"><i class="fab fa-instagram text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-white/5 border border-white/5 hover:border-brand-primary/40 text-stone-400 hover:text-brand-primary flex items-center justify-center transition-all" aria-label="Discord"><i class="fab fa-discord text-xs"></i></a>
                </div>
            </div>

            <!-- Column 2: Platform Links Directory -->
            <div class="col-span-1 md:col-span-2 lg:col-span-2 space-y-3">
                <h5 class="text-xs font-bold uppercase tracking-widest text-white/90">Marketplace</h5>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="#" class="hover:text-brand-primary transition">Discover Hubs</a></li>
                    <li><a href="#" class="hover:text-brand-primary transition">Trending Items</a></li>
                    <li><a href="#" class="hover:text-brand-primary transition">Featured Stores</a></li>
                    <li><a href="#" class="hover:text-brand-primary transition">Niche Map Matrix</a></li>
                </ul>
            </div>

            <!-- Column 3: Network Business Rules Link Tree -->
            <div class="col-span-1 md:col-span-2 lg:col-span-2 space-y-3">
                <h5 class="text-xs font-bold uppercase tracking-widest text-white/90">Ecosystem Roles</h5>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="#" class="hover:text-brand-primary transition">For Brand Owners</a></li>
                    <li><a href="#" class="hover:text-brand-primary transition">For Dropshippers</a></li>
                    <li><a href="#" class="hover:text-brand-primary transition">Split Commission Rules</a></li>
                    <li><a href="#" class="hover:text-brand-primary transition">Enterprise Tiering</a></li>
                </ul>
            </div>

            <!-- Column 4: Newsletter Engine Input Capture -->
            <div class="col-span-2 md:col-span-4 lg:col-span-4 space-y-3">
                <h5 class="text-xs font-bold uppercase tracking-widest text-white/90">Stay Synced</h5>
                <p class="text-xs text-stone-500 leading-relaxed">Receive updates whenever new verified suppliers deploy inventories into the marketplace nodes.</p>
                <form class="flex gap-2 pt-1" onsubmit="event.preventDefault();">
                    <input type="email" placeholder="Your secure email..." class="bg-white/5 border border-white/10 rounded-xl px-3 py-2 text-xs text-white placeholder-stone-500 focus:outline-none focus:border-brand-primary/50 w-full transition" required>
                    <button type="submit" class="bg-brand-primary text-brand-dark px-4 py-2 rounded-xl text-xs font-bold hover:bg-amber-400 transition whitespace-nowrap">Join Matrix</button>
                </form>
            </div>

        </div>

        <!-- Bottom Section: Legal Meta Protocols & Ledger Attribution -->
        <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-medium text-stone-500">
            <div class="text-center md:text-left space-y-1">
                <div>© 2026 NexusHub Inc. Distributed ledger orchestration layer architecture. All items verified natively.</div>
                <p class="text-[11px] text-stone-600">Built for seamless multi-party settlement sequences globally.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-stone-400">
                <a href="#" class="hover:text-brand-primary transition flex items-center gap-1.5"><i class="fas fa-shield-halved text-[10px] text-brand-primary/70"></i> Privacy Engine</a>
                <a href="#" class="hover:text-brand-primary transition flex items-center gap-1.5"><i class="fas fa-gavel text-[10px] text-brand-primary/70"></i> Terms of Node Protocol</a>
                <a href="#" class="hover:text-brand-primary transition flex items-center gap-1.5"><i class="fas fa-network-wired text-[10px] text-brand-primary/70"></i> SLA Coordinates</a>
            </div>
        </div>

    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<!-- Responsive Mobile Menu Interactivity Engine -->
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');

    menuToggle.addEventListener('click', () => {
        const isDrawerOpen = mobileMenu.classList.toggle('open');
        if (isDrawerOpen) {
            menuIcon.classList.replace('fa-bars', 'fa-xmark');
        } else {
            menuIcon.classList.replace('fa-xmark', 'fa-bars');
        }
    });
</script>

<script>
    const testimonialSwiper = new Swiper('.testimonialSwiper', {
        loop: true,
        spaceBetween: 40,
        grabCursor: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next-custom',
            prevEl: '.swiper-button-prev-custom',
        },
    });
</script>
</body>
</html>
