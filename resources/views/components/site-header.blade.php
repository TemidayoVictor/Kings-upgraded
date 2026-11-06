{{-- ==================== DESKTOP HEADER ==================== --}}
<header class="hidden lg:block fixed top-0 left-0 right-0 z-50 bg-surface-cream/90 backdrop-blur-xl border-b border-border-hairline">
    <div class="max-w-7xl mx-auto px-gutter h-20 flex items-center justify-between">

        <div class="flex items-center">
            <a href="{{ route('home') }}"
               class="group flex items-start gap-2.5 transition-opacity duration-200 hover:opacity-85">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl transition-colors duration-200">
                    <img
                        alt=""
                        aria-hidden="true"
                        class="h-7 w-auto object-contain"
                        src="{{ asset('images/Logo-Crown.svg') }}"
                    />
                </div>

                <div class="flex flex-col justify-center">
                    <span class="text-[1.65rem] font-black leading-none tracking-[-0.065em] text-on-surface">
                        KING<span class="text-[#e9a35d]">'S</span>
                    </span>
                    <span class="mt-1 text-[0.57rem] font-semibold uppercase leading-none tracking-[0.24em] text-text-muted">
                        Discover. Connect. Grow.
                    </span>
                </div>
            </a>
        </div>


        <nav class="flex items-center gap-8">
            <a href="{{ route('home') }}" class="font-label-lg text-label-lg transition-colors {{ request()->routeIs('home') ? 'text-on-surface border-b-2 border-primary-container pb-1 font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">Home</a>
            <a href="{{ route('brands') }}" class="font-label-lg text-label-lg transition-colors {{ request()->routeIs('brands') ? 'text-on-surface border-b-2 border-primary-container pb-1 font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">Brands</a>
            <a href="{{ route('sales') }}" class="font-label-lg text-label-lg transition-colors {{ request()->routeIs('sales') ? 'text-on-surface border-b-2 border-primary-container pb-1 font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">Sales</a>
            <a href="{{ route('features') }}" class="font-label-lg text-label-lg transition-colors {{ request()->routeIs('features') ? 'text-on-surface border-b-2 border-primary-container pb-1 font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">Features</a>
        </nav>

        <div class="flex items-center gap-4">
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center shadow-sm hover:scale-105 transition-transform">
                            <span class="text-sm font-bold text-on-primary uppercase">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak
                         class="absolute right-0 mt-3 w-48 bg-surface-card rounded-xl shadow-lg border border-border-hairline p-2 z-50">
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-xs font-medium text-on-surface hover:bg-surface-subtle rounded-lg">Dashboard</a>
                        <div class="my-1 border-t border-border-hairline"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg">Sign Out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="font-label-lg text-label-lg text-on-surface-variant hover:text-on-surface px-3 py-2">Log in</a>
                <a href="{{ route('signup') }}" class="inline-flex items-center justify-center font-label-lg text-label-lg bg-primary-container text-on-surface font-semibold px-5 py-2.5 rounded-lg shadow-sm hover:bg-tertiary-container transition">Join KING'S</a>
            @endauth
        </div>
    </div>
</header>

{{-- ==================== MOBILE HEADER ==================== --}}
<header class="lg:hidden fixed top-0 w-full z-50 pt-safe bg-surface-cream/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.03)]">
    <div class="h-16 px-margin-mobile flex items-center justify-between">
        <div class="flex items-start">
            <div class="flex flex-col justify-center">
                <div class="flex items-center">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl mr-1">
                        <img
                            alt=""
                            aria-hidden="true"
                            class="h-7 w-auto object-contain"
                            src="{{ asset('images/Logo-Crown.svg') }}"
                        />
                    </div>
                    <span class="text-[1.65rem] font-black leading-none tracking-[-0.065em] text-on-surface">
                        KING<span class="text-[#e9a35d]">'S</span>
                    </span>
                </div>
                <span class="mt-1 text-[0.57rem] font-semibold uppercase leading-none tracking-[0.24em] text-text-muted">
                    Discover. Connect. Grow.
                </span>
            </div>
        </div>
        <div class="flex items-center gap-1">
            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="w-8 h-8 rounded-full bg-primary flex items-center justify-center ml-1">
                @if (auth()->check())
                    <span class="text-sm font-bold text-on-primary uppercase">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </span>
                @else
                    <span class="material-symbols-outlined text-on-primary text-[18px]">
                        person
                    </span>
                @endif
            </a>
        </div>
    </div>
</header>
