<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    <x-brand.settings.layout :heading="__('Profile')" :subheading="__('Update your personal information')">
        <form wire:submit="submit"  class="my-6 w-full space-y-6">
            <div>
                <flux:input wire:model="phone" :label="__('Phone number (preferably whatsapp)')" type="text" required autocomplete="phone" />
                <small>This will be your primary source of contact</small>
            </div>
            <div>
                <flux:input wire:model="name" :label="__('Name')" type="text" required autocomplete="name" />
            </div>
            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" readonly />
                <small class="mt-1">To change email, kindly contact support</small>
            </div>

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">
                    <flux:icon.loading wire:loading wire:target="submit" />
                    <span wire:loading.remove wire:target="submit">{{ __('Update Profile') }}</span>
                </flux:button>
            </div>
        </form>
    </x-brand.settings.layout>
</section>
