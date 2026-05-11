{{-- resources/views/livewire/brand-owner/create-sale.blade.php --}}
<section class="w-full">
    @include('partials.sales-heading')
    <flux:heading class="sr-only">{{ __('Create Sales Campaign') }}</flux:heading>

    <x-brands.sales :heading="__('Create Sales Campaign')" :subheading="__('Set up a new sales campaign for your products')">
        @if($activeSale)
            <flux:callout
                icon="{{ $activeSale->is_active && $activeSale->ongoing ? 'clock' : ($activeSale->is_active && $activeSale->starts_at > now() ? 'clock' : 'pause') }}"
                class="mb-6 transition-all duration-300"
                color="{{ $activeSale->is_active && $activeSale->ongoing ? 'green' : ($activeSale->is_active && $activeSale->starts_at > now() ? 'yellow' : 'gray') }}"
            >
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full">
                    <div class="flex-1">
                        <flux:callout.heading>
                            <strong class="text-[1rem]">
                                @if($activeSale->is_active && $activeSale->ongoing)
                                    Sale is Live!
                                @elseif($activeSale->is_active && $activeSale->starts_at > now())
                                    Sale Scheduled
                                @else
                                    Sale is Inactive
                                @endif
                            </strong>
                        </flux:callout.heading>
                        <flux:callout.text class="mt-1">
                            @if($activeSale->is_active && $activeSale->ongoing)
                                Your sale "{{ $activeSale->name }}" is currently running.
                                {{ $activeSale->discount_type === 'percentage' ? $activeSale->discount_value . '% off' : '$' . number_format($activeSale->discount_value, 2) . ' off' }}.
                                Ends {{ $activeSale->ends_at->diffForHumans() }}.
                            @elseif($activeSale->is_active && $activeSale->starts_at > now())
                                Your sale "{{ $activeSale->name }}" is scheduled to start
                                {{ $activeSale->starts_at->diffForHumans() }}.
                                It will automatically become active at that time.
                            @else
                                Your sale "{{ $activeSale->name }}" is currently inactive.
                                Toggle the switch below to activate it and start offering discounts.
                            @endif
                        </flux:callout.text>
                    </div>

                    {{-- Toggle Switch inside Callout --}}
                    <div class="flex items-center gap-3 shrink-0">
                    <span class="text-xs font-medium {{ !$activeSale->is_active ? 'text-gray-500' : 'text-orange-600' }}">
                        {{ $activeSale->is_active ? 'Active' : 'Inactive' }}
                    </span>

                        <button
                            wire:click="toggleSaleStatus"
                            wire:loading.attr="disabled"
                            type="button"
                            class="
                            relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full
                            border-2 border-transparent transition-colors duration-300 ease-in-out
                            focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2
                            dark:focus:ring-offset-gray-900
                            {{ $activeSale->is_active ? 'bg-orange-600' : 'bg-gray-300 dark:bg-gray-600' }}
                        "
                            role="switch"
                            aria-checked="{{ $activeSale->is_active ? 'true' : 'false' }}"
                        >
                        <span
                            aria-hidden="true"
                            class="
                                pointer-events-none inline-block h-6 w-6 transform rounded-full
                                bg-white shadow-lg ring-0 transition duration-300 ease-in-out
                                flex items-center justify-center
                                {{ $activeSale->is_active ? 'translate-x-5' : 'translate-x-0' }}
                            "
                        >
                        </span>
                        </button>

                        {{-- Loading Indicator --}}
                        <div wire:loading wire:target="toggleSaleStatus" class="ml-2">
                            <svg class="animate-spin h-4 w-4 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </flux:callout>
            @elseif($selectedSale)
            <flux:callout
                icon="{{ $selectedSale->is_active && $selectedSale->ongoing ? 'clock' : ($selectedSale->is_active && $selectedSale->starts_at > now() ? 'clock' : 'pause') }}"
                class="mb-6 transition-all duration-300"
                color="{{ $selectedSale->is_active && $selectedSale->ongoing ? 'green' : ($selectedSale->is_active && $selectedSale->starts_at > now() ? 'yellow' : 'gray') }}"
            >
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full">
                    <div class="flex-1">
                        <flux:callout.heading>
                            <strong class="text-[1rem]">
                                @if($selectedSale->is_active && $selectedSale->ongoing)
                                    Sale is Live!
                                @elseif($selectedSale->is_active && $selectedSale->starts_at > now())
                                    Sale Scheduled
                                @else
                                    Sale is Inactive
                                @endif
                            </strong>
                        </flux:callout.heading>
                        <flux:callout.text class="mt-1">
                            @if($selectedSale->is_active && $selectedSale->ongoing)
                                Your sale "{{ $selectedSale->name }}" is currently running.
                                {{ $selectedSale->discount_type === 'percentage' ? $selectedSale->discount_value . '% off' : '$' . number_format($selectedSale->discount_value, 2) . ' off' }}.
                                Ends {{ $selectedSale->ends_at->diffForHumans() }}.
                            @elseif($selectedSale->is_active && $selectedSale->starts_at > now())
                                Your sale "{{ $selectedSale->name }}" is scheduled to start
                                {{ $selectedSale->starts_at->diffForHumans() }}.
                                It will automatically become active at that time.
                            @else
                                Your sale "{{ $selectedSale->name }}" is currently inactive.
                                Toggle the switch below to activate it and start offering discounts.
                            @endif
                        </flux:callout.text>
                    </div>

                    {{-- Toggle Switch inside Callout --}}
                    <div class="flex items-center gap-3 shrink-0">
                    <span class="text-xs font-medium {{ !$selectedSale->is_active ? 'text-gray-500' : 'text-orange-600' }}">
                        {{ $selectedSale->is_active ? 'Active' : 'Inactive' }}
                    </span>

                        <button
                            wire:click="toggleSaleStatus"
                            wire:loading.attr="disabled"
                            type="button"
                            class="
                            relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full
                            border-2 border-transparent transition-colors duration-300 ease-in-out
                            focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2
                            dark:focus:ring-offset-gray-900
                            {{ $selectedSale->is_active ? 'bg-orange-600' : 'bg-gray-300 dark:bg-gray-600' }}
                        "
                            role="switch"
                            aria-checked="{{ $selectedSale->is_active ? 'true' : 'false' }}"
                        >
                        <span
                            aria-hidden="true"
                            class="
                                pointer-events-none inline-block h-6 w-6 transform rounded-full
                                bg-white shadow-lg ring-0 transition duration-300 ease-in-out
                                flex items-center justify-center
                                {{ $selectedSale->is_active ? 'translate-x-5' : 'translate-x-0' }}
                            "
                        >
                        </span>
                        </button>

                        {{-- Loading Indicator --}}
                        <div wire:loading wire:target="toggleSaleStatus" class="ml-2">
                            <svg class="animate-spin h-4 w-4 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </flux:callout>
        @endif

        <form wire:submit="createSale">
            <flux:fieldset>
                <div class="space-y-6">
                    <flux:input
                        label="Sale Name"
                        wire:model="name"
                        placeholder="e.g., Summer Sale 2024, Black Friday, Flash Sale"
                        class="max-w-full"
                        :readonly="isset($selectedSale) && $selectedSale->ongoing"
                    />

                    <flux:textarea
                        label="Description"
                        resize="none"
                        wire:model="description"
                        placeholder="A short description of this sale (optional)"
                        :readonly="isset($selectedSale) && $selectedSale->ongoing"
                    />

                    <div class="space-y-3">
                        <flux:select
                            label="Sale Pricing Mode"
                            wire:model="sale_mode"
                            id="sale_mode"
                            :readonly="isset($selectedSale) && $selectedSale->ongoing"
                        >
                            <option value="generic">
                                Generic Sale
                            </option>

                            <option value="dynamic">
                                Dynamic Sale
                            </option>
                        </flux:select>

                        <div id="sale-mode-description" class="text-sm text-zinc-500">
                            Apply one discount rule across all selected products.
                        </div>
                    </div>

                    <div
                        id="generic-sale-fields"
                        class="grid grid-cols-2 gap-x-4 gap-y-6"
                    >
                        <div>
                            <flux:select
                                label="Discount Type"
                                wire:model="discount_type"
                                :readonly="isset($selectedSale) && $selectedSale->ongoing"
                            >
                                <option value="percentage">
                                    Percentage Discount (%)
                                </option>

                                <option value="fixed">
                                    Fixed Amount Discount (₦)
                                </option>
                            </flux:select>

                            <p class="mt-2 text-xs text-zinc-500">
                                Choose how discounts should be calculated.
                            </p>
                        </div>

                        <div>
                            <flux:input
                                label="Discount Value"
                                type="number"
                                step="0.01"
                                wire:model="discount_value"
                                placeholder="{{ $discount_type === 'percentage' ? 'e.g., 20' : 'e.g., 5000' }}"
                                :readonly="isset($selectedSale) && $selectedSale->ongoing"
                            />

                            <p class="mt-2 text-xs text-zinc-500">
                                Enter the amount customers should receive as discount.
                            </p>
                        </div>
                    </div>


                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <flux:input
                            label="Start Date & Time"
                            type="datetime-local"
                            wire:model="starts_at"
                            :readonly="isset($selectedSale) && $selectedSale->ongoing"
                        />
                        <flux:input
                            label="End Date & Time"
                            type="datetime-local"
                            wire:model="ends_at"
                            :readonly="isset($selectedSale) && $selectedSale->ongoing"
                        />
                    </div>

                    <div>
                        <flux:select label="Section" wire:model="section" :readonly="isset($selectedSale) && $selectedSale->ongoing">
                            <option value="0">All Products</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}"> {{$section->name}} </option>
                            @endforeach
                        </flux:select>
                    </div>

                    <flux:separator />

                    @if($selectedSale && $selectedSale->ongoing)
                        <div class="flex justify-end gap-3">
                            <flux:button type="button" variant="primary" size="sm" onclick="showEndSaleModal()">
                                <flux:icon.loading wire:loading wire:target="endSale" />
                                <span wire:loading.remove wire:target="endSale">End Sales</span>
                            </flux:button>
                        </div>
                    @else
                        <div class="flex justify-end gap-3">
                            <flux:button type="submit" variant="primary" size="sm">
                                <flux:icon.loading wire:loading wire:target="createSale" />
                                <span wire:loading.remove wire:target="createSale">{{ $selectedSale ? __('Update Sale') : __('Create Sale') }}</span>
                            </flux:button>
                        </div>
                    @endif
                </div>
            </flux:fieldset>
        </form>

        <div id="endSaleModal" class="fixed inset-0 bg-black/70 bg-opacity-20 flex items-center justify-center p-4 hidden" style="z-index: 50;">
            <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                <form id="endSaleForm" onsubmit="handleEndSale(event)">
                    <flux:fieldset>
                        <div class="space-y-4">
                            <p class="text-white mb-4">
                                Are you sure you want to end "<span id="saleName"></span>"?
                            </p>
                            <div class="flex justify-end items-center">
                                <flux:button
                                    type="button"
                                    variant="ghost"
                                    onclick="closeModal()"
                                    size="sm"
                                >
                                    Cancel
                                </flux:button>
                                <flux:button type="submit" size="sm" variant="danger" class="ml-2">
                                    <span>End sales</span>
                                </flux:button>
                            </div>
                        </div>
                    </flux:fieldset>
                </form>
            </div>
        </div>

    </x-brands.sales>
