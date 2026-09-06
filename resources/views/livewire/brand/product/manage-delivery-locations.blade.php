{{-- resources/views/livewire/brand/delivery-locations.blade.php --}}
<section class="w-full"
         x-data="{
            modal: null,
            locationId: null,
            locationName: '',
            parentId: null,
            parentName: '',
            parentPrice: 0,
            expandedLocations: {},

            openCreate() {
                this.modal = 'create';
                this.locationId = null;
                this.locationName = '';
                this.parentId = null;
                this.parentName = '';
                this.parentPrice = 0;
            },

            openSubLocation(id, name, price) {
                this.modal = 'sub-location';
                this.locationId = null;
                this.parentId = id;
                this.parentName = name;
                this.parentPrice = price;

                $wire.parent_id = id;
            },

            openEdit(id) {
                this.modal = 'edit';
                this.locationId = id;

                $wire.edit(id);
            },

            openDelete(id, name) {
                this.modal = 'delete';
                this.locationId = id;
                this.locationName = name;
            },

            toggleExpand(id) {
                this.expandedLocations[id] = !this.expandedLocations[id];
            },

            closeModal() {
                this.modal = null;
                this.locationId = null;
                this.locationName = '';
                this.parentId = null;
                this.parentName = '';
                this.parentPrice = 0;
            },

        }"

         x-on:location-created.window="closeModal()"
         x-on:location-updated.window="closeModal()"
         x-on:location-deleted.window="closeModal()"
         x-on:keydown.escape.window="closeModal()"
>
    @include('partials.products-settings-heading')
    <x-products.settings :heading="__('Delivery Locations')" :subheading="__('Manage your delivery locations')">

        <flux:heading class="sr-only">{{ __('Manage Products') }}</flux:heading>

        <div class="flex justify-end mb-4">
            <flux:button x-on:click="openCreate()" size="sm" variant="primary">
                Add Location
            </flux:button>
        </div>

        <flux:separator/>

        <!-- Locations List -->
        <div class="mt-4 bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
            @if($rootLocations->count() > 0)
                <!-- Desktop View -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-500">
                        <thead class="bg-[#3d3d40]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Location
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Delivery Price
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                        @foreach($rootLocations as $location)
                            @include('livewire.brand.partials.location-row', ['location' => $location, 'level' => 0])
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View -->
                <div class="sm:hidden divide-y divide-gray-500">
                    @foreach($rootLocations as $location)
                        @include('livewire.brand.partials.location-card', ['location' => $location, 'level' => 0])
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 px-4">
                    <svg class="mx-auto h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-300">No delivery locations</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by adding your first location.</p>
                    <div class="mt-2">
                        <flux:button x-on:click="openCreate()" size="sm" variant="primary">
                            Add Location
                        </flux:button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Create Location Modal -->
        <div
            x-show="modal === 'create'"
            x-cloak
            class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
            <div
                x-on:click.outside="closeModal()"
                class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="text-lg font-medium text-white mb-4">Add New Location</h3>
                <form wire:submit="create">
                    <div class="space-y-4">
                        <div>
                            <flux:input
                                label="Location Name"
                                wire:model="name"
                                placeholder="E.g Lagos State, Ikeja, etc."
                                class="max-full"
                            />
                        </div>

                        <div>
                            <flux:input
                                label="Delivery Price"
                                wire:model="delivery_price"
                                type="number"
                                step="0.01"
                                placeholder="₦5000"
                                class="max-full"
                            />
                        </div>

                        <div class="flex justify-end space-x-2">
                            <flux:button type="button" variant="subtle" size="sm" x-on:click="closeModal()">
                                Cancel
                            </flux:button>
                            <flux:button type="submit" variant="primary" size="sm">
                                <flux:icon.loading wire:loading wire:target="create" />
                                <span wire:loading.remove wire:target="create">Add Location</span>
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Sub-location Modal -->
        <div
            x-show="modal === 'sub-location'"
            x-cloak
            class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
            <div
                x-on:click.outside="closeModal()"
                class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="text-lg font-medium text-white mb-4">
                    Add Location under <span x-text="parentName"></span>
                </h3>
                <form wire:submit="create">
                    <div class="space-y-4">
                        <div>
                            <flux:input
                                label="Location Name"
                                wire:model="name"
                                placeholder="E.g Ikeja, Yaba, etc."
                                class="max-full"
                            />
                        </div>

                        <div>
                            <flux:input
                                label="Delivery Price (Optional)"
                                wire:model="delivery_price"
                                type="number"
                                step="0.01"
                                placeholder="2500"
                                class="max-full"
                            />
                            <p class="text-xs text-gray-400 mt-1">
                                (₦<span x-text="Number(parentPrice).toLocaleString('en-NG', {
                                    minimumFractionDigits: 2
                                })"></span>)
                            </p>
                            @error('delivery_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-2">
                            <flux:button type="button" variant="subtle" size="sm" x-on:click="closeModal()">
                                Cancel
                            </flux:button>
                            <flux:button type="submit" size="sm" variant="primary">
                                <flux:icon.loading wire:loading wire:target="create" />
                                <span wire:loading.remove wire:target="create">Add Sub-location</span>
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div
            x-show="modal === 'edit'"
            x-cloak
            class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
            <div
                x-on:click.outside="closeModal()"
                class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="text-lg font-medium text-white mb-4">Edit Location</h3>
                <form wire:submit="update">
                    <div class="space-y-4">
                        <div>
                            <flux:input
                                label="Location Name"
                                wire:model="name"
                                class="max-full"
                            />
                        </div>

                        <div>
                            <flux:input
                                label="Delivery Price"
                                wire:model="delivery_price"
                                type="number"
                                step="0.01"
                                class="max-full"
                            />
                        </div>

                        <div class="flex justify-end space-x-2">
                            <flux:button type="button" variant="subtle" size="sm" x-on:click="closeModal()">
                                Cancel
                            </flux:button>
                            <flux:button type="submit" variant="primary" size="sm">
                                <flux:icon.loading wire:loading wire:target="update" />
                                <span wire:loading.remove wire:target="update">Update</span>
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div
            x-show="modal === 'delete'"
            x-cloak
            class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
            <div
                x-on:click.outside="closeModal()"
                class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="text-lg font-medium text-white mb-4">Delete Location</h3>
                <p class="text-gray-300 mb-6">
                    Are you sure you want to delete
                    "<span x-text="locationName"></span>"?
                    This action cannot be undone.
                </p>
                <div class="flex justify-end space-x-2">
                    <flux:button type="button" variant="subtle" size="sm" x-on:click="closeModal()">
                        Cancel
                    </flux:button>
                    <flux:button type="button" variant="danger" size="sm" x-on:click="$wire.delete(locationId)">
                        <flux:icon.loading wire:loading wire:target="delete" />
                        <span wire:loading.remove wire:target="delete">Delete</span>
                    </flux:button>
                </div>
            </div>
        </div>
    </x-products.settings>
</section>
