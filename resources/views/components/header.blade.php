<header class="sticky top-0 z-50 w-full border-b border-white/10 bg-zinc-950/80 backdrop-blur-xl">
    <div class="container mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- Logo / Brand --}}
        <div class="flex items-center gap-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600">
                <span class="text-lg font-bold text-white">F</span>
            </div>
            <span class="text-xl font-semibold text-white">Flux</span>
        </div>

        {{-- Desktop Navigation --}}
        <nav class="hidden items-center gap-8 md:flex">
            <a href="/" class="text-sm font-medium text-zinc-400 transition-colors hover:text-white">
                Home
            </a>
            <a href="/about" class="text-sm font-medium text-zinc-400 transition-colors hover:text-white">
                About
            </a>
            <a href="/pricing" class="text-sm font-medium text-zinc-400 transition-colors hover:text-white">
                Pricing
            </a>
            <a href="/brands" class="text-sm font-medium text-zinc-400 transition-colors hover:text-white">
                Brands
            </a>
        </nav>

        {{-- Right side: Login + Mobile menu button --}}
        <div class="flex items-center gap-4">
            <a href="/login"
               class="rounded-full bg-white/10 px-5 py-2.5 text-sm font-medium text-white transition-all hover:bg-white/20 hover:scale-105 active:scale-95">
                Log in
            </a>

            {{-- Mobile menu button --}}
            <button class="rounded-lg p-2 text-zinc-400 hover:bg-white/10 hover:text-white md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Navigation (hidden by default) --}}
    <div class="hidden border-t border-white/10 bg-zinc-950 px-4 py-4 md:hidden" id="mobile-menu">
        <nav class="flex flex-col space-y-3">
            <a href="/" class="rounded-lg px-4 py-2 text-zinc-400 hover:bg-white/10 hover:text-white">
                Home
            </a>
            <a href="/about" class="rounded-lg px-4 py-2 text-zinc-400 hover:bg-white/10 hover:text-white">
                About
            </a>
            <a href="/pricing" class="rounded-lg px-4 py-2 text-zinc-400 hover:bg-white/10 hover:text-white">
                Pricing
            </a>
            <a href="/brands" class="rounded-lg px-4 py-2 text-zinc-400 hover:bg-white/10 hover:text-white">
                Brands
            </a>
        </nav>
    </div>
</header>

{{-- Simple Alpine.js for mobile menu toggle --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('header', () => ({
            mobileMenuOpen: false,
            toggleMobileMenu() {
                this.mobileMenuOpen = !this.mobileMenuOpen;
                document.getElementById('mobile-menu').classList.toggle('hidden');
            }
        }));
    });
</script>
