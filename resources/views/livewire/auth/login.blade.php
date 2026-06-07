<div class="flex min-h-screen bg-[radial-gradient(133.44%_100%_at_50%_0%,_#2D251E_0%,_#1A1612_100%)]">
    <!-- Deep Premium Form Side -->
    <div class="flex-1 flex justify-center items-center px-6 dark">
        <div class="w-full max-w-sm space-y-6">
            <div class="flex flex-col items-center justify-center space-y-3">
                <a href="{{ route('home') }}" class="group flex items-center transition duration-300 transform hover:scale-105">
                    <img src="{{ asset('images/Logo-Crown.svg') }}" alt="Logo" class="w-12 h-12">
                </a>
                <flux:heading class="text-center font-black text-white tracking-tight" size="xl">Ollo, Welcome back</flux:heading>
            </div>

            <form class="flex flex-col gap-5" wire:submit="login">
                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    :value="old('email')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                    wire:model.defer="email"
                />

                <!-- Password -->
                <div class="relative">
                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Password')"
                        viewable
                        wire:model.defer="password"
                    />

                    <flux:link class="absolute top-0 end-0 text-xs font-bold text-[#e9a35d] hover:text-white transition" href="{{route('password.request')}}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                </div>

                <flux:checkbox label="Remember me for 30 days" class="text-xs text-stone-300" />

                <div class="flex items-center justify-end pt-1">
                    <flux:button type="submit" variant="primary" class="w-full bg-[#e9a35d] hover:bg-amber-500 text-[#1A1612] font-black py-3 rounded-xl border-none transition shadow-xs" data-test="register-user-button">
                        <flux:icon.loading wire:loading wire:target="login" />
                        <span wire:loading.remove wire:target="login" class="text-xs tracking-wide uppercase">{{ __('Login') }}</span>
                    </flux:button>
                </div>
            </form>

            <flux:separator text="or" class="text-stone-500 text-xs font-bold uppercase tracking-wider" />

            <div class="space-y-4">
                <flux:button class="w-full bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold rounded-xl py-3 text-xs transition">
                    <x-slot name="icon">
                        <svg width="20" height="20" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-1">
                            <path d="M23.06 12.25C23.06 11.47 22.99 10.72 22.86 10H12.5V14.26H18.42C18.16 15.63 17.38 16.79 16.21 17.57V20.34H19.78C21.86 18.42 23.06 15.6 23.06 12.25Z" fill="#4285F4"/>
                            <path d="M12.4997 23C15.4697 23 17.9597 22.02 19.7797 20.34L16.2097 17.57C15.2297 18.23 13.9797 18.63 12.4997 18.63C9.63969 18.63 7.20969 16.7 6.33969 14.1H2.67969V16.94C4.48969 20.53 8.19969 23 12.4997 23Z" fill="#34A853"/>
                            <path d="M6.34 14.0899C6.12 13.4299 5.99 12.7299 5.99 11.9999C5.99 11.2699 6.12 10.5699 6.34 9.90995V7.06995H2.68C1.93 8.54995 1.5 10.2199 1.5 11.9999C1.5 13.7799 1.93 15.4499 2.68 16.9299L5.53 14.7099L6.34 14.0899Z" fill="#FBBC05"/>
                            <path d="M12.4997 5.38C14.1197 5.38 15.5597 5.94 16.7097 7.02L19.8597 3.87C17.9497 2.09 15.4697 1 12.4997 1C8.19969 1 4.48969 3.47 2.67969 7.07L6.33969 9.91C7.20969 7.31 9.63969 5.38 12.4997 5.38Z" fill="#EA4335"/>
                        </svg>
                    </x-slot>
                    Continue with Google
                </flux:button>
            </div>

            <flux:subheading class="text-center text-xs font-medium text-stone-400">
                First time around here?
                <flux:link href="{{route('signup')}}" wire:navigate class="font-bold text-[#e9a35d] hover:underline ml-1">
                    Sign up for free
                </flux:link>
            </flux:subheading>
        </div>
    </div>

    <!-- Image Billboard Side -->
    <div class="flex-1 p-5 max-lg:hidden">
        <div class="text-white relative rounded-[2rem] h-full w-full bg-stone-950 flex flex-col items-start justify-end p-16 overflow-hidden border border-white/5 shadow-xs">
            <div class="absolute inset-0">
                <!-- Rich vignette layer overlaying image asset -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#1A1612] via-[#1A1612]/50 to-transparent z-10"></div>
                <div class="absolute inset-0 transform scale-105 transition duration-700 hover:scale-100"
                     style="background-image: url('{{ asset('images/aurora-2.jpg') }}'); background-size: cover; background-position: center;">
                </div>
            </div>

            <!-- Content Area overlaying image -->
            <div class="relative z-20 space-y-4 max-w-lg">
                <div class="flex gap-1 p-1 bg-white/5 border border-white/10 rounded-xl w-fit backdrop-blur-sm">
                    <flux:icon.star variant="solid" class="text-[#e9a35d] w-4 h-4"/>
                    <flux:icon.star variant="solid" class="text-[#e9a35d] w-4 h-4"/>
                    <flux:icon.star variant="solid" class="text-[#e9a35d] w-4 h-4"/>
                    <flux:icon.star variant="solid" class="text-[#e9a35d] w-4 h-4"/>
                    <flux:icon.star variant="solid" class="text-[#e9a35d] w-4 h-4"/>
                </div>

                <div class="font-black text-white text-3xl xl:text-4xl leading-tight tracking-tight">
                    Enabling businesses to grow revenue and reach customers everywhere
                </div>
            </div>
        </div>
    </div>
</div>
