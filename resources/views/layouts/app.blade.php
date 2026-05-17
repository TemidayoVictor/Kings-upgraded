<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        {{-- Tailwind Css  --}}
        @vite('resources/css/app.css')
        @fluxAppearance
        @livewireStyles
        {{--    Using Inter Font Family    --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo-Crown.svg') }}">
        <title>KING'S | {{ $title ?? ''  }} </title>
    </head>
    <body x-data>
        <div>
            {{-- Toast from notify --}}
            <x-toast position="top-right" duration="5000" />
            @if(session('impersonator_id'))
                <div class="w-full bg-gradient-to-r from-yellow-500/20 via-yellow-400/10 to-yellow-500/20 border-b border-yellow-500/30">
                    <div class="max-w-7xl mx-auto px-4 py-3 block  sm:flex items-center justify-between">

                        <div class="flex items-center gap-3 text-yellow-200">
                            <!-- Icon -->
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M12 20h.01M12 4h.01" />
                            </svg>

                            <div class="text-sm">
                                You are currently impersonating another user
                                <span class="text-yellow-300 font-semibold">— actions are being performed on their behalf</span>
                            </div>
                        </div>

                        <a href="{{ route('stop-impersonator') }}"
                           class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-yellow-400 text-black text-sm font-semibold hover:bg-yellow-300 transition">
                            Exit impersonation
                        </a>

                    </div>
                </div>
            @endif
            {{ $slot }}
        </div>

        {{--  Flux  --}}
        @fluxScripts
        @livewireScripts
        @stack('scripts')

    </body>
</html>