</section>

@push('scripts')

    <script>
        // Get the sale name from Livewire component
        function getSaleName() {
            // Access Livewire property
            return @json($selectedSale?->name ?? '');
        }

        // Show modal
        function showEndSaleModal() {
            const modal = document.getElementById('endSaleModal');
            const saleNameSpan = document.getElementById('saleName');

            // Set the sale name in modal
            saleNameSpan.textContent = getSaleName();

            // Show modal
            modal.classList.remove('hidden');

            // Prevent body scroll
            document.body.style.overflow = 'hidden';

            // Close on escape key
            document.addEventListener('keydown', handleEscapeKey);
        }

        // Close modal
        function closeModal() {
            const modal = document.getElementById('endSaleModal');
            modal.classList.add('hidden');

            // Restore body scroll
            document.body.style.overflow = '';

            // Remove escape key listener
            document.removeEventListener('keydown', handleEscapeKey);
        }

        // Handle escape key
        function handleEscapeKey(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        }

        // Handle form submission
        function handleEndSale(event) {
            event.preventDefault()

            // Call Livewire method
            @this.call('endSales');

            // Close modal after calling
            closeModal();
        }

        // Close modal when clicking outside
        document.getElementById('endSaleModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });

        const saleMode = document.getElementById('sale_mode');
        const genericFields = document.getElementById('generic-sale-fields');
        const description = document.getElementById('sale-mode-description');

        function toggleSaleModeFields() {

            if (saleMode.value === 'dynamic') {

                genericFields.style.display = 'none';

                description.innerText =
                    'Each product will manage its own discount independently. No global discount value will be applied.';

            } else {

                genericFields.style.display = 'grid';

                description.innerText =
                    'Apply one discount rule across all selected products. Example: Everything gets 20% off.';
            }
        }

        toggleSaleModeFields();

        saleMode.addEventListener('change', toggleSaleModeFields);
    </script>

@endpush
