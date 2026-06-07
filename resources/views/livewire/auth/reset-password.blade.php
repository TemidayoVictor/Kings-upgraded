<div class="flex min-h-screen bg-[#1A1612]">
    <!-- Deep Premium Form Side -->
    <div class="flex-1 flex justify-center items-center px-6 dark">
        <div class="w-full max-w-sm space-y-6">
            <div class="flex flex-col items-center justify-center space-y-3">
                <a href="{{ route('home') }}" class="group flex items-center transition duration-300 transform hover:scale-105">
                    <img src="{{ asset('images/Logo-Crown.svg') }}" alt="Logo" class="w-12 h-12">
                </a>
                <flux:heading class="text-center font-black text-white tracking-tight" size="xl">Choose new password</flux:heading>
                <p class="text-xs text-stone-400 text-center font-medium max-w-xs leading-relaxed">
                    Please enter and confirm your new account password below.
                </p>
            </div>

            <form class="flex flex-col gap-5" wire:submit.prevent="resetPassword">
                <!-- Hidden Token & Email Infrastructure -->
                <input type="hidden" wire:model="token">
                <input type="hidden" wire:model="email">

                <!-- New Password -->
                <flux:input
                    name="password"
                    :label="__('New Password')"
                    type="password"
                    required
                    placeholder="Minimum 8 characters"
                    viewable
                    wire:model="password"
                />

                <!-- Confirm Password -->
                <flux:input
                    name="password_confirmation"
                    :label="__('Confirm Password')"
                    type="password"
                    required
                    placeholder="Repeat new password"
                    viewable
                    wire:model="password_confirmation"
                />

                <div class="flex items-center justify-end pt-1">
                    <flux:button type="submit" variant="primary" class="w-full bg-[#e9a35d] hover:bg-amber-500 text-[#1A1612] font-black py-3 rounded-xl border-none transition shadow-xs">
                        <flux:icon.loading wire:loading wire:target="resetPassword" />
                        <span wire:loading.remove wire:target="resetPassword" class="text-xs tracking-wide uppercase">{{ __('Save New Password') }}</span>
                    </flux:button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Billboard Side -->
    <div class="flex-1 p-5 max-lg:hidden bg-[#1A1612]">
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
