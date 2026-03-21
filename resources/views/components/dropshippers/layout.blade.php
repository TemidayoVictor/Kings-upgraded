<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist aria-label="{{ __('Settings') }}">
            <flux:navlist.item :href="route('dropshipper-partnered-brands')">{{ __('Partnered Brands') }}</flux:navlist.item>
        </flux:navlist>
        <flux:navlist aria-label="{{ __('Settings') }}">
            <flux:navlist.item :href="route('dropshipper-applications')">{{ __('Brand   Applications') }}</flux:navlist.item>
        </flux:navlist>
        <flux:navlist aria-label="{{ __('Settings') }}">
            <flux:navlist.item :href="route('dropshipper-browse-brands')">{{ __('Browse Brands') }}</flux:navlist.item>
        </flux:navlist>
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
