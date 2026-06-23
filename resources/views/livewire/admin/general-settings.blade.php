<section class="w-full">
    @include('partials.admin-heading')

    <flux:heading class="sr-only">{{ __('General System Settings') }}</flux:heading>

    <x-settings.layout :heading="__('General System Settings')" :subheading="__('Configure platform fees and limits')">
        <form wire:submit="save">
            <flux:fieldset>
                <div class="space-y-6">
                    <!-- Basic Plan Section -->
                    <div class="border-b border-gray-200 pb-4">
                        <flux:heading size="lg" class="mb-4">Basic Plan Settings</flux:heading>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <flux:input
                                label="Basic Fee (₦)"
                                type="number"
                                step="0.01"
                                wire:model="basic_fee"
                                placeholder="Basic subscription fee"
                            />
                            <flux:input
                                label="Max Products"
                                type="number"
                                wire:model="basic_products_number"
                                placeholder="Number of products allowed"
                            />
                            <flux:input
                                label="Max Images / Product"
                                type="number"
                                wire:model="basic_images_number"
                                placeholder="Images per product"
                            />
                        </div>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input
                                label="Additional Products Fee (₦)"
                                type="number"
                                step="0.01"
                                wire:model="basic_additional_products_fee"
                                placeholder="Fee for additional products"
                            />
                            <flux:input
                                label="Additional Products Number"
                                type="number"
                                step="0.01"
                                wire:model="basic_additional_products_number"
                                placeholder="Number of additional products"
                            />
                        </div>
                    </div>

                    <!-- Premium Plan Section -->
                    <div class="border-b border-gray-200 pb-4">
                        <flux:heading size="lg" class="mb-4">Premium Plan Settings</flux:heading>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <flux:input
                                label="Premium Fee (₦)"
                                type="number"
                                step="0.01"
                                wire:model="premium_fee"
                                placeholder="Premium subscription fee"
                            />
                            <flux:input
                                label="Max Products"
                                type="number"
                                wire:model="premium_products_number"
                                placeholder="Number of products allowed"
                            />
                            <flux:input
                                label="Max Images / Product"
                                type="number"
                                wire:model="premium_images_number"
                                placeholder="Images per product"
                            />
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input
                                label="Additional Products Fee (₦)"
                                type="number"
                                step="0.01"
                                wire:model="premium_additional_products_fee"
                                placeholder="Fee for additional products"
                            />
                            <flux:input
                                label="Additional Products Number"
                                type="number"
                                step="0.01"
                                wire:model="premium_additional_products_number"
                                placeholder="Number of additional products"
                            />
                        </div>
                    </div>

                    <!-- Platinum Plan Section -->
                    <div class="border-b border-gray-200 pb-4">
                        <flux:heading size="lg" class="mb-4">Platinum Plan Settings</flux:heading>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <flux:input
                                label="Platinum Fee (₦)"
                                type="number"
                                step="0.01"
                                wire:model="platinum_fee"
                                placeholder="Platinum subscription fee"
                            />
                            <flux:input
                                label="Max Products"
                                type="number"
                                wire:model="platinum_products_number"
                                placeholder="Number of products allowed"
                            />
                            <flux:input
                                label="Max Images / Product"
                                type="number"
                                wire:model="platinum_images_number"
                                placeholder="Images per product"
                            />
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input
                                label="Additional Products Fee (₦)"
                                type="number"
                                step="0.01"
                                wire:model="platinum_additional_products_fee"
                                placeholder="Fee for additional products"
                            />
                            <flux:input
                                label="Additional Products Number"
                                type="number"
                                step="0.01"
                                wire:model="platinum_additional_products_number"
                                placeholder="Number of additional products"
                            />
                        </div>
                    </div>

                    <!-- Commission Settings Section -->
                    <div class="border-b border-gray-200 pb-4">
                        <flux:heading size="lg" class="mb-4">Commission Settings</flux:heading>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input
                                label="Dropshipper Fee (₦)"
                                type="number"
                                step="0.01"
                                wire:model="dropshipper_fee"
                                placeholder="Fee for dropshippers"
                            />
                            <flux:input
                                label="Dropshipper Commission (%)"
                                type="number"
                                step="0.01"
                                wire:model="dropshipper_percent"
                                placeholder="Commission percentage"
                            />
                            <flux:input
                                label="Collector Commission (%)"
                                type="number"
                                step="0.01"
                                wire:model="collector_percent"
                                placeholder="Commission percentage for collectors"
                            />
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            All fields are required
                        </div>
                        <flux:button type="submit" variant="primary" size="sm">
                            <flux:icon.loading wire:loading wire:target="save" />
                            <span wire:loading.remove wire:target="save">{{ __('Save Settings') }}</span>
                            <span wire:loading wire:target="save">{{ __('Saving...') }}</span>
                        </flux:button>
                    </div>
                </div>
            </flux:fieldset>
        </form>
    </x-settings.layout>
</section>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('settings-updated', () => {
                // Optional: Add toast notification
                console.log('Settings updated');
            });
        });
    </script>
@endpush
