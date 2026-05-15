<?php

namespace App\Livewire\Admin;

use App\Enums\UserType;
use App\Traits\Toastable;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManager extends Component
{
    use Toastable;
    use WithPagination;

    public bool $showCreateModal = false;

    public bool $showEditModal = false;

    public bool $showDeleteModal = false;

    public int $roleId;

    public string $name;

    public array $selectedPermissions = [];

    public string $search = '';

    public string $permissionSearch = '';

    protected $rules = [
        'name' => 'required|unique:roles,name|max:255',
        'selectedPermissions' => 'array',
    ];

    protected $messages = [
        'name.required' => 'Role name is required',
        'name.unique' => 'This role name already exists',
    ];

    public function openCreateModal(): void
    {
        $this->reset(['name', 'selectedPermissions', 'roleId']);
        $this->showCreateModal = true;
    }

    public function closeModal(): void
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->reset(['name', 'selectedPermissions', 'roleId']);
        $this->resetValidation();
    }

    public function createRole(): void
    {
        $this->authorize('roles.create');
        $this->validate();

        try {
            DB::beginTransaction();

            $role = Role::create(['name' => $this->name, 'guard_name' => 'web']);

            if (! empty($this->selectedPermissions)) {
                $role->syncPermissions($this->selectedPermissions);
            }
            DB::commit();
            $this->toast('success', 'Role created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->toast('error', 'Error creating role: '.$e->getMessage());
        }
        $this->closeModal();
    }

    public function editRole($id): void
    {
        $role = Role::findOrFail($id);
        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->showEditModal = true;
    }

    public function updateRole(): void
    {
        $this->authorize('roles.edit');
        $this->validate([
            'name' => 'required|max:255|unique:roles,name,'.$this->roleId,
            'selectedPermissions' => 'array',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::findOrFail($this->roleId);
            $role->name = $this->name;
            $role->save();
            $role->syncPermissions($this->selectedPermissions);
            DB::commit();
            $this->toast('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->toast('error', 'Error updating role: '.$e->getMessage());
        }
        $this->closeModal();
    }

    public function confirmDelete($id): void
    {
        $role = Role::findOrFail($id);
        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->showDeleteModal = true;
    }

    public function deleteRole(): void
    {
        $this->authorize('roles.delete');
        try {
            $role = Role::findOrFail($this->roleId);

            // Prevent deleting super-admin role
            if ($role->name === UserType::SUPERADMIN) {
                $this->toast('error', 'Cannot delete super-admin role!');
                $this->closeModal();
                return;
            }

            $role->delete();
            $this->toast('success', 'Role deleted successfully.');

        } catch (\Exception $e) {
            $this->toast('error', 'Error deleting role: '.$e->getMessage());
        }
        $this->closeModal();
    }

    public function render(): View
    {
        $roles = Role::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name')
            ->paginate(10);

        $permissions = Permission::when($this->permissionSearch, function ($query) {
            return $query->where('name', 'like', '%'.$this->permissionSearch.'%');
        })
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');

        return view('livewire.admin.role-manager', [
            'roles' => $roles,
            'permissions' => $permissions,
        ])->layout('layouts.auth')->title('Role Manager');
    }
}
