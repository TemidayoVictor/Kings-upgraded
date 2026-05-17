<flux:sidebar.nav>
    <flux:sidebar.item icon="chart-bar" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
        {{ __('Dashboard') }}
    </flux:sidebar.item>
    <flux:sidebar.item icon="cog-6-tooth" :href="route('admin-manage-users')" :current="request()->routeIs('admin-manage-users')" wire:navigate>
        {{ __('Manage Users') }}
    </flux:sidebar.item>

    <flux:sidebar.group :heading="__('Orders')" class="grid">
        <flux:sidebar.item icon="clipboard-document-list" :href="route('admin-orders', ['admin' => 'admin-view'])" :current="request()->routeIs('admin-orders')" wire:navigate>
            {{ __('Store Orders') }}
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
        <flux:sidebar.item icon="cog-6-tooth" :href="route('admin-general-settings')" :current="request()->routeIs('admin-general-settings', 'settings.profile')" wire:navigate>
            {{ __('General Settings') }}
        </flux:sidebar.item>
        <flux:sidebar.item icon="cog-6-tooth" :href="route('admin-roles')" :current="request()->routeIs('admin-roles', 'admin-permissions')" wire:navigate>
            {{ __('Roles and Permissions') }}
        </flux:sidebar.item>
    </flux:sidebar.group>
</flux:sidebar.nav>
