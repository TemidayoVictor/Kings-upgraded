<flux:sidebar.nav>
    <flux:sidebar.item icon="chart-bar" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
        {{ __('Dashboard') }}
    </flux:sidebar.item>

    <flux:sidebar.group :heading="__('Products')" class="grid">
        <flux:sidebar.item icon="plus-circle" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Add Products') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="cube" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Manage Products') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="adjustments-horizontal" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Product Settings') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Orders')" class="grid">
        <flux:sidebar.item icon="clipboard-document-list" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Store Orders') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="truck" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Dropshipper Orders') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Features')" class="grid">
        <flux:sidebar.item icon="tag" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Run Sales') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="user-group" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Manage Dropshippers') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="arrow-trending-up" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Revenue Generated') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Subscription')" class="grid">
        <flux:sidebar.item icon="arrow-path" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Subscription Status') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Settings')" class="grid">
        <flux:sidebar.item icon="cog-6-tooth" :href="route('settings.profile')" :current="request()->routeIs('settings.profile', 'brand-details')" wire:navigate>
            {{ __('General Settings') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="swatch" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Brand Mode') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="building-storefront" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Add Another Brand') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="arrows-right-left" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Switch Accounts') }}
        </flux:sidebar.item>
    </flux:sidebar.group>
</flux:sidebar.nav>
