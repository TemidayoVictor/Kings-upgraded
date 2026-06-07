<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo-Crown.svg') }}">
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
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
    </body>
</html>

