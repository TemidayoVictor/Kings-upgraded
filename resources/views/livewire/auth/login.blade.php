<div class="flex min-h-screen">
    <div class="flex-1 flex justify-center items-center">
        <div class="w-80 max-w-80 space-y-6">
            <div class="flex flex-col items-center justify-center">
                <a href="{{ route('home')  }}" class="group flex items-center gap-3">
                    <img src="{{ asset('images/Logo-Crown.svg') }}" alt="Logo" class="w-12 h-12">
                </a>
                <flux:heading class="text-center" size="xl">Ollo, Welcome back</flux:heading>
            </div>

            <form class="flex flex-col gap-6" wire:submit="login">
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

                    <flux:link class="absolute top-0 text-sm end-0" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>

                </div>

                <flux:checkbox label="Remember me for 30 days" />

                <div class="flex items-center justify-end">
                    <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                        <flux:icon.loading wire:loading wire:target="login" />
                        <span wire:loading.remove wire:target="login">{{ __('Login') }}</span>
                    </flux:button>
                </div>
            </form>

            <flux:separator text="or" />

            <div class="space-y-4">
                <flux:button class="w-full">
                    <x-slot name="icon">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.06 12.25C23.06 11.47 22.99 10.72 22.86 10H12.5V14.26H18.42C18.16 15.63 17.38 16.79 16.21 17.57V20.34H19.78C21.86 18.42 23.06 15.6 23.06 12.25Z" fill="#4285F4"/>
                            <path d="M12.4997 23C15.4697 23 17.9597 22.02 19.7797 20.34L16.2097 17.57C15.2297 18.23 13.9797 18.63 12.4997 18.63C9.63969 18.63 7.20969 16.7 6.33969 14.1H2.67969V16.94C4.48969 20.53 8.19969 23 12.4997 23Z" fill="#34A853"/>
                            <path d="M6.34 14.0899C6.12 13.4299 5.99 12.7299 5.99 11.9999C5.99 11.2699 6.12 10.5699 6.34 9.90995V7.06995H2.68C1.93 8.54995 1.5 10.2199 1.5 11.9999C1.5 13.7799 1.93 15.4499 2.68 16.9299L5.53 14.7099L6.34 14.0899Z" fill="#FBBC05"/>
                            <path d="M12.4997 5.38C14.1197 5.38 15.5597 5.94 16.7097 7.02L19.8597 3.87C17.9497 2.09 15.4697 1 12.4997 1C8.19969 1 4.48969 3.47 2.67969 7.07L6.33969 9.91C7.20969 7.31 9.63969 5.38 12.4997 5.38Z" fill="#EA4335"/>
                        </svg>
                    </x-slot>

                    Continue with Google
                </flux:button>
            </div>

            <flux:subheading class="text-center">
                First time around here? <flux:link href="{{route('signup')}}" wire:navigate>Sign up for free</flux:link>
            </flux:subheading>
        </div>
    </div>

    <div class="flex-1 p-4 max-lg:hidden">
        <div class="text-white relative rounded-lg h-full w-full bg-zinc-900 flex flex-col items-start justify-end p-16 overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-black/40 z-10"></div> {{-- Dark overlay only on image --}}
                <div class="absolute inset-0"
                     style="background-image: url('{{ asset('images/aurora-2.jpg') }}'); background-size: cover">
                </div>
            </div>

            {{-- Your content - sits above everything --}}
            <div class="relative z-20">
                <div class="flex gap-2 mb-4">
                    <flux:icon.star variant="solid" class="text-[#e9a35d] dark:text-[#e9a35d]"/>
                    <flux:icon.star variant="solid" class="text-[#e9a35d] dark:text-[#e9a35d]"/>
                    <flux:icon.star variant="solid" class="text-[#e9a35d] dark:text-[#e9a35d]"/>
                    <flux:icon.star variant="solid" class="text-[#e9a35d] dark:text-[#e9a35d]"/>
                    <flux:icon.star variant="solid" class="text-[#e9a35d] dark:text-[#e9a35d]"/>
                </div>

                <div class="mb-6 italic font-base text-3xl xl:text-4xl">
                    Enabling businesses to grow revenue and reach customers everywhere
                </div>
            </div>
        </div>
    </div>
</div>

