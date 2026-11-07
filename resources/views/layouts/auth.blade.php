<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo-Crown.svg') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800 font-sans">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            @if(auth()->user()->role == App\Enums\UserType::BRAND)
                @include('partials.brand-menu')
            @elseif(auth()->user()->role == App\Enums\UserType::CLIENT)
                @include('partials.client-menu')
            @elseif(auth()->user()->role == App\Enums\UserType::DROPSHIPPER)
                @include('partials.dropshipper-menu')
            @elseif(auth()->user()->role == App\Enums\UserType::ADMIN)
                @include('partials.admin-menu')
            @endif

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="sparkles" href="{{route('home')}}">
                    {{ __('Explore') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    @include('partials.logout')
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <flux:main>
            <x-toast position="top-right" duration="5000" />
            @if(session('impersonator_id'))
                <div class="w-full bg-gradient-to-r from-yellow-500/20 via-yellow-400/10 to-yellow-500/20 border-b border-yellow-500/30 mb-4">
                    <div class="max-w-7xl mx-auto px-4 py-3 block sm:flex items-center justify-between">

                        <div class="flex items-center gap-3 text-yellow-200">
                            <div class="text-sm">
                                You are currently impersonating another user
                                <span class="text-yellow-300 font-semibold">— actions are being performed on their behalf</span>
                            </div>
                        </div>

                        <a href="{{ route('stop-impersonator') }}"
                           class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg mt-4 sm:mt-0 bg-yellow-400 text-black text-sm font-semibold hover:bg-yellow-300 transition">
                            Exit impersonation
                        </a>

                    </div>
                </div>
            @endif
            {{ $slot }}
        </flux:main>

        @fluxScripts
        @stack('scripts')

        {{-- Flutterwave Inline Library --}}
        <script src="https://checkout.flutterwave.com/v3.js"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('flutterwave-payment', (data) => {
                    console.log(data)
                    openFlutterwaveCheckout(data[0]);
                });
            });
        </script>
    </body>
</html>

