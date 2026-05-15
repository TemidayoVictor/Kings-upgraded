<?php

namespace App\Livewire\Admin;

use App\Traits\Toastable;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionManager extends Component
{
    use Toastable;
    use WithPagination;

    public bool $showCreateModal = false;

    public bool $showEditModal = false;

    public bool $showDeleteModal = false;

    public int $permissionId;

    public string $name;

    public array|string $module;

    public string $search = '';

    public $modules = [
        'dashboard' => 'Dashboard',
        'users' => 'Users Management',
        'roles' => 'Roles Management',
        'products' => 'Products',
        'orders' => 'Orders',
        'earnings' => 'Earnings',
        'sections' => 'Sections',
        'settings' => 'Settings',
        'reports' => 'Reports',
    ];

    protected $rules = [
        'name' => 'required|unique:permissions,name|max:255',
        'module' => 'required',
    ];

    public function openCreateModal(): void
    {
        $this->reset(['name', 'module', 'permissionId']);
        $this->showCreateModal = true;
    }

    public function closeModal(): void
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->reset(['name', 'module', 'permissionId']);
        $this->resetValidation();
    }

    public function createPermission(): void
    {
        $this->authorize('roles.create');
        $this->validate();

        try {
            DB::beginTransaction();

            Permission::create([
                'name' => $this->name,
                'module' => $this->module,
                'guard_name' => 'web',
            ]);

            DB::commit();

            $this->toast('success', 'Permission created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->toast('error', 'Error creating permission: '.$e->getMessage());
        }
        $this->closeModal();
    }

    public function editPermission($id): void
    {
        $permission = Permission::findOrFail($id);
        $this->permissionId = $permission->id;
        $this->name = $permission->name;
        $this->module = $permission->module;
        $this->showEditModal = true;
    }

    public function updatePermission(): void
    {
        $this->authorize('roles.edit');
        $this->validate([
            'name' => 'required|max:255|unique:permissions,name,'.$this->permissionId,
            'module' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $permission = Permission::findOrFail($this->permissionId);
            $permission->name = $this->name;
            $permission->module = $this->module;
            $permission->save();

            DB::commit();
            $this->toast('success', 'Permission updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->toast('error', 'Error updating permission: '.$e->getMessage());
        }

        $this->closeModal();
    }

    public function confirmDelete($id): void
    {
        $permission = Permission::findOrFail($id);
        $this->permissionId = $permission->id;
        $this->name = $permission->name;
        $this->showDeleteModal = true;
    }

    public function deletePermission(): void
    {
        $this->authorize('roles.delete');
        try {
            $permission = Permission::findOrFail($this->permissionId);

            // Check if permission is assigned to any role
            $rolesWithPermission = Role::whereHas('permissions', function ($query) {
                $query->where('permission_id', $this->permissionId);
            })->count();

            if ($rolesWithPermission > 0) {
                $this->toast('error', 'Cannot delete permission as it is assigned to roles!');
                $this->closeModal();

                return;
            }

            $permission->delete();
            $this->toast('success', 'Permission deleted successfully!');

        } catch (\Exception $e) {
            $this->toast('error', 'Error deleting permission: '.$e->getMessage());
        }
        $this->closeModal();
    }

    public function render(): View
    {
        $permissions = Permission::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('module')
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.permission-manager', [
            'permissions' => $permissions,
        ])->layout('layouts.auth')->title('Permission Manager');
    }
}
