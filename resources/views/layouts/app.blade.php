<!doctype html>
<html class="dark" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>KING'S | {{ $title ?? '' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo-Crown.svg') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        /* ---- Validation error slide-in ---- */
        @keyframes error-slide {
            from {
                opacity: 0;
                transform: translateY(-4px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .error-message {
            animation: error-slide 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>

    {{-- Vite (compiled app CSS) --}}
    @vite('resources/css/app.css')

    {{--
        @fluxAppearance is intentionally OMITTED here.
        This layout forces dark mode. Flux's appearance script can remove the
        `dark` class based on user preference, which would break the design.
        Flux components still render dark (they respond to class="dark" on <html>).
    --}}

    @livewireStyles

    {{-- Tailwind CDN with the dark auth theme tokens --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "outline": "#9f8e80",
                        "primary-fixed": "#ffdcbf",
                        "on-surface": "#eae1da",
                        "on-surface-variant": "#d6c3b4",
                        "surface": "#17130f",
                        "on-error": "#690005",
                        "surface-container-high": "#2e2925",
                        "surface-container-highest": "#39342f",
                        "tertiary-container": "#c0afa1",
                        "on-secondary": "#372f27",
                        "outline-variant": "#524439",
                        "on-tertiary": "#392e25",
                        "on-error-container": "#ffdad6",
                        "surface-tint": "#ffb872",
                        "primary-fixed-dim": "#ffb872",
                        "error": "#ffb4ab",
                        "inverse-on-surface": "#34302b",
                        "on-primary": "#4a2800",
                        "surface-container-low": "#1f1b17",
                        "primary-container": "#e9a35d",
                        "error-container": "#93000a",
                        "surface-variant": "#39342f",
                        "surface-bright": "#3d3833",
                        "background": "#17130f",
                        "secondary-container": "#4f453d",
                        "on-primary-container": "#663900",
                        "surface-container": "#231f1b",
                        "primary": "#ffc186",
                        "tertiary": "#dccabc",
                        "surface-container-lowest": "#110e0a",
                        "secondary": "#d2c4b9",
                        "inverse-surface": "#eae1da",
                        "secondary-fixed-dim": "#d2c4b9"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    spacing: {
                        "space-xl": "2.5rem",
                        "space-md": "1rem",
                        "space-sm": "0.5rem",
                        "space-xs": "0.25rem",
                        "gutter": "1.5rem",
                        "gutter-mobile": "1rem",
                        "space-lg": "1.5rem",
                        "margin": "3rem",
                        "margin-mobile": "1.25rem"
                    },
                    fontFamily: {
                        "display-lg": ["Outfit"],
                        "label-lg": ["Outfit"],
                        "label-sm": ["Outfit"],
                        "label-md": ["Outfit"],
                        "body-sm": ["Outfit"],
                        "body-md": ["Outfit"],
                        "body-lg": ["Outfit"],
                        "headline-lg": ["Outfit"],
                        "headline-sm": ["Outfit"],
                        "headline-md": ["Outfit"]
                    },
                    fontSize: {
                        "display-lg": ["48px", { lineHeight: "56px", letterSpacing: "-0.03em", fontWeight: "600" }],
                        "label-lg": ["14px", { lineHeight: "20px", letterSpacing: "0.04em", fontWeight: "600" }],
                        "label-sm": ["10px", { lineHeight: "14px", letterSpacing: "0.08em", fontWeight: "500" }],
                        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.06em", fontWeight: "500" }],
                        "body-sm": ["14px", { lineHeight: "20px", fontWeight: "400" }],
                        "body-md": ["16px", { lineHeight: "24px", letterSpacing: "-0.01em", fontWeight: "400" }],
                        "body-lg": ["18px", { lineHeight: "28px", letterSpacing: "-0.01em", fontWeight: "400" }],
                        "headline-lg": ["32px", { lineHeight: "40px", letterSpacing: "-0.02em", fontWeight: "600" }],
                        "headline-sm": ["20px", { lineHeight: "28px", letterSpacing: "-0.015em", fontWeight: "500" }],
                        "headline-md": ["24px", { lineHeight: "32px", letterSpacing: "-0.02em", fontWeight: "500" }]
                    }
                }
            }
        }
    </script>

    <style>
        @layer base {
            html, body { width: 100%; min-height: 100%; margin: 0; padding: 0; }
            body { overscroll-behavior: none; background-color: #17130f; }
            .pb-safe { padding-bottom: env(safe-area-inset-bottom, 0px); }
            .pt-safe { padding-top: env(safe-area-inset-top, 0px); }
        }
        ::-webkit-scrollbar { display: none; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body x-data class="bg-surface text-on-surface antialiased min-h-screen flex flex-col relative selection:bg-primary-container selection:text-on-primary-container">

{{-- Fixed radial gradient background --}}
<div class="fixed inset-0 pointer-events-none z-0 bg-[radial-gradient(circle_at_top,_#2D251E_0%,_#1A1612_70%,_#110E0A_100%)]"></div>

{{-- Foreground content (above the gradient) --}}
<div class="relative z-10 flex flex-col flex-1 w-full">

    {{-- Toast from notify --}}
    <x-toast position="top-right" duration="5000" />

    {{-- Impersonation banner --}}
    @if(session('impersonator_id'))
        <div class="w-full bg-gradient-to-r from-yellow-500/20 via-yellow-400/10 to-yellow-500/20 border-b border-yellow-500/30">
            <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3 text-yellow-200">
                    <svg class="w-5 h-5 text-yellow-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M12 20h.01M12 4h.01" />
                    </svg>
                    <div class="text-sm">
                        You are currently impersonating another user
                        <span class="text-yellow-300 font-semibold">— actions are being performed on their behalf</span>
                    </div>
                </div>
                <a href="{{ route('stop-impersonator') }}"
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-yellow-400 text-black text-sm font-semibold hover:bg-yellow-300 transition shrink-0">
                    Exit impersonation
                </a>
            </div>
        </div>
    @endif

    {{-- Page content --}}
    {{ $slot }}
</div>

{{-- Scripts --}}
@fluxScripts
@livewireScripts
@stack('scripts')
</body>
</html>
