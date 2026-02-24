<flux:sidebar.nav>
    <flux:sidebar.item icon="chart-bar" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
        {{ __('Dashboard') }}
    </flux:sidebar.item>

    <flux:sidebar.group :heading="__('Partners')" class="grid">
        <flux:sidebar.item icon="user-group" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Partnered Brands') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Orders')" class="grid">
        <flux:sidebar.item icon="clipboard-document-list" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Orders') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Features')" class="grid">
        <flux:sidebar.item icon="arrow-trending-up" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Revenue Generated') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Settings')" class="grid">
        <flux:sidebar.item icon="cog-6-tooth" :href="route('settings.profile')" :current="request()->routeIs('settings.profile', 'dropshipper-details')" wire:navigate>
            {{ __('General Settings') }}
        </flux:sidebar.item>
    </flux:sidebar.group>
</flux:sidebar.nav>
