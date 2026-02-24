<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist aria-label="{{ __('Settings') }}">
            <flux:navlist.item :href="route('settings.profile')">{{ __('Profile') }}</flux:navlist.item>
        </flux:navlist>
        @if(auth()->user()->role == App\Enums\UserType::BRAND)
            <flux:navlist aria-label="{{ __('Settings') }}">
                <flux:navlist.item :href="route('brand-details')">{{ __('Brand Details') }}</flux:navlist.item>
            </flux:navlist>
            <flux:navlist aria-label="{{ __('Settings') }}">
                <flux:navlist.item :href="route('brand-additional-details')">{{ __('Additional Details') }}</flux:navlist.item>
            </flux:navlist>
        @elseif(auth()->user()->role == App\Enums\UserType::DROPSHIPPER)
            <flux:navlist aria-label="{{ __('Settings') }}">
                <flux:navlist.item :href="route('dropshipper-details')">{{ __('Dropshipper Details') }}</flux:navlist.item>
            </flux:navlist>
        @endif
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <h2 class="text-[1.3rem] font-bolder">{{ $heading ?? '' }}</h2>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
