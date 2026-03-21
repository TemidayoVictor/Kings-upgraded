<flux:sidebar.nav>
    <flux:sidebar.item icon="chart-bar" :href="route('client-dashboard')" :current="request()->routeIs('client-dashboard')" wire:navigate>
        {{ __('Dashboard') }}
    </flux:sidebar.item>

    <flux:sidebar.group :heading="__('Features')" class="grid">
        <flux:sidebar.item icon="shopping-bag" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Wishlist') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="clipboard-document-list" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Orders') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="plus-circle" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Add your business') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="truck" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Become a dropshipper') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Settings')" class="grid">
        <flux:sidebar.item icon="cog-6-tooth" :href="route('settings.profile')" :current="request()->routeIs('settings.profile')" wire:navigate>
            {{ __('General Settings') }}
        </flux:sidebar.item>
    </flux:sidebar.group>
</flux:sidebar.nav>
