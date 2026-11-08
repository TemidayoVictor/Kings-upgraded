{{-- ==================== DESKTOP FOOTER ==================== --}}
<footer class="hidden lg:block w-full bg-surface-cream border-t border-border-hairline">
    <div class="max-w-7xl mx-auto px-gutter pt-space-xl pb-12">
        <div class="grid grid-cols-12 gap-12 pb-space-xl border-b border-border-hairline">
            <div class="col-span-4 space-y-4">
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
                    </a>
                </div>

                <p class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface-variant italic max-w-sm">
                    Discover Products. Connect with Brands. Grow Your Business.
                </p>

                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface-subtle border border-border-hairline">
                    <span class="w-2 h-2 rounded-full bg-status-success"></span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-semibold">Built for Business • Nigeria</span>
                </div>
            </div>

            <div class="col-span-2 space-y-3">
                <div class="font-label-sm text-label-sm uppercase tracking-widest text-text-muted font-bold">Discover</div>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('home') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Home</a></li>
                    <li><a href="{{ route('brands') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Explore Brands</a></li>
                    <li><a href="{{ route('sales') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Deals & Offers</a></li>
                    <li><a href="{{ route('features') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">How KING'S Works</a></li>
                </ul>
            </div>

            <div class="col-span-3 space-y-3">
                <div class="font-label-sm text-label-sm uppercase tracking-widest text-text-muted font-bold">For Your Business</div>
                <ul class="space-y-2.5">
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">For Brand Owners</a></li>
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">For Sales Partners</a></li>
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">For Shoppers</a></li>
                </ul>
            </div>

            <div class="col-span-3 space-y-3">
                <div class="font-label-sm text-label-sm uppercase tracking-widest text-text-muted font-bold">Help & Information</div>
                <ul class="space-y-2.5">
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Contact Us</a></li>
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Terms of Service</a></li>
                </ul>

            </div>
        </div>

        <div class="pt-8 flex items-center justify-between gap-4">
            <p class="font-body-sm text-body-sm text-text-muted">
                © {{ date('Y') }} KING'S (knkings.shop). All rights reserved.
            </p>

            <div class="flex items-center gap-6">
                <a href="#" class="font-body-sm text-body-sm text-text-muted hover:text-on-surface transition-colors">Privacy</a>
                <a href="#" class="font-body-sm text-body-sm text-text-muted hover:text-on-surface transition-colors">Terms</a>
                <a href="#" class="font-body-sm text-body-sm text-text-muted hover:text-on-surface transition-colors">Compliance</a>
            </div>
        </div>
    </div>
</footer>

{{-- ==================== MOBILE FOOTER ==================== --}}
<footer class="lg:hidden w-full bg-surface-cream border-t border-border-hairline px-margin-mobile pt-space-xl pb-32">
    <div class="flex flex-col gap-space-xl">

        {{-- Brand Block --}}
        <div class="space-y-4">
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
                </a>
            </div>

            <p class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface-variant italic leading-snug">
                Discover Products. Connect with Brands. Grow Your Business.
            </p>

            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface-subtle border border-border-hairline">
                <span class="w-2 h-2 rounded-full bg-status-success"></span>
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface font-semibold">Built for Business • Nigeria</span>
            </div>
        </div>

        {{-- Link Columns --}}
        <div class="grid grid-cols-2 gap-x-4 gap-y-8">

            {{-- Discover --}}
            <div class="space-y-3">
                <div class="font-label-sm text-label-sm uppercase tracking-widest text-text-muted font-bold">Discover</div>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('home') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Home</a></li>
                    <li><a href="{{ route('brands') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Explore Brands</a></li>
                    <li><a href="{{ route('sales') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Deals & Offers</a></li>
                    <li><a href="{{ route('features') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">How KING'S Works</a></li>
                </ul>
            </div>

            {{-- For Your Business --}}
            <div class="space-y-3">
                <div class="font-label-sm text-label-sm uppercase tracking-widest text-text-muted font-bold">For Your Business</div>
                <ul class="space-y-2.5">
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">For Brand Owners</a></li>
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">For Sales Partners</a></li>
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">For Shoppers</a></li>
                </ul>
            </div>

            {{-- Help & Information --}}
            <div class="col-span-2 space-y-3">
                <div class="font-label-sm text-label-sm uppercase tracking-widest text-text-muted font-bold">Help &amp; Information</div>
                <ul class="grid grid-cols-2 gap-x-4 gap-y-2.5">
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Contact Us</a></li>
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Terms of Service</a></li>
                    <li><a href="#" class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Compliance</a></li>
                </ul>
            </div>
        </div>

        {{-- Bottom: Copyright + Legal Micro-Links --}}
        <div class="flex flex-col gap-3 pt-2 border-t border-border-hairline">
            <p class="font-body-sm text-body-sm text-text-muted leading-relaxed">
                © {{ date('Y') }} KING'S (knkings.shop). All rights reserved.
            </p>

            <div class="flex items-center gap-5">
                <a href="#" class="font-body-sm text-body-sm text-text-muted hover:text-on-surface transition-colors">Privacy</a>
                <a href="#" class="font-body-sm text-body-sm text-text-muted hover:text-on-surface transition-colors">Terms</a>
                <a href="#" class="font-body-sm text-body-sm text-text-muted hover:text-on-surface transition-colors">Compliance</a>
            </div>
        </div>

    </div>
</footer>
