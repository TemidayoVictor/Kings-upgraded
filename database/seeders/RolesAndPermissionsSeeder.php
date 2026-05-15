<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define modules and their permissions
        $modules = [
            'dashboard' => ['view'],
            'users' => ['view', 'create', 'edit', 'delete', 'impersonate'],
            'roles' => ['view', 'create', 'edit', 'delete'],
            'products' => ['view', 'create', 'edit', 'delete'],
            'orders' => ['view', 'create', 'edit', 'delete', 'update_status'],
            'earnings' => ['view', 'export'],
            'sections' => ['view', 'create', 'edit', 'delete'],
            'settings' => ['view', 'edit'],
            'reports' => ['view', 'export'],
        ];

        // Create permissions
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $permissionName = "{$module}.{$action}";
                Permission::create([
                    'name' => $permissionName,
                    'module' => $module,
                    'guard_name' => 'web',
                ]);
            }
        }

        // Create roles and assign permissions

        // 1. Super Admin - Has all permissions
        $superAdmin = Role::create(['name' => UserType::SUPERADMIN]);
        $superAdmin->givePermissionTo(Permission::all());

        // 2. Admin - Most permissions except some sensitive ones
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'dashboard.view',
            'users.view', 'users.create', 'users.edit',
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'orders.view', 'orders.create', 'orders.edit', 'orders.delete', 'orders.update_status',
            'earnings.view', 'earnings.export',
            'sections.view', 'sections.create', 'sections.edit', 'sections.delete',
            'reports.view', 'reports.export',
        ]);

        // 3. Store Manager - Can manage products and orders
        $storeManager = Role::create(['name' => 'store-manager']);
        $storeManager->givePermissionTo([
            'dashboard.view',
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'orders.view', 'orders.update_status',
            'earnings.view',
            'sections.view', 'sections.create', 'sections.edit',
        ]);

        // 4. Support Staff - Can view orders and update status
        $support = Role::create(['name' => 'support']);
        $support->givePermissionTo([
            'dashboard.view',
            'orders.view', 'orders.update_status',
            'products.view',
        ]);

        // 5. Viewer - Read-only access
        $viewer = Role::create(['name' => 'viewer']);
        $viewer->givePermissionTo([
            'dashboard.view',
            'products.view',
            'orders.view',
            'earnings.view',
        ]);

        // Create demo users with different roles
        $this->createDemoUsers();
    }

    private function createDemoUsers(): void
    {
        // Super Admin User
        $superAdminUser = User::updateOrCreate(
            ['email' => 'temidayo-super@knkings.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('temidayo-super'),
                'email_verified_at' => now(),
                'role' => UserType::ADMIN,
                'is_admin' => true,
            ]
        );
        $superAdminUser->assignRole(UserType::SUPERADMIN);

        $this->command->info('Super admin created:');
        $this->command->info('temidayo-super@knkings.com / temidayo-super');
    }
}
