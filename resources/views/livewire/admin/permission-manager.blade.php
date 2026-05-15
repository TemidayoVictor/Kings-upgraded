{{-- resources/views/livewire/admin/permission-manager.blade.php --}}
<section class="w-full">
    @include('partials.admin-heading')

    <flux:heading class="sr-only">{{ __('Manage Permissions') }}</flux:heading>
    <x-admin.roles_and_perms :heading="__('Permission Management')" :subheading="__('Create and manage system permissions')">

        <div class="flex justify-between items-center mb-4 gap-4">
            <div class="flex-1 max-w-md">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search permissions..."
                    type="search"
                >
{{--                    <flux:icon.search slot="icon" />--}}
                </flux:input>
            </div>
            <flux:button wire:click="openCreateModal" variant="primary">
                Add Permission
            </flux:button>
        </div>

        <flux:separator/>

        <div class="min-h-screen mt-3">
            <div class="max-w-7xl mx-auto">
                <!-- Permissions Table -->
                <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    @if($permissions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-500">
                                <thead class="bg-[#3d3d40]">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        PERMISSION NAME
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        MODULE
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        ACTIONS
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                                @foreach($permissions as $permission)
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-200">
                                                {{ $permission->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full bg-[#27272a] text-gray-300">
                                                    {{ ucfirst($permission->module ?? 'general') }}
                                                </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end space-x-3">
                                                <button wire:click="editPermission({{ $permission->id }})" wire:key="edit-prem" class="text-gray-400 hover:text-gray-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button wire:click="confirmDelete({{ $permission->id }})" wire:key="delete-perm" class="text-gray-400 hover:text-red-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No permissions found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new permission.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    {{ $permissions->links() }}
                </div>

                <!-- Create/Edit Permission Modal -->
                @if($showCreateModal || $showEditModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-medium text-white mb-4">
                                {{ $showCreateModal ? 'Add New Permission' : 'Edit Permission' }}
                            </h3>

                            <form wire:submit="{{ $showCreateModal ? 'createPermission' : 'updatePermission' }}">
                                <div class="space-y-4">
                                    <div>
                                        <flux:label class="mb-1">Permission Name</flux:label>
                                        <flux:input
                                            wire:model="name"
                                            placeholder="e.g., users.view, products.create"
                                            class="w-full"
                                        />
                                        <p class="text-xs text-gray-500 mt-1">Format: module.action (e.g., users.view)</p>
                                        @error('name')
                                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <flux:select label="Module" wire:model="module">
                                            <option value="">Select Module</option>
                                            @foreach($modules as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </flux:select>
                                        @error('module')
                                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end space-x-2 pt-4">
                                        <flux:button type="button" size="sm" variant="subtle" wire:click="closeModal">
                                            Cancel
                                        </flux:button>
                                        <flux:button type="submit" size="sm" variant="primary">
                                            {{ $showCreateModal ? 'Create Permission' : 'Update Permission' }}
                                        </flux:button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Delete Modal -->
                @if($showDeleteModal)
                    <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-medium text-white mb-4">Delete Permission</h3>
                            <p class="text-gray-300 mb-6">
                                Are you sure you want to delete permission "{{ $name }}"? This action cannot be undone.
                            </p>
                            <div class="flex justify-end space-x-2">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Cancel
                                </flux:button>
                                <flux:button type="button" variant="danger" size="sm" wire:click="deletePermission">
                                    Delete Permission
                                </flux:button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-admin.roles_and_perms>
</section>
