<!DOCTYPE html>
<html class="scroll-smooth h-full" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
    <title>KING'S — @yield('title', "KING'S")</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo-Crown.svg') }}" />

    {{-- Fonts + Material Symbols --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#885211",
                        "primary-container": "#e9a35d",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#663900",
                        "primary-fixed": "#ffdcbf",
                        "primary-fixed-dim": "#ffb872",
                        "on-primary-fixed": "#2d1600",
                        "on-primary-fixed-variant": "#6a3b00",
                        "surface-cream": "#fbf9f5",
                        "surface-subtle": "#f4f0e8",
                        "surface-card": "#ffffff",
                        "surface": "#f9f9ff",
                        "surface-container": "#ededf4",
                        "surface-container-low": "#f3f3fa",
                        "surface-container-high": "#e7e8ee",
                        "surface-container-highest": "#e2e2e9",
                        "surface-variant": "#e2e2e9",
                        "on-surface": "#191c20",
                        "on-surface-variant": "#524439",
                        "text-muted": "#71717a",
                        "text-tertiary": "#a1a1aa",
                        "inverse-surface": "#2e3036",
                        "inverse-on-surface": "#f0f0f7",
                        "inverse-primary": "#ffb872",
                        "status-success": "#15803d",
                        "status-warning": "#c2410c",
                        "border-hairline": "#e4dfd7",
                        "outline": "#847467",
                        "outline-variant": "#d6c3b4",
                        "tertiary": "#8b500b",
                        "tertiary-container": "#eda159",
                        "tertiary-fixed": "#ffdcc0",
                        "tertiary-fixed-dim": "#ffb877",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#683800",
                        "secondary": "#5e5e62",
                        "secondary-container": "#e3e2e6",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#646468",
                        "error": "#ba1a1a",
                    },
                    borderRadius: {
                        DEFAULT: "0.125rem",
                        lg: "0.25rem",
                        xl: "0.5rem",
                        "2xl": "1rem",
                        full: "0.75rem",
                    },
                    spacing: {
                        margin: "3rem",
                        "margin-mobile": "1.25rem",
                        gutter: "1.5rem",
                        "gutter-mobile": "1rem",
                        "space-xs": "0.25rem",
                        "space-sm": "0.5rem",
                        "space-md": "1rem",
                        "space-lg": "1.5rem",
                        "space-xl": "2.5rem",
                    },
                    fontFamily: {
                        display: ["Newsreader", "serif"],
                        sans: ["Plus Jakarta Sans", "sans-serif"],
                        "display-xl": ["Newsreader"],
                        "display-xl-mobile": ["Newsreader"],
                        "headline-lg": ["Newsreader"],
                        "headline-lg-mobile": ["Newsreader"],
                        "headline-md": ["Plus Jakarta Sans"],
                        "headline-sm": ["Plus Jakarta Sans"],
                        "body-lg": ["Outfit"],
                        "body-md": ["Outfit"],
                        "body-sm": ["Outfit"],
                        "label-lg": ["Plus Jakarta Sans"],
                        "label-md": ["Plus Jakarta Sans"],
                        "label-sm": ["Plus Jakarta Sans"],
                        "currency-display": ["Plus Jakarta Sans"],
                    },
                    fontSize: {
                        "display-xl": ["56px", { lineHeight: "64px", letterSpacing: "-0.02em", fontWeight: "400" }],
                        "display-xl-mobile": ["38px", { lineHeight: "44px", letterSpacing: "-0.01em", fontWeight: "400" }],
                        "headline-lg": ["36px", { lineHeight: "44px", letterSpacing: "-0.015em", fontWeight: "500" }],
                        "headline-lg-mobile": ["28px", { lineHeight: "34px", letterSpacing: "-0.01em", fontWeight: "500" }],
                        "headline-md": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "headline-sm": ["20px", { lineHeight: "28px", letterSpacing: "-0.005em", fontWeight: "600" }],
                        "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }],
                        "body-md": ["15px", { lineHeight: "24px", fontWeight: "400" }],
                        "body-sm": ["13px", { lineHeight: "20px", fontWeight: "400" }],
                        "label-lg": ["14px", { lineHeight: "20px", letterSpacing: "0.01em", fontWeight: "600" }],
                        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.04em", fontWeight: "600" }],
                        "label-sm": ["11px", { lineHeight: "14px", letterSpacing: "0.06em", fontWeight: "700" }],
                        "currency-display": ["28px", { lineHeight: "34px", letterSpacing: "-0.02em", fontWeight: "700" }],
                    }
                }
            }
        }
    </script>

    <style>
        @layer base {
            html, body { margin: 0; padding: 0; }
            body { overscroll-behavior: none; }
            main > :first-child { margin-top: 0 !important; }
            main > :last-child { margin-bottom: 0 !important; }
            .pb-safe { padding-bottom: env(safe-area-inset-bottom, 0px); }
            .pt-safe { padding-top: env(safe-area-inset-top, 0px); }
        }
        ::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        @media (max-width: 1023px) {
            body { padding-bottom: 76px; }
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-surface-cream text-on-surface font-sans antialiased flex flex-col min-h-screen selection:bg-primary-container selection:text-on-surface">

<x-site-header/>

{{-- ==================== MAIN CONTENT ==================== --}}
<main class="flex-1 w-full pt-16 lg:pt-20 bg-surface-cream min-h-screen">
    @yield('content')
</main>

<x-site-footer/>

{{-- ==================== MOBILE BOTTOM NAV ==================== --}}
<nav class="lg:hidden fixed bottom-0 inset-x-0 z-50 pb-safe bg-surface-cream/95 backdrop-blur-xl shadow-[0_-4px_16px_rgba(0,0,0,0.03)]">
    <div class="flex justify-around items-center h-16 px-space-xs">
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-1 min-w-[64px] h-12 transition-all {{ request()->routeIs('home') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-[22px]">storefront</span>
            <span class="font-label-sm text-label-sm tracking-tight">Home</span>
        </a>
        <a href="{{ route('brands') }}" class="flex flex-col items-center justify-center gap-1 min-w-[64px] h-12 transition-all {{ request()->routeIs('brands') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-[22px]">domain</span>
            <span class="font-label-sm text-label-sm tracking-tight">Brands</span>
        </a>
        <a href="{{ route('sales') }}" class="flex flex-col items-center justify-center gap-1 min-w-[64px] h-12 transition-all {{ request()->routeIs('sales') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-[22px]">trending_up</span>
            <span class="font-label-sm text-label-sm tracking-tight">Sales Hub</span>
        </a>
        <a href="{{ route('features') }}" class="flex flex-col items-center justify-center gap-1 min-w-[64px] h-12 transition-all {{ request()->routeIs('features') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-[22px]">widgets</span>
            <span class="font-label-sm text-label-sm tracking-tight">Features</span>
        </a>
        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="flex flex-col items-center justify-center gap-1 min-w-[64px] h-12 transition-all {{ request()->routeIs('dashboard') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-[22px]">dashboard</span>
            <span class="font-label-sm text-label-sm tracking-tight">Portal</span>
        </a>
    </div>
</nav>

@livewireScripts
@stack('scripts')
</body>
</html>
