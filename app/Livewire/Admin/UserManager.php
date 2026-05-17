<?php

namespace App\Livewire\Admin;

use App\Enums\UserType;
use App\Models\Brand;
use App\Models\Dropshipper;
use App\Models\User;
use App\Traits\Toastable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManager extends Component
{
    use Toastable;
    use WithPagination;

    public string $filter = 'all';

    public bool $showCreateModal = false;

    public bool $showEditModal = false;

    public bool $showDeleteModal = false;

    public bool $showPermissionsModal = false;

    public int $userId;

    public string $name;

    public string $email;

    public string $password;

    public string $userType = '';

    public bool $isAdmin = false;

    public array $selectedRoles = [];

    public array $selectedPermissions = [];

    public string $search = '';

    public array|Collection $availableRoles = [];

    public array|Collection $availablePermissions = [];

    public array $userPermissions = [];

    public array $directPermissions = [];

    public array $roleBasedPermissions = [];

    public array $displayPermissions = [];

    public int $totalUsers = 0;

    public int $totalAdmins = 0;

    public int $totalBrands = 0;

    public int $totalDropshippers = 0;

    public int $totalClients = 0;

    public int $newUsers = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'userType' => 'required',
        'isAdmin' => 'boolean',
        'selectedRoles' => 'array',
    ];

    protected $messages = [
        'name.required' => 'Name is required',
        'email.required' => 'Email is required',
        'email.unique' => 'This email is already taken',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters',
    ];

    public function mount(): void
    {
        $this->loadRolesAndPermissions();
        $this->loadUserStats();
    }

    public function loadRolesAndPermissions(): void
    {
        $this->availableRoles = Role::all()->toArray();  // ✅ Converts to array
        $this->availablePermissions = Permission::get()->groupBy('module')->toArray();
    }

    public function openCreateModal(): void
    {
        $this->reset(['name', 'email', 'password', 'userType', 'isAdmin', 'selectedRoles', 'selectedPermissions', 'userId']);
        $this->userType = UserType::ADMIN;
        $this->isAdmin = false;
        $this->showCreateModal = true;
    }

    public function closeModal(): void
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showPermissionsModal = false;
        $this->reset(['name', 'email', 'password', 'userType', 'isAdmin', 'selectedRoles', 'selectedPermissions', 'userId']);
        $this->resetValidation();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;

        // reset pagination
        $this->resetPage();
    }

    public function createUser(): void
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Create the user
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => UserType::ADMIN,
                'is_admin' => true,
            ]);

            // Assign roles (only for admin users)
            $user->assignRole($this->userType);

            DB::commit();

            $this->toast('success', 'User created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->toast('error', 'Error creating user: '.$e->getMessage());
        }
        $this->closeModal();
    }

    public function editUser($id): void
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->userType = $user->role ?? '';
        $this->isAdmin = $user->is_admin;

        if ($user->is_admin) {
            $this->selectedRoles = $user->roles->pluck('name')->toArray();
        }

        $this->showEditModal = true;
    }

    public function updateUser(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->userId,
            'userType' => 'required',
            'isAdmin' => 'boolean',
            'selectedRoles' => 'array',
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($this->userId);

            // Update user
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'role' => UserType::ADMIN,
                'is_admin' => true,
            ]);

            // Update password if provided
            if (! empty($this->password)) {
                $user->update(['password' => Hash::make($this->password)]);
            }

            $user->syncRoles($this->userType);

            DB::commit();

            $this->toast('success', 'User updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->toast('error', 'Error updating user: '.$e->getMessage());
        }
        $this->closeModal();
    }

    public function confirmDelete($id): void
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->showDeleteModal = true;
    }

    public function deleteUser(): void
    {
        try {
            $user = User::findOrFail($this->userId);

            // Prevent deleting your own account
            if ($user->id === auth()->id()) {
                $this->toast('error', 'You cannot delete your own account!');
                $this->closeModal();

                return;
            }

            $user->delete();
            $this->toast('success', 'User deleted successfully.');

        } catch (\Exception $e) {
            $this->toast('error', 'Error deleting user: '.$e->getMessage());
        }
        $this->closeModal();
    }

    public function managePermissions($id): void
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;

        $this->directPermissions = $user
            ->getDirectPermissions()
            ->pluck('name')
            ->toArray();

        $this->roleBasedPermissions = $user
            ->getPermissionsViaRoles()
            ->pluck('name')
            ->toArray();

        $this->displayPermissions = array_unique([
            ...$this->directPermissions,
            ...$this->roleBasedPermissions,
        ]);

        $this->showPermissionsModal = true;
    }

    public function updateUserPermissions(): void
    {
        try {
            $user = User::findOrFail($this->userId);

            $user->syncPermissions($this->directPermissions);

            $this->toast('success', 'User permissions updated successfully.');

        } catch (\Exception $e) {
            $this->toast('error', 'Error updating permissions: '.$e->getMessage());
        }

        $this->closeModal();
    }

    public function loadUserStats(): void
    {
        $this->totalUsers = User::count();
        $this->totalAdmins = User::where('role', UserType::ADMIN)->count();
        $this->totalBrands = Brand::count();
        $this->totalDropshippers = Dropshipper::count();
        $this->totalClients = User::where('role', UserType::CLIENT)->count();
        $this->newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
    }

    public function render(): View
    {
        $users = User::where(function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%');
        });
        // Filters
        switch ($this->filter) {

            case 'new-users':
                $users->where('created_at', '>=', now()->subDays(7));
                break;

            case 'brands':
                $users->where('role', UserType::BRAND);
                break;

            case 'dropshippers':
                $users->where('role', UserType::DROPSHIPPER);
                break;

            case 'clients':
                $users->where('role', UserType::CLIENT);
                break;

            case 'admins':
                $users->where('role', UserType::ADMIN);
                break;
        }

        $users = $users
            ->orderByDesc('created_at')
            ->paginate(10);

        $roles = Role::get();

        return view('livewire.admin.user-manager', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('layouts.auth')->title('User manager');
    }
}
