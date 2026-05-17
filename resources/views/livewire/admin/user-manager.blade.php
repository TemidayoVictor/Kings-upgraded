{{-- resources/views/livewire/admin/user-manager.blade.php --}}
<section class="w-full">
    @include('partials.admin-heading')

    <flux:heading class="sr-only">{{ __('Manage Users') }}</flux:heading>
    <div class="flex justify-between items-center mb-4 gap-4">
        <div class="flex-1 max-w-md">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search users by name or email..."
                type="search"
            >
{{--                    <flux:icon.search slot="icon" />--}}
            </flux:input>
        </div>
        <flux:button wire:click="openCreateModal" variant="primary">
            Add Admin User
        </flux:button>
    </div>

    <flux:separator/>

    <div class="min-h-screen mt-3">
        <div class="max-w-7xl mx-auto">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-[#3d3d40] rounded-lg p-4" wire:click="setFilter('all')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Total Users</p>
                            <p class="text-2xl font-bold text-white">{{ $totalUsers }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-[#3d3d40] rounded-lg p-4" wire:click="setFilter('new-users')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">New Users</p>
                            <p class="text-2xl font-bold text-purple-400">{{ $newUsers }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-[#3d3d40] rounded-lg p-4" wire:click="setFilter('brands')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Brands</p>
                            <p class="text-2xl font-bold text-blue-400">{{ $totalBrands }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-[#3d3d40] rounded-lg p-4" wire:click="setFilter('dropshippers')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Dropshippers</p>
                            <p class="text-2xl font-bold text-green-400">{{ $totalDropshippers }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 15v6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-[#3d3d40] rounded-lg p-4" wire:click="setFilter('clients')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Clients</p>
                            <p class="text-2xl font-bold text-gray-400">{{ $totalClients }}</p>
                        </div>
                        <div class="w-10 h-10 bg-gray-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Users List -->
            <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                @if($users->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-500">
                            <thead class="bg-[#3d3d40]">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">USER</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">TYPE</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">STATUS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">JOINED AT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">LAST LOGIN AT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ADMIN ROLES</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">ACTIONS</th>
                            </tr>
                            </thead>
                            <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-750 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                <span class="text-gray-300 font-medium text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-200">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($user->role === \App\Enums\UserType::ADMIN) bg-purple-500/20 text-purple-400
                                            @elseif($user->role === \App\Enums\UserType::BRAND) bg-blue-500/20 text-blue-400
                                            @elseif($user->role === \App\Enums\UserType::DROPSHIPPER) bg-green-500/20 text-green-400
                                            @else bg-gray-500/20 text-gray-400
                                            @endif">
                                            {{ $user->role ? ucfirst($user->role) : 'Unassigned' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full

                                            @if($user->onboarding_step === \App\Enums\Status::COMPLETED) bg-green-500/20 text-green-400
                                            @else bg-gray-500/20 text-gray-400
                                            @endif">
                                            {{ $user->onboarding_step ? ucfirst($user->onboarding_step) : 'Unassigned' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full">
                                            {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('F d, Y H:i:s') : 'Never logged in' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full">
                                            {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('F d, Y H:i:s') : 'Never logged in' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($user->roles as $role)
                                                <span class="px-2 py-1 text-xs rounded-full bg-[#27272a] text-gray-300">{{ $role->name }}</span>
                                            @empty
                                                <span class="text-xs text-gray-500">—</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if($user->is_admin)
                                                <button wire:key="manage-perms" wire:click="managePermissions({{ $user->id }})" class="text-gray-400 hover:text-blue-400" title="Manage Permissions">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                </button>
                                                <button wire:key="edit" wire:click="editUser({{ $user->id }})" class="text-gray-400 hover:text-gray-200" title="Edit User">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                            @else
                                                <flux:button href="{{ route('admin-start-impersonator', ['user' => $user])  }}" size="sm" variant="primary" wire:key="impersonate">
                                                    Impersonate
                                                </flux:button>
                                                <flux:button type="submit" size="sm" variant="primary" color="yellow">
                                                    Suspend
                                                </flux:button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-300">No users found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new user.</p>
                    </div>
                @endif
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>

            <!-- Create/Edit User Modal (simplified) -->
            @if($showCreateModal || $showEditModal)
                <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50 overflow-y-auto">
                    <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-white mb-4">{{ $showCreateModal ? 'Add New User' : 'Edit User' }}</h3>

                            <form wire:submit="{{ $showCreateModal ? 'createUser' : 'updateUser' }}">
                                <div class="space-y-4">
                                    <div>
                                        <flux:label class="mb-1">Full Name</flux:label>
                                        <flux:input wire:model="name" class="w-full" />
                                        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <flux:label class="mb-1">Email Address</flux:label>
                                        <flux:input wire:model="email" type="email" class="w-full" />
                                        @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <flux:label class="mb-1">{{ $showCreateModal ? 'Password' : 'New Password' }}</flux:label>
                                        <flux:input wire:model="password" type="password" class="w-full" />
                                        @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <flux:select label="Role" wire:model="userType">
                                            <option value="">Select Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        </flux:select>
                                        @error('userType')
                                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end space-x-2 pt-4">
                                        <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">Cancel</flux:button>
                                        <flux:button type="submit" variant="primary" size="sm">{{ $showCreateModal ? 'Create' : 'Update' }}</flux:button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if($showPermissionsModal)
                <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50 overflow-y-auto">
                    <div class="bg-[#27272a] rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-white mb-2">
                                Manage Permissions for {{ $name }}
                            </h3>
                            <p class="text-sm text-gray-400 mb-4">
                                Assign direct permissions to this user (in addition to role-based permissions)
                            </p>

                            <form wire:submit="updateUserPermissions">
                                <div class="space-y-4 max-h-96 overflow-y-auto mb-4">
                                    @foreach($availablePermissions as $module => $modulePermissions)
                                        <div class="border border-gray-700 rounded-lg overflow-hidden">
                                            <div class="bg-[#3d3d40] px-4 py-2">
                                                <h4 class="text-sm font-medium text-gray-200 uppercase">{{ ucfirst($module) }}</h4>
                                            </div>
                                            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-2">
                                                @foreach($modulePermissions as $permission)
                                                    @php
                                                        $isRolePermission = in_array($permission['name'], $roleBasedPermissions);
                                                    @endphp

                                                    <label class="flex items-center space-x-2 text-sm cursor-pointer">
                                                        <input
                                                            type="checkbox"
                                                            wire:model="directPermissions"
                                                            value="{{ $permission['name'] }}"
                                                        >

                                                        <span class="text-gray-300">
                                                            {{ $permission['name'] }}
                                                            @if($isRolePermission)
                                                                <span class="text-xs text-blue-400">(via role)</span>
                                                            @endif
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-700">
                                    <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                        Cancel
                                    </flux:button>
                                    <flux:button type="submit" size="sm" variant="primary">
                                        Save Permissions
                                    </flux:button>
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
                        <h3 class="text-lg font-medium text-white mb-4">Delete User</h3>
                        <p class="text-gray-300 mb-6">Are you sure you want to delete user "{{ $name }}"?</p>
                        <div class="flex justify-end space-x-2">
                            <flux:button type="button" variant="subtle" wire:click="closeModal">Cancel</flux:button>
                            <flux:button type="button" variant="danger" wire:click="deleteUser">Delete</flux:button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
