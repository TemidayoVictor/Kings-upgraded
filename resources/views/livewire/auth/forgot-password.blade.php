<div class="flex min-h-screen">
    <div class="flex-1 flex justify-center items-center">
        <div class="w-80 max-w-80 space-y-6">
            <div class="flex flex-col items-center justify-center">
                <a href="{{ route('home') }}" class="group flex items-center gap-3">
                    <img src="{{ asset('images/Logo-Crown.svg') }}" alt="Logo" class="w-12 h-12">
                </a>
                <flux:heading class="text-center" size="xl">Reset your password</flux:heading>
                <p class="text-xs text-neutral-500 text-center mt-2 font-normal">
                    Enter your email address and we will send you a link to change your password.
                </p>
            </div>

            <form class="flex flex-col gap-6" wire:submit.prevent="sendResetLink">
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                    wire:model="email"
                />

                @if(session()->has('message'))
                    <div class="text-xs text-emerald-600 bg-emerald-50 p-3 rounded-lg border border-emerald-100 font-normal">
                        {{ session('message') }}
                    </div>
                @endif

                @error('email')
                <div class="text-xs text-red-600 bg-red-50 p-3 rounded-lg border border-red-100 font-normal">
                    {{ $message }}
                </div>
                @enderror

                <div class="flex items-center justify-end">
                    <flux:button type="submit" variant="primary" class="w-full">
                        <flux:icon.loading wire:loading wire:target="sendResetLink" />
                        <span wire:loading.remove wire:target="sendResetLink">{{ __('Send Reset Link') }}</span>
                    </flux:button>
                </div>
            </form>

            <flux:subheading class="text-center">
                Remember your password? <flux:link href="{{ route('login') }}" wire:navigate>Back to login</flux:link>
            </flux:subheading>
        </div>
    </div>

    <div class="flex-1 p-4 max-lg:hidden">
        <div class="text-white relative rounded-lg h-full w-full bg-zinc-900 flex flex-col items-start justify-end p-16 overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-black/40 z-10"></div>
                <div class="absolute inset-0" style="background-image: url('{{ asset('images/aurora-2.jpg') }}'); background-size: cover"></div>
            </div>

            <div class="relative z-20">
                <div class="flex gap-2 mb-4">
                    <flux:icon.star variant="solid" class="text-[#e9a35d]" />
                    <flux:icon.star variant="solid" class="text-[#e9a35d]" />
                    <flux:icon.star variant="solid" class="text-[#e9a35d]" />
                    <flux:icon.star variant="solid" class="text-[#e9a35d]" />
                    <flux:icon.star variant="solid" class="text-[#e9a35d]" />
                </div>

                <div class="mb-6 italic font-normal text-3xl xl:text-4xl">
                    Enabling businesses to grow revenue and reach customers everywhere
                </div>
            </div>
        </div>
    </div>
</div>
