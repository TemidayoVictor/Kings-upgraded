<div class="min-h-screen bg-[var(--surface)] text-[var(--on-surface)] antialiased overflow-x-hidden">

    {{-- Breadcrumb --}}
    <div class="bg-white border-b border-[var(--outline-variant)]/30 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs tracking-wide text-[var(--outline)] flex items-center">
            <a href="{{ route('shop', $brand) }}" class="hover:text-[var(--on-surface)] transition-colors">Shop</a>
            <span class="mx-2 text-[var(--outline-variant)]">/</span>
            <span class="text-[var(--primary)] font-semibold">About us</span>
        </div>
    </div>

    {{-- =========================================================== --}}
    {{-- EDITORIAL HERO                                                --}}
    {{-- =========================================================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <div class="bg-[var(--primary)] rounded-3xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 items-stretch relative isolate">

            {{-- Decorative layers --}}
            <div class="hero-blob-1"></div>
            <div class="hero-blob-2"></div>
            <div class="absolute inset-0 hero-dots opacity-70 pointer-events-none"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-black/20 pointer-events-none"></div>

            {{-- Text column --}}
            <div class="p-8 sm:p-12 lg:p-16 lg:col-span-7 relative z-10 flex flex-col justify-center space-y-6 order-2 lg:order-1">

                <span class="hero-animate-up text-[10px] sm:text-xs font-semibold tracking-[0.25em] uppercase text-white/80 block" style="animation-delay: 0.1s;">
                    {{ $brand->brandSetting->hero_tagline ?? 'Quality collections made for you' }}
                </span>

                <h1 class="hero-animate-up font-editorial text-4xl sm:text-5xl lg:text-6xl tracking-tight text-[var(--secondary)] leading-[1.05]" style="animation-delay: 0.2s;">
                    {{ $brand->brandSetting->hero_title_line_1 ?? 'Designed for your' }}
                    <br>
                    <span class="italic text-white font-normal relative inline-block">
                        {{ $brand->brandSetting->hero_title_line_2_italic ?? 'everyday life.' }}
                        <svg class="absolute -bottom-2 left-0 w-full h-2 text-white/30" viewBox="0 0 200 8" fill="none" preserveAspectRatio="none">
                            <path d="M0 4 Q 50 0, 100 4 T 200 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                </h1>

                <p class="hero-animate-up text-sm sm:text-base text-white/85 max-w-md font-light leading-relaxed" style="animation-delay: 0.35s;">
                    {{ $brand->brandSetting->hero_description ?? 'Discover our premium range of products and services. Crafted with care to give you the best experience possible.' }}
                </p>

                <div class="hero-animate-up pt-2" style="animation-delay: 0.5s;">
                    <a href="{{ route('shop', $brand) }}"
                       class="cta-shimmer group inline-flex items-center gap-3 bg-white text-[var(--primary)] text-xs font-semibold tracking-widest uppercase px-8 py-4 rounded-full hover:bg-[var(--secondary)] hover:text-white transition-all duration-300 shadow-lg hover:shadow-2xl hover:-translate-y-0.5">
                        <span class="relative z-10">{{ $brand->brandSetting->hero_button_text ?? 'Explore More' }}</span>
                        <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1 relative z-10"></i>
                    </a>
                </div>
            </div>

            {{-- Visual column --}}
            <div class="hero-animate-right block lg:col-span-5 h-64 sm:h-80 lg:h-full relative self-stretch overflow-hidden order-1 lg:order-2 min-h-[320px]" style="animation-delay: 0.3s;">
                @if($brand->image)
                    <img src="{{ asset('storage/' . $brand->image) }}"
                         alt="{{ $brand->brand_name }} brand showcase"
                         class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-[1200ms] ease-out hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-[var(--primary)]/40 to-transparent lg:hidden"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-[var(--primary)]/30 to-transparent hidden lg:block pointer-events-none"></div>

                    {{-- Floating accent badge --}}
                    <div class="absolute top-6 right-6 z-10 hidden sm:flex items-center gap-2 bg-white/95 backdrop-blur-sm rounded-full pl-3 pr-4 py-2 shadow-xl border border-white/40" style="animation: float 4s ease-in-out infinite;">
                        <span class="w-2 h-2 rounded-full bg-[var(--secondary)]"></span>
                        <span class="text-[10px] font-semibold uppercase tracking-widest text-[var(--on-surface)]">Featured</span>
                    </div>
                @else
                    <div class="absolute inset-0 flex items-center justify-center p-6 sm:p-12 bg-white/5">
                        <div class="w-full h-full rounded-2xl sm:rounded-3xl border border-white/20 bg-gradient-to-b from-white/10 to-transparent backdrop-blur-md shadow-2xl flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,0.1),transparent_60%)]"></div>
                            <i class="fa-solid fa-wand-magic-sparkles text-5xl sm:text-7xl text-[var(--secondary)] opacity-80 relative z-10" style="animation: pulse 4s ease-in-out infinite;"></i>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Scroll hint --}}
            <div class="hidden lg:flex absolute bottom-6 left-1/2 -translate-x-1/2 z-10 flex-col items-center gap-1.5 text-white/40">
                <span class="text-[9px] uppercase tracking-[0.3em] font-semibold">Scroll</span>
                <i class="fa-solid fa-chevron-down text-xs scroll-indicator"></i>
            </div>
        </div>
    </div>

    {{-- =========================================================== --}}
    {{-- BRAND PROFILE                                                 --}}
    {{-- =========================================================== --}}
    <section class="max-w-4xl mx-auto px-4 sm:px-6 pt-16 sm:pt-24 pb-10">

        <div class="reveal text-center space-y-4 pb-10 border-b border-[var(--outline-variant)]/30">
            {{-- Ornamental divider --}}
            <div class="ornament-divider mb-2">
                <span class="ornament-dot"></span>
            </div>

            <span class="text-[10px] sm:text-xs font-semibold uppercase tracking-[0.28em] text-[var(--outline)] block">
                Brand Profile
            </span>

            <h2 class="font-editorial text-4xl sm:text-5xl lg:text-6xl tracking-tight text-[var(--on-surface)] leading-[1.05]">
                About <span class="text-[var(--primary)] relative inline-block">
                    {{ $brand->brand_name }}
                    <span class="absolute bottom-1 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[var(--secondary)] to-transparent opacity-60"></span>
                </span>
            </h2>

            @if($brand->motto)
                <div class="inline-block mt-3 px-6 py-2.5 rounded-full bg-white border border-[var(--outline-variant)]/30 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
                    <span class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-[var(--secondary)] to-transparent"></span>
                    <p class="text-sm sm:text-base italic text-[var(--secondary)] font-medium relative">
                        &ldquo;{{ $brand->motto }}&rdquo;
                    </p>
                </div>
            @endif
        </div>

        @if($brand->about || $brand->description)
            <div class="reveal pt-10" style="transition-delay: 0.1s;">
                <div class="about-prose">
                    {!! $brand->about ?? $brand->description !!}
                </div>
            </div>
        @endif
    </section>

    {{-- =========================================================== --}}
    {{-- CONTACT                                                       --}}
    {{-- =========================================================== --}}
    <section class="max-w-4xl mx-auto px-4 sm:px-6 pb-16">
        <div class="reveal bg-white rounded-3xl p-6 sm:p-10 border border-[var(--outline-variant)]/30 shadow-sm space-y-8 relative overflow-hidden">

            {{-- Corner accent --}}
            <div class="absolute -top-20 -right-20 w-40 h-40 rounded-full bg-[var(--secondary)]/5 blur-2xl pointer-events-none"></div>

            <div class="space-y-2 text-center relative">
                <span class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[var(--outline)] block">
                    Connect
                </span>
                <h2 class="font-editorial text-2xl sm:text-3xl text-[var(--on-surface)] tracking-tight">
                    Get in Touch
                </h2>
                <div class="h-0.5 bg-[var(--secondary)] mx-auto mt-1 rounded-full" style="width: 48px;"></div>
                <p class="text-xs sm:text-sm text-[var(--outline)] font-light pt-2">
                    Have questions or want to reach out? Contact our team directly.
                </p>
            </div>

            {{-- Channels --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 border-t border-[var(--outline-variant)]/30 relative">
                @if($brand->brand_email)
                    <div class="space-y-2">
                        <span class="text-[10px] font-semibold uppercase tracking-widest text-[var(--outline)] block">
                            Email Us
                        </span>
                        <a href="mailto:{{ $brand->brand_email }}"
                           class="inline-flex items-center gap-2 text-sm font-medium text-[var(--on-surface)] hover:text-[var(--primary)] underline-offset-4 hover:underline transition-all break-all">
                            <span class="w-8 h-8 rounded-full bg-[var(--surface-low)] text-[var(--primary)] flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-envelope text-xs"></i>
                            </span>
                            {{ $brand->brand_email }}
                        </a>
                    </div>
                @endif

                @if($brand->city || $brand->state || $brand->address)
                    <div class="space-y-2">
                        <span class="text-[10px] font-semibold uppercase tracking-widest text-[var(--outline)] block">
                            Our Location
                        </span>
                        <div class="flex items-start gap-2 text-sm font-medium text-[var(--on-surface)]">
                            <span class="w-8 h-8 rounded-full bg-[var(--surface-low)] text-[var(--primary)] flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-location-dot text-xs"></i>
                            </span>
                            <p class="leading-relaxed">
                                {{ $brand->address ? $brand->address . ', ' : '' }}
                                {{ $brand->city }}{{ $brand->city && $brand->state ? ', ' : '' }}
                                {{ $brand->state }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Socials --}}
            @if($brand->instagram || $brand->facebook || $brand->twitter || $brand->youtube || $brand->tiktok || $brand->linkedin || $brand->website)
                <div class="pt-6 border-t border-[var(--outline-variant)]/30 space-y-4 relative">
                    <span class="text-[10px] font-semibold uppercase tracking-widest text-[var(--outline)] block">
                        Connect Globally
                    </span>
                    <div class="flex flex-wrap gap-2">

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $brand->brand_email) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="social-btn inline-flex items-center gap-2 pl-1.5 pr-4 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200/60 text-xs font-semibold text-emerald-700 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 active:scale-95">
                            <span class="w-7 h-7 rounded-lg bg-emerald-600/10 flex items-center justify-center">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                            </span>
                            <span>WhatsApp</span>
                        </a>

                        @if($brand->instagram)
                            <a href="https://instagram.com/{{ trim($brand->instagram, '@') }}" target="_blank" rel="noopener noreferrer"
                               class="social-btn inline-flex items-center gap-2 pl-1.5 pr-4 py-1.5 rounded-xl bg-[var(--surface-low)] border border-[var(--outline-variant)]/30 text-xs font-medium text-[var(--on-surface-variant)] hover:bg-[var(--primary)] hover:text-white hover:border-[var(--primary)] active:scale-95">
                                <span class="w-7 h-7 rounded-lg bg-white/60 flex items-center justify-center">
                                    <i class="fa-brands fa-instagram text-sm"></i>
                                </span>
                                <span>Instagram</span>
                            </a>
                        @endif

                        @if($brand->facebook)
                            <a href="{{ $brand->facebook }}" target="_blank" rel="noopener noreferrer"
                               class="social-btn inline-flex items-center gap-2 pl-1.5 pr-4 py-1.5 rounded-xl bg-[var(--surface-low)] border border-[var(--outline-variant)]/30 text-xs font-medium text-[var(--on-surface-variant)] hover:bg-[var(--primary)] hover:text-white hover:border-[var(--primary)] active:scale-95">
                                <span class="w-7 h-7 rounded-lg bg-white/60 flex items-center justify-center">
                                    <i class="fa-brands fa-facebook-f text-sm"></i>
                                </span>
                                <span>Facebook</span>
                            </a>
                        @endif

                        @if($brand->twitter)
                            <a href="https://twitter.com/{{ trim($brand->twitter, '@') }}" target="_blank" rel="noopener noreferrer"
                               class="social-btn inline-flex items-center gap-2 pl-1.5 pr-4 py-1.5 rounded-xl bg-[var(--surface-low)] border border-[var(--outline-variant)]/30 text-xs font-medium text-[var(--on-surface-variant)] hover:bg-[var(--primary)] hover:text-white hover:border-[var(--primary)] active:scale-95">
                                <span class="w-7 h-7 rounded-lg bg-white/60 flex items-center justify-center">
                                    <i class="fa-brands fa-x-twitter text-sm"></i>
                                </span>
                                <span>Twitter</span>
                            </a>
                        @endif

                        @if($brand->tiktok)
                            <a href="https://tiktok.com/@{{ trim($brand->tiktok, '@') }}" target="_blank" rel="noopener noreferrer"
                               class="social-btn inline-flex items-center gap-2 pl-1.5 pr-4 py-1.5 rounded-xl bg-[var(--surface-low)] border border-[var(--outline-variant)]/30 text-xs font-medium text-[var(--on-surface-variant)] hover:bg-[var(--primary)] hover:text-white hover:border-[var(--primary)] active:scale-95">
                                <span class="w-7 h-7 rounded-lg bg-white/60 flex items-center justify-center">
                                    <i class="fa-brands fa-tiktok text-sm"></i>
                                </span>
                                <span>TikTok</span>
                            </a>
                        @endif

                        @if($brand->youtube)
                            <a href="{{ $brand->youtube }}" target="_blank" rel="noopener noreferrer"
                               class="social-btn inline-flex items-center gap-2 pl-1.5 pr-4 py-1.5 rounded-xl bg-[var(--surface-low)] border border-[var(--outline-variant)]/30 text-xs font-medium text-[var(--on-surface-variant)] hover:bg-[var(--primary)] hover:text-white hover:border-[var(--primary)] active:scale-95">
                                <span class="w-7 h-7 rounded-lg bg-white/60 flex items-center justify-center">
                                    <i class="fa-brands fa-youtube text-sm"></i>
                                </span>
                                <span>YouTube</span>
                            </a>
                        @endif

                        @if($brand->linkedin)
                            <a href="{{ $brand->linkedin }}" target="_blank" rel="noopener noreferrer"
                               class="social-btn inline-flex items-center gap-2 pl-1.5 pr-4 py-1.5 rounded-xl bg-[var(--surface-low)] border border-[var(--outline-variant)]/30 text-xs font-medium text-[var(--on-surface-variant)] hover:bg-[var(--primary)] hover:text-white hover:border-[var(--primary)] active:scale-95">
                                <span class="w-7 h-7 rounded-lg bg-white/60 flex items-center justify-center">
                                    <i class="fa-brands fa-linkedin-in text-sm"></i>
                                </span>
                                <span>LinkedIn</span>
                            </a>
                        @endif

                        @if($brand->website)
                            <a href="{{ $brand->website }}" target="_blank" rel="noopener noreferrer"
                               class="social-btn inline-flex items-center gap-2 pl-1.5 pr-4 py-1.5 rounded-xl bg-[var(--surface-low)] border border-[var(--outline-variant)]/30 text-xs font-medium text-[var(--on-surface-variant)] hover:bg-[var(--primary)] hover:text-white hover:border-[var(--primary)] active:scale-95">
                                <span class="w-7 h-7 rounded-lg bg-white/60 flex items-center justify-center">
                                    <i class="fa-solid fa-globe text-sm"></i>
                                </span>
                                <span>Main Website</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- FEATURES STRIP                                                --}}
    {{-- =========================================================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="reveal relative overflow-hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 bg-[var(--secondary)] p-6 sm:p-8 rounded-3xl border border-[var(--outline-variant)]/20">

            {{-- Subtle pattern --}}
            <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 20px 20px;"></div>

            @foreach([
                ['fa-bolt', 'Fast Turnaround', 'Efficient processing and prompt execution'],
                ['fa-award', 'Premium Quality', 'Curated to meet rigorous industry standards'],
                ['fa-headset', 'Dedicated Support', 'Expert assistance whenever you need it'],
                ['fa-shield-halved', 'Secure Experience', 'Safe transactions and complete peace of mind'],
            ] as $i => [$icon, $title, $copy])
                <div class="feature-card reveal flex items-center gap-4 relative" style="transition-delay: {{ $i * 80 }}ms;">
                    <div class="feature-icon w-12 h-12 rounded-2xl bg-white text-[var(--primary)] flex items-center justify-center shrink-0 shadow-sm">
                        <i class="fa-solid {{ $icon }} text-base"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold uppercase tracking-wider text-white">{{ $title }}</h4>
                        <p class="text-xs text-white/70 mt-0.5 font-light leading-relaxed">{{ $copy }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- =========================================================== --}}
    {{-- STYLES + SCRIPTS                                              --}}
    {{-- =========================================================== --}}
    <style>
        /* ============ ANIMATION KEYFRAMES ============ */
        @keyframes fadeSlideUp    { from { opacity: 0; transform: translateY(30px);  } to { opacity: 1; transform: translateY(0);  } }
        @keyframes fadeSlideLeft  { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0);  } }
        @keyframes fadeSlideRight { from { opacity: 0; transform: translateX(30px);  } to { opacity: 1; transform: translateX(0);  } }
        @keyframes fadeScale      { from { opacity: 0; transform: scale(0.92);       } to { opacity: 1; transform: scale(1);       } }
        @keyframes shimmer        { 0% { left: -100%; } 100% { left: 100%; } }
        @keyframes float          { 0%,100% { transform: translateY(0) rotate(0);    } 50% { transform: translateY(-8px) rotate(2deg); } }
        @keyframes floatSlow      { 0%,100% { transform: translateY(0) scale(1);     } 50% { transform: translateY(-25px) scale(1.08); } }
        @keyframes pulse          { 0%,100% { opacity: .4; transform: scale(1);      } 50% { opacity: .85; transform: scale(1.05);     } }
        @keyframes bounceDown     { 0%,100% { transform: translateY(0);              } 50% { transform: translateY(6px);                 } }

        /* ============ HERO (above-fold) ============ */
        .hero-animate-up    { opacity: 0; animation: fadeSlideUp    0.9s cubic-bezier(0.16,1,0.3,1) forwards; }
        .hero-animate-left  { opacity: 0; animation: fadeSlideLeft  0.9s cubic-bezier(0.16,1,0.3,1) forwards; }
        .hero-animate-right { opacity: 0; animation: fadeSlideRight 1.0s cubic-bezier(0.16,1,0.3,1) forwards; }
        .hero-animate-scale { opacity: 0; animation: fadeScale      0.8s cubic-bezier(0.16,1,0.3,1) forwards; }

        /* ============ SCROLL REVEAL (below-fold) ============ */
        .reveal {
            opacity: 0; transform: translateY(40px);
            transition: opacity 0.9s cubic-bezier(0.16,1,0.3,1),
            transform 0.9s cubic-bezier(0.16,1,0.3,1);
        }
        .reveal.revealed { opacity: 1; transform: translateY(0); }

        /* ============ HERO DECOR ============ */
        .hero-dots {
            background-image: radial-gradient(circle, rgba(255,255,255,0.16) 1px, transparent 1px);
            background-size: 24px 24px;
            mask-image: radial-gradient(ellipse 85% 65% at 50% 50%, black 40%, transparent 100%);
            -webkit-mask-image: radial-gradient(ellipse 85% 65% at 50% 50%, black 40%, transparent 100%);
        }
        .hero-blob-1 {
            position: absolute; top: -100px; right: -100px;
            width: 420px; height: 420px; border-radius: 50%;
            background: var(--secondary); opacity: 0.18;
            filter: blur(90px); pointer-events: none;
            animation: floatSlow 9s ease-in-out infinite;
        }
        .hero-blob-2 {
            position: absolute; bottom: -120px; left: -60px;
            width: 360px; height: 360px; border-radius: 50%;
            background: var(--secondary); opacity: 0.12;
            filter: blur(100px); pointer-events: none;
            animation: floatSlow 11s ease-in-out infinite reverse;
        }

        /* ============ SHIMMER CTA ============ */
        .cta-shimmer { position: relative; overflow: hidden; }
        .cta-shimmer::after {
            content: '';
            position: absolute; top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
            animation: shimmer 3.2s ease-in-out infinite;
            animation-delay: 2s;
            pointer-events: none;
        }

        /* ============ ORNAMENTAL DIVIDER ============ */
        .ornament-divider {
            display: flex; align-items: center; justify-content: center; gap: 1rem;
        }
        .ornament-divider::before,
        .ornament-divider::after {
            content: ''; height: 1px; flex: 1; max-width: 80px;
            background: linear-gradient(to right, transparent, var(--outline-variant));
        }
        .ornament-divider::after {
            background: linear-gradient(to left, transparent, var(--outline-variant));
        }
        .ornament-divider .ornament-dot {
            width: 6px; height: 6px; transform: rotate(45deg);
            background: var(--secondary);
            box-shadow: 0 0 0 4px rgba(120, 89, 40, 0.08);
        }

        /* ============ SOCIAL BUTTON ============ */
        .social-btn {
            transition: transform 0.3s cubic-bezier(0.16,1,0.3,1),
            box-shadow 0.3s cubic-bezier(0.16,1,0.3,1),
            background-color 0.25s ease,
            border-color 0.25s ease,
            color 0.25s ease;
        }
        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px -8px rgba(0,0,0,0.15);
        }

        /* ============ FEATURE CARD ============ */
        .feature-card {
            transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
        }
        .feature-card:hover { transform: translateY(-4px); }
        .feature-icon {
            transition: transform 0.4s cubic-bezier(0.16,1,0.3,1),
            background-color 0.3s ease,
            color 0.3s ease;
        }
        .feature-card:hover .feature-icon {
            transform: rotate(-8deg) scale(1.08);
            background: var(--primary);
            color: white;
        }

        /* ============ SCROLL HINT ============ */
        .scroll-indicator { animation: bounceDown 2s ease-in-out infinite; }

        /* ============ ABOUT PROSE ============ */
        .about-prose {
            font-size: 1.0625rem; line-height: 1.8;
            color: var(--on-surface-variant);
            font-weight: 300; letter-spacing: 0.005em;
        }
        .about-prose :where(p) { margin-bottom: 1.25rem; }
        .about-prose :where(h1,h2,h3,h4,h5,h6) {
            font-family: 'Bodoni Moda', serif; color: var(--on-surface);
            margin-top: 2rem; margin-bottom: 1rem; font-weight: 400;
            letter-spacing: -0.01em; line-height: 1.15;
        }
        .about-prose :where(h1) { font-size: 2.25rem; }
        .about-prose :where(h2) { font-size: 1.75rem; }
        .about-prose :where(h3) { font-size: 1.35rem; }
        .about-prose :where(h4) { font-size: 1.15rem; }
        .about-prose :where(a) {
            color: var(--primary); text-decoration: underline;
            text-underline-offset: 3px;
            text-decoration-color: var(--outline-variant);
            transition: text-decoration-color 0.2s ease;
        }
        .about-prose :where(a:hover) { text-decoration-color: var(--primary); }
        .about-prose :where(ul,ol) { padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .about-prose :where(ul) { list-style-type: disc; }
        .about-prose :where(ol) { list-style-type: decimal; }
        .about-prose :where(li) { margin-bottom: 0.5rem; }
        .about-prose :where(strong,b) { color: var(--on-surface); font-weight: 600; }
        .about-prose :where(em,i) { font-style: italic; }
        .about-prose :where(blockquote) {
            border-left: 3px solid var(--secondary);
            padding: 0.5rem 0 0.5rem 1.25rem;
            font-style: italic; color: var(--on-surface);
            margin: 1.5rem 0;
            font-family: 'Bodoni Moda', serif; font-size: 1.125rem;
        }
        .about-prose :where(img) { border-radius: 0.75rem; margin: 1.5rem 0; max-width: 100%; height: auto; }
        .about-prose :where(hr) { border: none; border-top: 1px solid var(--outline-variant); margin: 2rem 0; opacity: 0.5; }
        .about-prose :where(table) { width: 100%; border-collapse: collapse; margin: 1.5rem 0; font-size: 0.875rem; }
        .about-prose :where(th,td) { padding: 0.5rem 0.75rem; border-bottom: 1px solid var(--outline-variant); text-align: left; }
        .about-prose :where(th) { color: var(--on-surface); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; }

        /* ============ REDUCED MOTION ============ */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            .reveal, .hero-animate-up, .hero-animate-left,
            .hero-animate-right, .hero-animate-scale { opacity: 1; transform: none; }
        }
    </style>

    <script>
        (function () {
            function initReveals() {
                if (!('IntersectionObserver' in window)) {
                    document.querySelectorAll('.reveal').forEach(el => el.classList.add('revealed'));
                    return;
                }
                const io = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('revealed');
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

                document.querySelectorAll('.reveal:not(.revealed)').forEach(el => io.observe(el));
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initReveals);
            } else {
                initReveals();
            }
            document.addEventListener('livewire:navigated', initReveals);
        })();
    </script>
</div>
