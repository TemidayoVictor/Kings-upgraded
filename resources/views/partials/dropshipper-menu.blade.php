<flux:sidebar.nav>
    <flux:sidebar.group :heading="__('Partners')" class="grid">
        <flux:sidebar.item icon="user-group" :href="route('dropshipper-partnered-brands')" :current="request()->routeIs('dropshipper-partnered-brands', 'dropshipper-applications', 'dropshipper-browse-brands', 'dropshipper-create-store', 'dropshipper-clone-progress', 'dropshipper-manage-store')" wire:navigate>
            {{ __('Partnered Brands') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Orders')" class="grid">
        <flux:sidebar.item icon="clipboard-document-list" :href="route('dropshipper-all-orders', auth()->user()->dropshipper->id)" :current="request()->routeIs('dropshipper-orders', 'dropshipper-all-orders')" wire:navigate>
            {{ __('Orders') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Features')" class="grid">
        <flux:sidebar.item icon="arrow-trending-up" :href="route('dropshipper-total-revenue')" :current="request()->routeIs('dropshipper-total-revenue')" wire:navigate>
            {{ __('Revenue Generated') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Settings')" class="grid">
        <flux:sidebar.item icon="cog-6-tooth" :href="route('settings.profile')" :current="request()->routeIs('settings.profile', 'dropshipper-details')" wire:navigate>
            {{ __('General Settings') }}
        </flux:sidebar.item>
    </flux:sidebar.group>
</flux:sidebar.nav>
