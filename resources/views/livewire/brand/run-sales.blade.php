{{-- resources/views/livewire/brand-owner/create-sale.blade.php --}}
<section class="w-full">
    @include('partials.sales-heading')
    <flux:heading class="sr-only">{{ __('Create Sales Campaign') }}</flux:heading>

    <x-brands.sales :heading="__('Create Sales Campaign')" :subheading="__('Set up a new sales campaign for your products')">
        @php
            $sale = $activeSale ?? $selectedSale;

            $isLive = $sale?->is_active && $sale?->ongoing;
            $isScheduled = $sale?->is_active
                && $sale?->starts_at?->isFuture();

            $saleStatus = match (true) {
                $isLive => [
                    'title' => 'Sale is Live!',
                    'icon' => 'clock',
                    'color' => 'green',
                ],
                $isScheduled => [
                    'title' => 'Sale Scheduled',
                    'icon' => 'clock',
                    'color' => 'yellow',
                ],
                default => [
                    'title' => 'Sale is Inactive',
                    'icon' => 'pause',
                    'color' => 'gray',
                ],
            };

            $isActive = (bool) $sale?->is_active;
        @endphp

        @if($sale)
            <flux:callout
                icon="{{ $saleStatus['icon'] }}"
                color="{{ $saleStatus['color'] }}"
                class="mb-6 transition-all duration-300"
            >
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 w-full">

                    {{-- Sale Information --}}
                    <div class="flex-1">
                        <flux:callout.heading>
                            <strong class="text-[1rem]">
                                {{ $saleStatus['title'] }}
                            </strong>
                        </flux:callout.heading>

                        <flux:callout.text class="mt-1">
                            @if($isLive)
                                Your sale "{{ $sale->name }}" is currently running.
                                {{ $sale->discount_type === 'percentage'
                                    ? $sale->discount_value . '% off'
                                    : '$' . number_format($sale->discount_value, 2) . ' off'
                                }}.
                                Ends {{ $sale->ends_at->diffForHumans() }}.

                            @elseif($isScheduled)
                                Your sale "{{ $sale->name }}" is scheduled to start
                                {{ $sale->starts_at->diffForHumans() }}.
                                It will automatically become active at that time.

                            @else
                                Your sale "{{ $sale->name }}" is currently inactive.
                                Toggle the switch below to activate it and start offering discounts.
                            @endif
                        </flux:callout.text>
                    </div>

                    {{-- Status Switch --}}
                    <div class="flex items-center gap-3 shrink-0">

                        <span class="text-xs font-medium {{ $isActive ? 'text-orange-600' : 'text-gray-500' }}">
                            {{ $isActive ? 'Active' : 'Inactive' }}
                        </span>

                        <div x-data="{ showStatusModal: false }">

                            <button
                                @click="showStatusModal = true"
                                type="button"
                                class="
                            relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full
                            border-2 border-transparent transition-colors duration-300 ease-in-out
                            focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2
                            dark:focus:ring-offset-gray-900
                            {{ $isActive ? 'bg-orange-600' : 'bg-gray-300 dark:bg-gray-600' }}
                        "
                                role="switch"
                                aria-checked="{{ $isActive ? 'true' : 'false' }}"
                                aria-label="Toggle sale status"
                            >
                        <span
                            aria-hidden="true"
                            class="
                                pointer-events-none inline-block h-6 w-6 transform rounded-full
                                bg-white shadow-lg ring-0 transition duration-300 ease-in-out
                                flex items-center justify-center
                                {{ $isActive ? 'translate-x-5' : 'translate-x-0' }}
                            "
                        ></span>
                            </button>

                            {{-- Confirmation Modal --}}
                            <div
                                x-show="showStatusModal"
                                x-cloak
                                x-transition.opacity
                                @keydown.escape.window="showStatusModal = false"
                                class="fixed inset-0 bg-black/70 flex items-center justify-center p-4"
                                style="z-index: 50;"
                            >
                                <div
                                    @click.outside="showStatusModal = false"
                                    x-transition
                                    class="bg-[#27272a] rounded-xl shadow-xl max-w-md w-full p-6"
                                >
                                    <div class="space-y-4">

                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center size-10 rounded-full
                                        {{ $isActive ? 'bg-red-500/10 text-red-400' : 'bg-orange-500/10 text-orange-400' }}">

                                                <flux:icon
                                                    name="{{ $isActive ? 'pause-circle' : 'play-circle' }}"
                                                    class="size-6"
                                                />
                                            </div>

                                            <h3 class="text-lg font-semibold text-white">
                                                {{ $isActive ? 'Deactivate Sale?' : 'Activate Sale?' }}
                                            </h3>
                                        </div>

                                        <p class="text-sm text-gray-300 leading-relaxed">
                                            @if($isActive)
                                                Are you sure you want to deactivate
                                                <span class="font-semibold text-white">{{ $sale->name }}</span>?
                                                Customers will no longer be able to access this sale.
                                            @else
                                                Are you sure you want to activate
                                                <span class="font-semibold text-white">{{ $sale->name }}</span>?
                                                Your sale will become available according to its scheduled dates.
                                            @endif
                                        </p>

                                        <div class="flex justify-end items-center gap-2 pt-2">

                                            <flux:button
                                                type="button"
                                                variant="subtle"
                                                size="sm"
                                                @click="showStatusModal = false"
                                            >
                                                Cancel
                                            </flux:button>

                                            <flux:button
                                                type="button"
                                                size="sm"
                                                variant="{{ $isActive ? 'danger' : 'primary' }}"
                                                wire:click="toggleSaleStatus"
                                                wire:loading.attr="disabled"
                                                wire:target="toggleSaleStatus"
                                                @click="showStatusModal = false"
                                            >
                                                <flux:icon.loading
                                                    wire:loading
                                                    wire:target="toggleSaleStatus"
                                                />

                                                <span wire:loading.remove wire:target="toggleSaleStatus">
                                            {{ $isActive ? 'Deactivate Sale' : 'Activate Sale' }}
                                        </span>
                                            </flux:button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Loading Indicator --}}
                        <div wire:loading wire:target="toggleSaleStatus" class="ml-2">
                            <svg
                                class="animate-spin h-4 w-4 text-orange-600"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l-2.647z"
                                ></path>
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

                    @if($sale_mode == 'generic')
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
                    @endif

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

                    {{-- Search Tags --}}
                    <div class="space-y-3">

                        <div class="space-y-1">
                            <flux:label>Search Tags</flux:label>

                            <p class="text-xs text-zinc-500">
                                Add words or phrases customers might search for
                                when looking for this sale.
                            </p>
                        </div>

                        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-3 space-y-3">

                            {{-- Existing Tags --}}
                            <div class="flex flex-wrap gap-2">

                                @foreach($tags as $index => $tag)
                                    <span
                                        wire:key="sale-tag-{{ $index }}"
                                        class="inline-flex items-center gap-2 rounded-full
                                       bg-white
                                       px-3 py-1.5 text-xs font-medium
                                       text-black"
                                    >
                                        {{ $tag }}

                                        <button
                                            type="button"
                                            wire:click="removeTag({{ $index }})"
                                            wire:loading.attr="disabled"
                                            class="hover:opacity-60 transition"
                                            aria-label="Remove {{ $tag }}"
                                        >
                                            <flux:icon name="x-mark" class="size-3.5" />
                                        </button>
                                    </span>
                                @endforeach

                            </div>

                            {{-- Tag Input --}}
                            <div class="flex items-center gap-2">

                                <input
                                    type="text"
                                    wire:model="tagInput"
                                    x-on:keydown="if ($event.key === ',' || $event.key === 'Enter') {
                                        $event.preventDefault();
                                        $wire.addTag();
                                    }"
                                    maxlength="50"
                                    placeholder="e.g. Women's bags, Shoes, Clearance..."
                                    @disabled(count($tags) >= 10)
                                    class="min-w-0 flex-1 border-0 bg-transparent
                                       text-sm text-zinc-900 dark:text-white
                                       outline-none focus:ring-0
                                       placeholder:text-zinc-400"
                                />

                                <flux:button
                                    type="button"
                                    variant="primary"
                                    size="sm"
                                    wire:click="addTag"
                                    wire:loading.attr="disabled"
                                    :disabled="count($tags) >= 10"
                                >
                                    Add
                                </flux:button>

                            </div>

                        </div>

                        {{-- Instructions and Counter --}}
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-zinc-500">
                                Press Enter or comma to add a tag.
                            </p>
                            <p class="text-xs text-zinc-500">
                                {{ count($tags) }}/10 tags
                            </p>
                        </div>
                        @error('tags')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror

                        @error('tagInput')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror

                        @error('tags.*')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
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
