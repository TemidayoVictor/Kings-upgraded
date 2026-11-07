<div class="flex min-h-screen">
    <div class="flex-1 flex justify-center items-center">
        <div class="space-y-6 mx-auto max-w-[90%] md:max-w-2xl lg:max-w-4xl">
            <div class="flex flex-col items-center justify-center mt-[1.5em] md:mt-0">
                <a href="{{ route('home')  }}" class="group flex items-center gap-3">
                    <img src="{{ asset('images/Logo-Crown.svg') }}" alt="Logo" class="w-12 h-12">
                </a>
                <x-auth-header :title="__('Lets get you started')" :description="__('What brings you here?')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:mt-[2.5rem]">
                <flux:card>
                    <flux:icon.building-storefront variant="solid" class="text-[#e9a35d] dark:text-[#e9a35d] mb-2" />
                    <flux:heading size="lg" class="font-bold">Brand Owner</flux:heading>
                    <flux:text class="mt-2 mb-4">
                        Create, manage and grow your business with powerful tools built for scaling.
                    </flux:text>
                    <flux:button variant="primary" size="sm" class="w-full" wire:click="submit('{{App\Enums\UserType::BRAND}}')">Continue as Brand</flux:button>
                </flux:card>

                <flux:card>
                    <flux:icon.truck variant="solid" class="text-[#e9a35d] dark:text-[#e9a35d] mb-2" />
                    <flux:heading size="lg">Dropshipper</flux:heading>
                    <flux:text class="mt-2 mb-4">
                        Sell products without holding inventory. Partner with brands and simply focus
                        on marketing.
                    </flux:text>
                    <flux:button variant="primary" size="sm" class="w-full" wire:click="submit('{{App\Enums\UserType::DROPSHIPPER}}')">Continue as Dropshipper</flux:button>
                </flux:card>

                <flux:card>
                    <flux:icon.shopping-bag variant="solid" class="text-[#e9a35d] dark:text-[#e9a35d] mb-2" />
                    <flux:heading size="lg" class="font-bold">Client</flux:heading>
                    <flux:text class="mt-2 mb-4">
                        Browse products, shop from trusted brands, and connect with sellers effortlessly.
                    </flux:text>
                    <flux:button variant="primary" size="sm" class="w-full" wire:click="submit('{{App\Enums\UserType::CLIENT}}')">Continue as Client</flux:button>
                </flux:card>

            </div>

            <flux:separator />
        </div>

    </div>
</div>
