<flux:sidebar.nav>
    <flux:sidebar.group :heading="__('Users')" class="grid">
        <flux:sidebar.item icon="user-group" :href="route('admin-manage-users')" :current="request()->routeIs('admin-manage-users')" wire:navigate>
            {{ __('Manage Users') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Brands')" class="grid">
        <flux:sidebar.item icon="calendar" :href="route('admin-manage-brands')" :current="request()->routeIs('admin-manage-brands')" wire:navigate>
            {{ __('Manage Brands') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Orders')" class="grid">
        <flux:sidebar.item icon="clipboard-document-list" :href="route('admin-orders', ['admin' => 'admin-view'])" :current="request()->routeIs('admin-orders')" wire:navigate>
            {{ __('All Orders') }}
        </flux:sidebar.item>
    </flux:sidebar.group>

    <flux:sidebar.group :heading="__('Features')" class="grid">
        <flux:sidebar.item icon="arrow-trending-up" :href="route('admin-revenue-report')" :current="request()->routeIs('admin-revenue-report')" wire:navigate>
            {{ __('Revenue Generated') }}
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
