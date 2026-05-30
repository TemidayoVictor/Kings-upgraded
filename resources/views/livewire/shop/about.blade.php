{{-- resources/views/livewire/shop/about.blade.php --}}
<div class="min-h-screen bg-[#f7f6f2] text-neutral-800 antialiased selection:bg-[var(--primary)] selection:text-white">

    <!-- Top Breadcrumb/Title Context Block -->
    <div class="w-full bg-white border-b border-neutral-200 py-4 sm:py-5">
        <div class="max-w-6xl mx-auto px-4 text-xs sm:text-sm font-medium tracking-wide text-neutral-500">
            <a href="{{route('shop', $brand)}}" class="hover:text-neutral-800 transition-colors">Shop</a>
            <span class="mx-2 text-neutral-300">/</span>
            <span class="text-neutral-900 font-semibold">About us</span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <div class="bg-[var(--secondary)] rounded-[1.5em] overflow-hidden grid grid-cols-1 lg:grid-cols-12 items-center min-h-[540px] relative border border-neutral-200/40 shadow-xs">
            <div class="absolute inset-0 bg-gradient-to-tr from-white/40 via-transparent to-black/[0.02] pointer-events-none"></div>

            <!-- Left Text Content (order-2 on mobile pushes it under the image if you want the image on top, or remove order utilities to keep text on top) -->
            <div class="p-8 sm:p-12 lg:p-20 lg:col-span-7 relative z-10 space-y-6 order-2 lg:order-1">
                <span class="text-xs font-bold tracking-[4px] uppercase text-neutral-500 block">
                    {{ $brand->brandSetting->hero_tagline ?? 'Quality collections made for you' }}
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-normal tracking-tight text-neutral-900 leading-[1.05] serif-display">
                    {{ $brand->brandSetting->hero_title_line_1 ?? 'Designed for your' }}
                    <br>
                    <span class="text-brand-primary font-normal italic">
                        {{ $brand->brandSetting->hero_title_line_2_italic ?? 'everyday life.' }}
                    </span>
                </h1>

                <p class="text-sm sm:text-base text-neutral-600 max-w-md font-normal leading-relaxed">
                    {{ $brand->brandSetting->hero_description ?? 'Discover our premium range of products and services. Crafted with care to give you the best experience possible.' }}
                </p>

                <div class="pt-4">
                    <button class="w-full sm:w-auto justify-center bg-neutral-950 text-white text-xs font-medium tracking-widest uppercase px-8 py-4.5 rounded-full hover:bg-brand-primary transition-all duration-300 shadow-lg hover:-translate-y-1 flex items-center gap-3 group cursor-pointer">
                        {{ $brand->brandSetting->hero_button_text ?? 'Explore More' }}
                        <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1.5"></i>
                    </button>
                </div>
            </div>

            <!-- Right Visual Layout Box (Now adaptive across all screens) -->
            <div class="block lg:col-span-5 h-64 sm:h-80 lg:h-full relative self-stretch overflow-hidden order-1 lg:order-2">
                @if($brand->image)
                    <!-- Full-Bleed Brand Image Layer with subtle gradient protection overlay for mobile stacking shifts -->
                    <img
                        src="{{ asset('storage/' . $brand->image) }}"
                        alt="{{ $brand->brand_name }} Brand Showcase"
                        class="absolute inset-0 w-full h-full object-cover object-center"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-[var(--secondary)]/20 to-transparent lg:hidden"></div>
                @else
                    <!-- Balanced Glassmorphism Centered Placeholder -->
                    <div class="absolute inset-0 flex items-center justify-center p-6 sm:p-12 bg-neutral-950/5">
                        <div class="w-full h-full rounded-[24px] sm:rounded-[32px] border border-white/30 bg-gradient-to-b from-white/10 to-transparent backdrop-blur-md shadow-2xl flex items-center justify-center">
                            <i class="fa-solid fa-wand-magic-sparkles text-5xl sm:text-7xl text-brand-primary opacity-60 animate-pulse"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Grid Component Frame -->
    <!-- Main Content Grid Component Frame -->
    <div class="max-w-4xl mx-auto px-4 py-10 sm:py-20">
        <div class="w-full space-y-2 max-w-3xl mx-auto">

            <!-- Brand Identity Title & Banner Frame -->
            <div class="space-y-4 text-center pb-8 border-b border-neutral-200/60 relative">
                <span class="text-xs font-bold tracking-[4px] uppercase text-neutral-400 block">Brand Profile</span>
                <h1 class="text-4xl sm:text-6xl font-light tracking-tight text-neutral-950 font-serif leading-none">
                    About {{ $brand->brand_name }}
                </h1>
                @if($brand->motto)
                    <div class="inline-block px-6 py-2 rounded-full bg-[var(--secondary)]/50 border border-neutral-200/30 mt-2">
                        <p class="text-sm sm:text-base italic text-neutral-600 font-serif">
                            "{{ $brand->motto }}"
                        </p>
                    </div>
                @endif
            </div>

            <!-- Narrative Body Description -->
            @if($brand->about || $brand->description)
                <div class="text-base sm:text-xl text-neutral-700 leading-relaxed whitespace-pre-line font-serif tracking-wide drop-cap-styling px-2 sm:px-6">
                    {!! nl2br(e($brand->about ?? $brand->description)) !!}
                </div>
            @endif

            <!-- Highlighted Contact Box Element -->
            <div class="bg-white rounded-[1.5rem] p-6 sm:p-10 border border-neutral-200/80 shadow-xs space-y-8 mt-12">
                <div class="space-y-1.5">
                    <h2 class="text-2xl sm:text-3xl font-light tracking-tight text-neutral-900 font-serif">
                        Get in Touch
                    </h2>
                    <p class="text-xs sm:text-sm text-neutral-500 font-light">
                        Have questions or want to reach out? Contact our team directly.
                    </p>
                </div>

                <!-- Contact Channels Sub-Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-6 border-t border-neutral-100">
                    @if($brand->brand_email)
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 block">Email Us</span>
                            <div class="flex items-start gap-3">
                                <i class="fa-regular fa-envelope text-neutral-400 mt-1 text-sm"></i>
                                <a href="mailto:{{ $brand->brand_email }}" class="text-sm sm:text-base font-medium text-neutral-900 hover:text-brand-primary transition-colors inline-block break-all underline decoration-neutral-200 underline-offset-4 hover:decoration-brand-primary">
                                    {{ $brand->brand_email }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($brand->city || $brand->state || $brand->address)
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 block">Our Location</span>
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-location-dot text-neutral-400 mt-1 text-sm"></i>
                                <p class="text-sm sm:text-base font-medium text-neutral-900 leading-relaxed">
                                    {{ $brand->address ? $brand->address . ', ' : '' }}
                                    {{ $brand->city }}{{ $brand->city && $brand->state ? ', ' : '' }}
                                    {{ $brand->state }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Messaging & Social Anchors Framework -->
                @if($brand->instagram || $brand->facebook || $brand->twitter || $brand->youtube || $brand->tiktok || $brand->linkedin || $brand->website)
                    <div class="pt-6 border-t border-neutral-100 space-y-3">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 block mb-3">Connect Globally</span>
                        <div class="flex flex-wrap gap-2.5">

                            <!-- WhatsApp Context Channel Button link -->
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $brand->brand_email) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-600 border border-emerald-200/60 hover:border-emerald-600 text-xs font-semibold text-emerald-700 hover:text-white transition-all active:scale-95 cursor-pointer">
                                <i class="fa-brands fa-whatsapp text-sm"></i> <span>WhatsApp Chat</span>
                            </a>

                            @if($brand->instagram)
                                <a href="https://instagram.com/{{ trim($brand->instagram, '@') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-neutral-50 border border-neutral-200/60 text-xs font-medium text-neutral-700 hover:text-white hover:bg-brand-primary hover:border-brand-primary transition-all active:scale-95 cursor-pointer">
                                    <i class="fa-brands fa-instagram text-sm"></i> <span>Instagram</span>
                                </a>
                            @endif

                            @if($brand->facebook)
                                <a href="{{ $brand->facebook }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-neutral-50 border border-neutral-200/60 text-xs font-medium text-neutral-700 hover:text-white hover:bg-brand-primary hover:border-brand-primary transition-all active:scale-95 cursor-pointer">
                                    <i class="fa-brands fa-facebook-f text-sm"></i> <span>Facebook</span>
                                </a>
                            @endif

                            @if($brand->twitter)
                                <a href="https://twitter.com/{{ trim($brand->twitter, '@') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-neutral-50 border border-neutral-200/60 text-xs font-medium text-neutral-700 hover:text-white hover:bg-brand-primary hover:border-brand-primary transition-all active:scale-95 cursor-pointer">
                                    <i class="fa-brands fa-x-twitter text-sm"></i> <span>Twitter</span>
                                </a>
                            @endif

                            @if($brand->tiktok)
                                <a href="https://tiktok.com/@{{ trim($brand->tiktok, '@') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-neutral-50 border border-neutral-200/60 text-xs font-medium text-neutral-700 hover:text-white hover:bg-brand-primary hover:border-brand-primary transition-all active:scale-95 cursor-pointer">
                                    <i class="fa-brands fa-tiktok text-sm"></i> <span>TikTok</span>
                                </a>
                            @endif

                            @if($brand->youtube)
                                <a href="{{ $brand->youtube }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-neutral-50 border border-neutral-200/60 text-xs font-medium text-neutral-700 hover:text-white hover:bg-brand-primary hover:border-brand-primary transition-all active:scale-95 cursor-pointer">
                                    <i class="fa-brands fa-youtube text-sm"></i> <span>YouTube</span>
                                </a>
                            @endif

                            @if($brand->linkedin)
                                <a href="{{ $brand->linkedin }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-neutral-50 border border-neutral-200/60 text-xs font-medium text-neutral-700 hover:text-white hover:bg-brand-primary hover:border-brand-primary transition-all active:scale-95 cursor-pointer">
                                    <i class="fa-brands fa-linkedin-in text-sm"></i> <span>LinkedIn</span>
                                </a>
                            @endif

                            @if($brand->website)
                                <a href="{{ $brand->website }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-neutral-50 border border-neutral-200/60 text-xs font-medium text-neutral-700 hover:text-white hover:bg-brand-primary hover:border-brand-primary transition-all active:scale-95 cursor-pointer">
                                    <i class="fa-solid fa-globe text-sm"></i> <span>Main Website</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Features Banner Block Container Layer Layout -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3 mb-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 bg-[var(--secondary)] p-8 rounded-[1.5em] border border-neutral-200/40 shadow-xs">

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 text-brand-primary shadow-3xs">
                    <i class="fa-solid fa-bolt text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Fast Turnaround</h4>
                    <p class="text-xs text-neutral-500 mt-0.5 font-light">Efficient processing and prompt execution</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 text-brand-primary shadow-3xs">
                    <i class="fa-solid fa-award text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Premium Quality</h4>
                    <p class="text-xs text-neutral-500 mt-0.5 font-light">Curated to meet rigorous industry standards</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 text-brand-primary shadow-3xs">
                    <i class="fa-solid fa-headset text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Dedicated Support</h4>
                    <p class="text-xs text-neutral-500 mt-0.5 font-light">Expert assistance whenever you need it</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 text-brand-primary shadow-3xs">
                    <i class="fa-solid fa-shield-halved text-base"></i>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-neutral-800">Secure Experience</h4>
                    <p class="text-xs text-neutral-500 mt-0.5 font-light">Safe transactions and complete peace of mind</p>
                </div>
            </div>

        </div>
    </div>
</div>
