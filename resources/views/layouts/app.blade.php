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

    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet"
    >

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
    @fluxAppearance

    @livewireStyles

    <style>
        @layer base {
            html,
            body {
                width: 100%;
                min-height: 100%;
                margin: 0;
                padding: 0;
                font-family: 'Outfit', sans-serif;
            }

            body {
                overscroll-behavior: none;
                background-color: #17130f;
            }

            .pb-safe {
                padding-bottom: env(safe-area-inset-bottom, 0px);
            }

            .pt-safe {
                padding-top: env(safe-area-inset-top, 0px);
            }
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
