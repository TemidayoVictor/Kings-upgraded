<?php

namespace App\Console\Commands;

use App\Enums\UserType;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SyncPermissions extends Command
{
    protected $signature = 'permissions:sync';
    protected $description = 'Sync permissions with the latest module definitions';

    public function handle(): void
    {
        $modules = [
            'dashboard' => ['view'],
            'users' => ['view', 'create', 'edit', 'delete'],
            'roles' => ['view', 'create', 'edit', 'delete'],
            'products' => ['view', 'create', 'edit', 'delete'],
            'orders' => ['view', 'create', 'edit', 'delete', 'update_status'],
            'earnings' => ['view', 'export'],
            'sections' => ['view', 'create', 'edit', 'delete'],
            'settings' => ['view', 'edit'],
            'reports' => ['view', 'export'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $permissionName = "{$module}.{$action}";
                Permission::updateOrCreate(
                    ['name' => $permissionName, 'guard_name' => 'web'],
                    ['module' => $module]
                );
                $this->info("Synced: {$permissionName}");
            }
        }

        // Update super-admin with new permissions
        $superAdmin = Role::findByName(UserType::SUPERADMIN);
        $superAdmin->syncPermissions(Permission::all());

        $this->info('Permissions synced successfully!');
    }
}
