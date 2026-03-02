<section class="w-full">
    @include('partials.products-heading')

    <flux:heading class="sr-only">{{ __('Manage Sections') }}</flux:heading>
    <x-products.layout :heading="__('Manage Sections')" :subheading="__('Create sections for your products')">
        <form wire:submit="submit">
            <flux:fieldset>
                <div class="space-y-4">
                    <flux:input label="Add Section" wire:model="name" placeholder="Section Name" class="max-full" />
                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary">
                            <flux:icon.loading wire:loading wire:target="submit" />
                            <span wire:loading.remove wire:target="submit">{{ __('Add Section') }}</span>
                        </flux:button>
                    </div>
                    <flux:separator />
                </div>
            </flux:fieldset>
        </form>

        <div class="min-h-screen">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 my-3">
                    <flux:subheading size="xl" level="1" class="text-gray-100">Section List</flux:subheading>
                </div>

                <!-- Sections List -->
                <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    @if($sections->count() > 0)
                        <!-- Desktop Table View (hidden on mobile) -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-500">
                                <thead class="bg-[#3d3d40]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        <button class="flex items-center space-x-1 hover:text-gray-200">
                                            <span>SECTION</span>
                                        </button>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Products
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                                @foreach($sections as $section)
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-[#27272a] rounded-full flex items-center justify-center">
                                                    <span class="text-gray-300 font-medium">{{ substr($section->name, 0, 1) }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-200">
                                                        {{ $section->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $section->created_at->format('M d, Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#27272a] text-gray-300">
                                                {{ $section->products->count() ?? 0 }} product{{ $section->products->count() == 1 ? '' : 's' }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                <button
                                                    wire:click="popup('edit', {{ $section->id }})"
                                                    class="text-gray-400 hover:text-gray-200 transition-colors"
                                                    title="Edit section"
                                                    type="button"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>

                                                <button
                                                    wire:click="popup('delete', {{ $section->id }})"
                                                    class="text-gray-400 hover:text-red-400 transition-colors"
                                                    title="Delete section"
                                                >
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

                        <!-- Mobile Card View (visible only on mobile) -->
                        <div class="sm:hidden divide-y divide-gray-200">
                            @foreach($sections as $section)
                                <div class="p-4 hover:bg-gray-750 transition-colors">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                <span class="text-gray-300 font-medium">{{ substr($section->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-200">{{ $section->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $section->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button
                                                wire:click="popup('edit', {{ $section->id }})"
                                                class="p-2 text-gray-400 hover:text-gray-200 transition-colors"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button
                                                wire:click="popup('delete', {{ $section->id }})"
                                                class="p-2 text-gray-400 hover:text-red-400 transition-colors"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between mt-3 pt-2 border-t border-dashed border-gray-500">
                                        <div class="flex items-center space-x-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-[#27272a] text-gray-300">
                                                {{ $section->products->count() ?? 0 }} products
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 px-4">
                            <svg class="mx-auto h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No sections</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new section.</p>
                        </div>
                    @endif
                </div>

                @if($showEditModal)
                    <div class="fixed inset-0 bg-black/70 bg-opacity-20 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <form wire:submit="save">
                                <flux:fieldset>
                                    <div class="space-y-4">
                                        <flux:input label="Edit Section" wire:model="name" placeholder="Section Name" class="max-full" />
                                        <div class="flex justify-end items-center">
                                            <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                                Cancel
                                            </flux:button>
                                            <flux:button type="submit" size="sm" variant="primary" class="ml-2">
                                                <flux:icon.loading wire:loading wire:target="save" />
                                                <span wire:loading.remove wire:target="save">{{ __('Edit Section') }}</span>
                                            </flux:button>
                                        </div>
                                        <flux:separator />
                                    </div>
                                </flux:fieldset>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Delete Modal -->
                @if($showDeleteModal)
                    <div class="fixed inset-0 bg-black/70 bg-opacity-20 flex items-center justify-center p-4" style="z-index: 50;">
                        <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                            <form wire:submit="delete">
                                <flux:fieldset>
                                    <div class="space-y-4">
                                        <p class="text-white mb-4"> Are you sure you want to delete "{{ $name }}"? </p>
                                        <div class="flex justify-end items-center">
                                            <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                                Cancel
                                            </flux:button>
                                            <flux:button type="submit" size="sm" variant="danger" class="ml-2">
                                                <flux:icon.loading wire:loading wire:target="save" />
                                                <span wire:loading.remove wire:target="save">{{ __('Delete') }}</span>
                                            </flux:button>
                                        </div>
                                        <flux:separator />
                                    </div>
                                </flux:fieldset>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-products.layout>
</section>
