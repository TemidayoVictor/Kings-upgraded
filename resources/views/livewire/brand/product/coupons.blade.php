{{-- resources/views/livewire/brand/product/coupons.blade.php --}}
<section class="w-full">
    @include('partials.products-settings-heading')
    <x-products.settings :heading="__('Coupons')" :subheading="__('Create and manage your coupons')">

        <flux:heading class="sr-only">{{ __('Coupons') }}</flux:heading>

        <div class="flex justify-end mb-4">
            <flux:button wire:click="openCreateModal" size="sm" variant="primary">
                Add Coupon
            </flux:button>
        </div>

        <flux:separator/>

        <div class="min-h-screen">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 my-3">
                    <flux:heading class="sr-only">{{ __('Coupon List') }}</flux:heading>
                </div>

                <!-- Sections List -->
                <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    @if($coupons->count() > 0)
                        <!-- Mobile Card View (visible only on mobile) -->
                        <div class=" divide-y divide-gray-500">
                            @foreach($coupons as $coupon)
                                <div class="p-4 hover:bg-gray-750 transition-colors">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center space-x-3">
                                            <div>
                                                <div class="font-medium text-gray-200">{{ $coupon->code }}</div>
                                                <div class="text-xs text-gray-500">{{ $coupon->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button
                                                wire:click="popup('edit', {{ $coupon->id }})"
                                                class="p-2 text-gray-400 hover:text-gray-200 transition-colors"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            @if($coupon->is_active)
                                                <button
                                                    wire:click="popup('deactivate', {{ $coupon->id }})"
                                                    class="p-2 text-gray-400 hover:text-red-400 transition-colors"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between mt-3 pt-2 border-t border-dashed border-gray-500">
                                        <div>
                                            <div class="text-xs text-gray-500">Type</div>
                                            <div class="text-sm text-gray-300 capitalize">{{ $coupon->type }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">Value</div>
                                            <div class="text-sm text-gray-300">
                                                @if($coupon->type === 'fixed')
                                                    ₦{{ number_format($coupon->value, 2) }}
                                                @else
                                                    {{ $coupon->value }}%
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $coupon->isValid() ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                                {{ $coupon->isValid() ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between mt-3 pt-2 border-t border-dashed border-gray-500">
                                        <div>
                                            <div class="text-xs text-gray-500">Start Date</div>
                                            <div class="text-sm text-gray-300 capitalize">{{ \Carbon\Carbon::parse($coupon->starts_at)->format('j F, Y') }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">Expires At</div>
                                            <div class="text-sm text-gray-300 capitalize">{{ \Carbon\Carbon::parse($coupon->expires_at)->format('j F, Y') }}</div>
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
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No coupons</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new coupon.</p>
                        </div>
                    @endif
                </div>

                @if($coupons->hasPages())
                    <div class="mt-6">
                        {{ $coupons->links() }}
                    </div>
                @endif
            </div>

            <!-- Create Modal -->
            @if($showCreateModal)
                <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
                    <div class="bg-[#27272a] rounded-lg w-full max-w-md p-6">
                        <h3 class="text-white text-lg font-semibold mb-4">Create Coupon</h3>

                        <form wire:submit="createCoupon" class="space-y-4">
                            <flux:input label="Code (6 characters)" wire:model="code" maxlength="6" />

                            <div>
                                <flux:select label="Coupon Type" wire:model.live="type">
                                    <option value="fixed">Fixed</option>
                                    <option value="percentage">Percentage</option>
                                </flux:select>
                            </div>

                            <div>
                                <flux:label class="mb-2">Value</flux:label>
                                <flux:input.group>
                                    @if($type === 'fixed')
                                        <flux:input.group.prefix>₦</flux:input.group.prefix>
                                    @endif
                                    <flux:input wire:model="value" placeholder="value" type="number" step="0.01" />
                                    @if($type === 'percentage')
                                        <flux:input.group.suffix>%</flux:input.group.suffix>
                                    @endif
                                </flux:input.group>
                            </div>

                            <flux:input label="Starts At" wire:model="startsAt" type="date" />
                            <flux:input label="Expires At" wire:model="expiresAt" type="date" />

                            <div class="flex justify-end space-x-2 pt-4">
                                <flux:button wire:click="closeModal" type="button" variant="subtle" size="sm">Cancel</flux:button>
                                <flux:button type="submit" variant="primary" size="sm">Create</flux:button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Edit Modal -->
            @if($showEditModal)
                <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
                    <div class="bg-[#27272a] rounded-lg w-full max-w-md p-6">
                        <div class="mb-4">
                            <h3 class="text-white text-lg font-semibold">Edit Coupon</h3>
                            <div class="text-xs text-gray-500">Editing an inactive coupon will reactivate it</div>
                        </div>

                        <form wire:submit="updateCoupon" class="space-y-4">
                            <flux:input label="Code (6 characters)" wire:model="code" maxlength="6" />

                            <div>
                                <flux:select label="Coupon Type" wire:model.live="type">
                                    <option value="fixed">Fixed</option>
                                    <option value="percentage">Percentage</option>
                                </flux:select>
                            </div>

                            <div>
                                <flux:label class="mb-2">Value</flux:label>
                                <flux:input.group>
                                    @if($type === 'fixed')
                                        <flux:input.group.prefix>₦</flux:input.group.prefix>
                                    @endif
                                    <flux:input wire:model="value" placeholder="value" type="number" step="0.01" />
                                    @if($type === 'percentage')
                                        <flux:input.group.suffix>%</flux:input.group.suffix>
                                    @endif
                                </flux:input.group>
                            </div>

                            <flux:input label="Starts At" wire:model="startsAt" type="date" />
                            <flux:input label="Expires At" wire:model="expiresAt" type="date" />

                            <div class="flex justify-end space-x-2 pt-4">
                                <flux:button wire:click="closeModal" type="button" variant="subtle" size="sm">Cancel</flux:button>
                                <flux:button type="submit" variant="primary" size="sm">Update</flux:button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Deactivate Confirmation Modal -->
            @if($showDeactivateModal)
                <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50">
                    <div class="bg-[#27272a] rounded-lg w-full max-w-md p-6">
                        <h3 class="text-white text-lg font-semibold mb-4">Deactivate Coupon</h3>

                        <p class="text-gray-300 mb-6">Are you sure you want to deactivate this coupon? It will no longer be available for use.</p>

                        <div class="flex justify-end space-x-2">
                            <flux:button wire:click="closeModal" type="button" variant="subtle" size="sm">Cancel</flux:button>
                            <flux:button wire:click="deactivateCoupon" type="button" variant="danger" size="sm">Deactivate</flux:button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-products.settings>
</section>
