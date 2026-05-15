{{-- resources/views/livewire/admin/role-manager.blade.php --}}
<section class="w-full">
    @include('partials.admin-heading')

    <flux:heading class="sr-only">{{ __('Manage Roles') }}</flux:heading>
    <x-admin.roles_and_perms :heading="__('Role Management')" :subheading="__('Create and manage user roles and permissions')">

        <div class="flex justify-between items-center mb-4 gap-4">
            <div class="flex-1 max-w-md">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search roles..."
                    type="search"
                >
{{--                    <flux:icon.search slot="icon" />--}}
                </flux:input>
            </div>
            <flux:button wire:click="openCreateModal" variant="primary">
                Add Role
            </flux:button>
        </div>

        <flux:separator/>

        <div class="min-h-screen mt-3">
            <div class="max-w-7xl mx-auto">
                <!-- Roles List -->
                <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    @if($roles->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-500">
                                <thead class="bg-[#3d3d40]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        ROLE NAME
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        PERMISSIONS
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        ACTIONS
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                                @foreach($roles as $role)
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-[#27272a] rounded-full flex items-center justify-center">
                                                        <span class="text-gray-300 font-medium text-sm">
                                                            {{ strtoupper(substr($role->name, 0, 2)) }}
                                                        </span>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-200">
                                                        {{ $role->name }}
                                                        @if($role->name === \App\Enums\UserType::SUPERADMIN)
                                                            <span class="ml-2 px-2 py-0.5 text-xs bg-red-500/20 text-red-400 rounded-full">System</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $role->users_count ?? 0 }} user(s)
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($role->permissions->take(5) as $permission)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-[#27272a] text-gray-300">
                                                            {{ $permission->name }}
                                                        </span>
                                                @endforeach
                                                @if($role->permissions->count() > 5)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-[#27272a] text-gray-400">
                                                            +{{ $role->permissions->count() - 5 }} more
                                                        </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                @if($role->name !== \App\Enums\UserType::SUPERADMIN)
                                                    <button
                                                        wire:click="editRole({{ $role->id }})" wire:key="edit-role"
                                                        class="text-gray-400 hover:text-gray-200 transition-colors"
                                                        title="Edit role"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        wire:click="confirmDelete({{ $role->id }})" wire:key="delete-role"
                                                        class="text-gray-400 hover:text-red-400 transition-colors"
                                                        title="Delete role"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="sm:hidden divide-y divide-gray-500">
                            @foreach($roles as $role)
                                <div class="p-4 hover:bg-gray-750 transition-colors">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                <span class="text-gray-300 font-medium">{{ strtoupper(substr($role->name, 0, 2)) }}</span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-200">{{ $role->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $role->users_count ?? 0 }} users</div>
                                            </div>
                                        </div>
                                        @if($role->name !== \App\Enums\UserType::SUPERADMIN)
                                            <div class="flex items-center space-x-2">
                                                <button wire:click="editRole({{ $role->id }})" class="p-2 text-gray-400 hover:text-gray-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button wire:click="confirmDelete({{ $role->id }})" class="p-2 text-gray-400 hover:text-red-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach($role->permissions->take(3) as $permission)
                                            <span class="px-2 py-1 text-xs rounded-full bg-[#27272a] text-gray-300">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                        @if($role->permissions->count() > 3)
                                            <span class="px-2 py-1 text-xs rounded-full bg-[#27272a] text-gray-400">
                                                +{{ $role->permissions->count() - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No roles found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new role.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    {{ $roles->links() }}
                </div>

                <!-- Create/Edit Role Modal -->
                @if($showCreateModal || $showEditModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50 overflow-y-auto">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-white mb-4">
                                    {{ $showCreateModal ? 'Add New Role' : 'Edit Role' }}
                                </h3>

                                <form wire:submit="{{ $showCreateModal ? 'createRole' : 'updateRole' }}">
                                    <div class="space-y-6">
                                        <!-- Role Name -->
                                        <div>
                                            <flux:label class="mb-1">Role Name</flux:label>
                                            <flux:input
                                                wire:model="name"
                                                placeholder="e.g., Editor, Moderator, etc."
                                                class="w-full"
                                            />
                                            @error('name')
                                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Permissions Selection -->
                                        <div>
                                            <div class="flex justify-between items-center mb-3">
                                                <flux:label>Permissions</flux:label>
                                                <div class="flex gap-2">
                                                    <button type="button" wire:click="$set('selectedPermissions', [])" class="text-xs text-gray-400 hover:text-white">
                                                        Clear All
                                                    </button>
                                                    <button type="button" wire:click="$set('selectedPermissions', {{ collect($permissions->flatten())->pluck('name') }})" class="text-xs text-gray-400 hover:text-white">
                                                        Select All
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <flux:input
                                                    wire:model.live="permissionSearch"
                                                    placeholder="Search permissions..."
                                                    size="sm"
                                                />
                                            </div>

                                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                                @foreach($permissions as $module => $modulePermissions)
                                                    <div class="border border-gray-700 rounded-lg overflow-hidden">
                                                        <div class="bg-[#3d3d40] px-4 py-2">
                                                            <h4 class="text-sm font-medium text-gray-200 uppercase">
                                                                {{ ucfirst($module) }}
                                                            </h4>
                                                        </div>
                                                        <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                                            @foreach($modulePermissions as $permission)
                                                                <label class="flex items-center space-x-2 text-sm text-gray-300 hover:text-white cursor-pointer">
                                                                    <input
                                                                        type="checkbox"
                                                                        wire:model="selectedPermissions"
                                                                        value="{{ $permission->name }}"
                                                                        class="rounded border-gray-600 bg-[#1f1f22] text-blue-500 focus:ring-blue-500"
                                                                    >
                                                                    <span>{{ $permission->name }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="flex justify-end space-x-2 pt-4 border-t border-gray-700">
                                            <flux:button type="button" size="sm" variant="subtle" wire:click="closeModal">
                                                Cancel
                                            </flux:button>
                                            <flux:button type="submit" size="sm" variant="primary">
                                                {{ $showCreateModal ? 'Create Role' : 'Update Role' }}
                                            </flux:button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Delete Modal -->
                @if($showDeleteModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-medium text-white mb-4">Delete Role</h3>
                            <p class="text-gray-300 mb-6">
                                Are you sure you want to delete role "{{ $name }}"? This action cannot be undone.
                            </p>
                            <div class="flex justify-end space-x-2">
                                <flux:button type="button" size="sm" variant="subtle" wire:click="closeModal">
                                    Cancel
                                </flux:button>
                                <flux:button type="button" size="sm" variant="danger" wire:click="deleteRole">
                                    Delete Role
                                </flux:button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-admin.roles_and_perms>
</section>
