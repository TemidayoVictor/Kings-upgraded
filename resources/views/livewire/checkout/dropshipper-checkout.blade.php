{{-- resources/views/livewire/checkout/index.blade.php --}}
<div class="min-h-screen bg-[var(--store-bg)] py-8 sm:py-12 text-stone-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Premium Header Node -->
        <div class="mb-8 bg-white p-6 rounded-2xl border border-stone-200/60 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-light text-stone-950 tracking-tight">Secure Checkout</h1>
                <p class="text-xs sm:text-sm text-stone-500 mt-1">Complete your transaction details safely below.</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-medium text-stone-400 bg-stone-50 border border-stone-200 px-3 py-1.5 rounded-xl shrink-0">
                <i class="fa-solid fa-lock text-[10px] text-emerald-600"></i>
                <span>256-Bit SSL Encrypted</span>
            </div>
        </div>

        <!-- Elegant Progress Steps Timeline Track -->
        <div class="mb-10 max-w-xl mx-auto">
            <div class="flex items-center relative justify-between w-full">

                <!-- Background Connection Track Rails Line -->
                <div class="absolute left-0 top-5 right-0 h-[2px] bg-stone-200 -translate-y-1/2 z-0"></div>
                <div class="absolute left-0 top-5 h-[2px] bg-[var(--store-primary)] -translate-y-1/2 z-0 transition-all duration-300"
                     style="width: {{ $currentStep == 1 ? '0%' : ($currentStep == 2 ? '50%' : '100%') }};"></div>

                <!-- Step 1: Info Icon Circle Node -->
                <div class="relative z-10 flex flex-col items-center group">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full border-2 text-xs font-bold transition-all duration-300
                        {{ $currentStep >= 1 ? 'border-[var(--store-primary)] bg-[var(--store-primary)] text-white shadow-sm shadow-[var(--store-primary)]/20' : 'border-stone-300 bg-white text-stone-400' }}">
                        @if($currentStep > 1) <i class="fa-solid fa-check text-[10px]"></i> @else 1 @endif
                    </div>
                    <span class="mt-2 text-[11px] font-medium tracking-tight {{ $currentStep >= 1 ? 'text-stone-900 font-semibold' : 'text-stone-400' }}">Information</span>
                </div>

                <!-- Step 2: Delivery Icon Circle Node -->
                <div class="relative z-10 flex flex-col items-center group">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full border-2 text-xs font-bold transition-all duration-300
                        {{ $currentStep >= 2 ? 'border-[var(--store-primary)] bg-[var(--store-primary)] text-white shadow-sm shadow-[var(--store-primary)]/20' : 'border-stone-200 bg-white text-stone-400' }}">
                        @if($currentStep > 2) <i class="fa-solid fa-check text-[10px]"></i> @else 2 @endif
                    </div>
                    <span class="mt-2 text-[11px] font-medium tracking-tight {{ $currentStep >= 2 ? 'text-stone-900 font-semibold' : 'text-stone-400' }}">Delivery</span>
                </div>

                <!-- Step 3: Payment Icon Circle Node -->
                <div class="relative z-10 flex flex-col items-center group">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full border-2 text-xs font-bold transition-all duration-300
                        {{ $currentStep >= 3 ? 'border-[var(--store-primary)] bg-[var(--store-primary)] text-white shadow-sm shadow-[var(--store-primary)]/20' : 'border-stone-200 bg-white text-stone-400' }}">
                        3
                    </div>
                    <span class="mt-2 text-[11px] font-medium tracking-tight {{ $currentStep >= 3 ? 'text-stone-900 font-semibold' : 'text-stone-400' }}">Payment</span>
                </div>
            </div>
        </div>

        <!-- Master Split Columns Grid -->
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            <!-- Left Panel Column: Form Workspaces Drawer -->
            <div class="flex-1 w-full">
                <div class="bg-white rounded-2xl border border-stone-200/80 shadow-sm p-5 sm:p-8">

                    @if($currentStep === 1)
                        <!-- Step 1 Layout Panel View Workspace -->
                        <div class="space-y-6">
                            <div class="border-b border-stone-100 pb-3">
                                <h2 class="text-lg font-medium text-stone-950 tracking-tight">Customer Information</h2>
                                <p class="text-xs text-stone-400 mt-0.5">Please populate your baseline identity nodes for dispatch tracking profiles.</p>
                            </div>

                            <div class="space-y-4 [&_input]:text-stone-950 [&_input]:border-stone-400 [&_input]:focus:border-[var(--store-primary)] [&_input]:focus:ring-1 [&_input]:focus:ring-[var(--store-primary)]">

                                <flux:input label="Full Name" wire:model="customer_name" placeholder="Adekunle Haruna Ciroma" class="max-full" />

                                <flux:input label="Email Address" wire:model="customer_email" type="email" placeholder="ade@example.com" class="max-full" />

                                <flux:input label="Phone Number" wire:model="customer_phone" placeholder="+234 800 000 0000" class="max-full" />

                            </div>
                        </div>
                    @endif

                    @if($currentStep === 2)
                        <!-- Step 2 Layout Panel View Workspace -->
                        <div class="space-y-6">
                            <div class="border-b border-stone-100 pb-3">
                                <h2 class="text-lg font-medium text-stone-950 tracking-tight">Delivery Information</h2>
                                <p class="text-xs text-stone-400 mt-0.5">Specify destination rulesets to calculate line logistics costs accurately.</p>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wider mb-2.5">Select Delivery Location</label>
                                    <div class="space-y-2.5">
                                        @foreach($delivery_locations as $location)
                                            <div class="border border-stone-200 rounded-xl overflow-hidden shadow-xs transition-all {{ $delivery_location_id == $location->id || $this->isParentOfSelectedChild($location->id) ? 'border-stone-400 ring-1 ring-stone-200 bg-stone-50/30' : 'bg-white' }}">
                                                <!-- Parent Option Row -->
                                                <div class="flex items-center p-4">
                                                    <input
                                                        type="radio"
                                                        id="loc-{{ $location->id }}"
                                                        name="delivery_location"
                                                        value="{{ $location->id }}"
                                                        wire:click="selectDeliveryLocation({{ $location->id }})"
                                                        class="w-4 h-4 text-[var(--store-primary)] border-stone-300 focus:ring-0 focus:ring-offset-0 focus:outline-none"
                                                        {{ $delivery_location_id == $location->id ? 'checked' : '' }}
                                                    >
                                                    <label for="loc-{{ $location->id }}" class="ml-3 flex-1 flex items-center justify-between cursor-pointer select-none">
                                                        <span class="text-sm font-medium text-stone-900">{{ $location->name }}</span>
                                                        <span class="text-xs font-bold text-stone-600">₦{{ number_format($location->delivery_price) }}</span>
                                                    </label>
                                                </div>

                                                <!-- Cascading Nested Multi-Tiered Child Node Slots -->
                                                @if($location->children->count() > 0 && ($delivery_location_id == $location->id || $this->isParentOfSelectedChild($location->id)))
                                                    <div class="pl-11 pr-4 pb-4 space-y-2.5 border-t border-stone-200 pt-3 bg-stone-50/70">
                                                        @foreach($location->children as $child)
                                                            <div class="flex items-center py-1.5 px-2.5 rounded-lg border border-stone-300 bg-white">
                                                                <input
                                                                    type="radio"
                                                                    id="loc-{{ $child->id }}"
                                                                    name="delivery_location"
                                                                    value="{{ $child->id }}"
                                                                    wire:click="selectDeliveryLocation({{ $child->id }})"
                                                                    class="w-3.5 h-3.5 text-[var(--store-primary)] border-stone-300 focus:ring-0 focus:ring-offset-0"
                                                                    {{ $delivery_location_id == $child->id ? 'checked' : '' }}
                                                                >
                                                                <label for="loc-{{ $child->id }}" class="ml-2.5 flex-1 flex items-center justify-between cursor-pointer select-none">
                                                                    <span class="text-xs font-medium text-stone-700">{{ $child->name }}</span>
                                                                    <span class="text-[11px] font-semibold text-stone-500">
                                                                        @if($child->delivery_price)
                                                                            ₦{{ number_format($child->delivery_price) }}
                                                                        @else
                                                                            <span class="text-[10px] text-stone-400 font-normal">(Inherits ₦{{ number_format($child->effective_price) }})</span>
                                                                        @endif
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('delivery_location_id') <span class="text-rose-600 text-xs mt-1 block font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                                </div>

                                <!-- Street Address -->
                                <div class="[&_input]:border-stone-400 [&_input]:text-stone-950 [&_input]:focus:border-[var(--store-primary)] [&_input]:focus:ring-0">
                                    <flux:input label="Street Address" wire:model="delivery_address" placeholder="123 Main Street" class="max-full" />
                                </div>

                                <!-- State & City Grid -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- State Select (Removing focus rings, keeping solid border) -->
                                    <div class="[&_button]:border-stone-400 [&_button]:text-stone-950 [&_button]:focus:border-[var(--store-primary)] [&_button]:focus:ring-0">
                                        <flux:select label="State" wire:model="delivery_state">
                                            <option>Select State</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state }}">{{ $state }}</option>
                                            @endforeach
                                        </flux:select>
                                    </div>
                                    <!-- City Input -->
                                    <div class="[&_input]:border-stone-400 [&_input]:text-stone-950 [&_input]:focus:border-[var(--store-primary)] [&_input]:focus:ring-0">
                                        <flux:input label="City" wire:model="delivery_city" placeholder="Ikeja" class="max-full" />
                                    </div>
                                </div>

                                <!-- Zip/Postal Code -->
                                <div class="[&_input]:border-stone-400 [&_input]:text-stone-950 [&_input]:focus:border-[var(--store-primary)] [&_input]:focus:ring-0">
                                    <flux:input label="Zip/Postal Code (Optional)" wire:model="delivery_zip" placeholder="100001" class="max-full" />
                                </div>

                                <!-- Delivery Instructions -->
                                <div class="[&_textarea]:border-stone-400 [&_textarea]:text-stone-950 [&_textarea]:focus:border-[var(--store-primary)] [&_textarea]:focus:ring-0">
                                    <flux:textarea label="Delivery Instructions (Optional)" wire:model="delivery_instructions" placeholder="Gate code, alternative phone, near landmark, etc." class="max-full" />
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($currentStep === 3)
                        <!-- Step 3 Layout Panel View Workspace -->
                        <div class="space-y-6">
                            <div class="border-b border-stone-100 pb-3">
                                <h2 class="text-lg font-medium text-stone-950 tracking-tight">Payment Method</h2>
                                <p class="text-xs text-stone-400 mt-0.5">Select a primary transaction layer framework execution strategy.</p>
                            </div>

                            <div class="space-y-3">
                                <!-- Added name="payment_method" to all radio buttons to ensure browser-level exclusive selection -->

                                <!-- Card Layer -->
                                <label class="flex items-center p-4 border border-stone-400 rounded-xl cursor-pointer hover:bg-stone-50 transition-all select-none group [has(:checked)]:border-[var(--store-primary)] [has(:checked)]:bg-[var(--store-primary)]/[0.02]">
                                    <input type="radio" name="payment_method" wire:model="payment_method" value="card" class="w-4 h-4 text-[var(--store-primary)] border-stone-400 focus:ring-0">
                                    <span class="ml-3.5 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-stone-100 group-has-[:checked]:bg-white border border-stone-300 flex items-center justify-center text-stone-500 group-has-[:checked]:text-[var(--store-primary)]">
                                            <i class="fa-solid fa-credit-card text-xs"></i>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-stone-950 block">Credit/Debit Card Terminal</span>
                                            <span class="text-[10px] text-stone-400 block font-normal">Instant activation processing over secure channels</span>
                                        </div>
                                    </span>
                                </label>

                                <!-- Transfer Layer -->
                                <label class="flex items-center p-4 border border-stone-400 rounded-xl cursor-pointer hover:bg-stone-50 transition-all select-none group [has(:checked)]:border-[var(--store-primary)] [has(:checked)]:bg-[var(--store-primary)]/[0.02]">
                                    <input type="radio" name="payment_method" wire:model="payment_method" value="bank_transfer" class="w-4 h-4 text-[var(--store-primary)] border-stone-400 focus:ring-0">
                                    <span class="ml-3.5 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-stone-100 group-has-[:checked]:bg-white border border-stone-300 flex items-center justify-center text-stone-500 group-has-[:checked]:text-[var(--store-primary)]">
                                            <i class="fa-solid fa-building-columns text-xs"></i>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-stone-950 block">Direct Bank Electronic Transfer</span>
                                            <span class="text-[10px] text-stone-400 block font-normal">Generate temporary checkout nodes matching totals</span>
                                        </div>
                                    </span>
                                </label>

                                <!-- COD Layer -->
                                <label class="flex items-center p-4 border border-stone-400 rounded-xl cursor-pointer hover:bg-stone-50 transition-all select-none group [has(:checked)]:border-[var(--store-primary)] [has(:checked)]:bg-[var(--store-primary)]/[0.02]">
                                    <input type="radio" name="payment_method" wire:model="payment_method" value="cash_on_delivery" class="w-4 h-4 text-[var(--store-primary)] border-stone-400 focus:ring-0">
                                    <span class="ml-3.5 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-stone-100 group-has-[:checked]:bg-white border border-stone-300 flex items-center justify-center text-stone-500 group-has-[:checked]:text-[var(--store-primary)]">
                                            <i class="fa-solid fa-hand-holding-dollar text-xs"></i>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-stone-950 block">Cash on Delivery (COD)</span>
                                            <span class="text-[10px] text-stone-400 block font-normal">Pay physically on site arrival within approved bounds</span>
                                        </div>
                                    </span>
                                </label>
                            </div>

                            <!-- Textarea with high contrast and no outline -->
                            <div class="[&_textarea]:border-stone-400 [&_textarea]:text-stone-950 [&_textarea]:focus:border-[var(--store-primary)] [&_textarea]:focus:ring-0">
                                <flux:textarea label="Order Notes (Optional)" wire:model="customer_notes" placeholder="Any special dispatch requests or landmark delivery notations?" class="max-full" />
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mt-6 pt-4 border-t border-stone-100">
                                <label class="flex items-start cursor-pointer select-none group">
                                    <input type="checkbox" wire:model="termsAccepted" class="w-4 h-4 rounded border-stone-400 text-[var(--store-primary)] focus:ring-0 mt-0.5">
                                    <span class="ml-2.5 text-xs text-stone-500 leading-relaxed">
                                        I certify full review and acknowledge absolute agreement matching the digital store parameters specified inside the <a href="#" class="text-stone-950 font-semibold underline decoration-stone-200 hover:text-[var(--store-primary)]">Terms and Conditions</a> framework.
                                    </span>
                                </label>
                                @error('termsAccepted') <span class="text-rose-600 text-xs block mt-2 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif

                    <!-- Control Stepper Interface Footers Action Grid Row -->
                    <div class="flex items-center justify-between mt-8 pt-5 border-t border-stone-200/60">
                        @if($currentStep > 1)
                            <button type="button" wire:click="previousStep" wire:key="back-btn" class="inline-flex items-center gap-2 text-xs font-semibold text-stone-600 bg-stone-50 hover:bg-stone-100 border border-stone-200 px-4 py-2.5 rounded-xl transition-colors">
                                <i class="fa-solid fa-arrow-left-long text-[9px] min-w-[12px]" wire:loading.remove wire:target="previousStep"></i>
                                <i class="fa-solid fa-spinner fa-spin text-[10px] min-w-[12px]" wire:loading wire:target="previousStep"></i>
                                <span>Back</span>
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if($currentStep < 3)
                            <button type="button" wire:click="nextStep" wire:key="{{$currentStep}}" class="inline-flex items-center gap-2 text-xs font-semibold text-white bg-[var(--store-primary)] hover:bg-[var(--store-primary-hover)] px-5 py-2.5 rounded-xl shadow-xs transition-colors">
                                <span>Continue</span>
                                <i class="fa-solid fa-arrow-right-long text-[9px] min-w-[12px]" wire:loading.remove wire:target="nextStep"></i>
                                <i class="fa-solid fa-spinner fa-spin text-[10px] min-w-[12px]" wire:loading wire:target="nextStep"></i>
                            </button>
                        @else
                            <button type="button" wire:click="placeOrder" wire:key="place-order" class="inline-flex items-center gap-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-6 py-2.5 rounded-xl shadow-md shadow-emerald-600/10 transition-colors">
                                <span>Place Secure Order</span>
                                <i class="fa-solid fa-circle-check text-xs min-w-[12px]" wire:loading.remove wire:target="placeOrder"></i>
                                <i class="fa-solid fa-spinner fa-spin text-[10px] min-w-[12px]" wire:loading wire:target="placeOrder"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Panel Column: Static Floating Summary Manifest -->
            <div class="w-full lg:w-96 shrink-0 lg:sticky lg:top-24">
                <div class="bg-white rounded-2xl p-6 border border-stone-200/80 shadow-sm">
                    <h2 class="text-base font-semibold text-stone-950 tracking-tight pb-3 border-b border-stone-100 mb-4">Summary Manifest</h2>

                    <!-- Inline Itemized Line Loops Container Tracker -->
                    <div class="space-y-3 mb-5 max-h-56 overflow-y-auto pr-1 divide-y divide-stone-50">
                        @foreach($cartItems as $item)
                            <div class="flex items-start gap-3 pt-3 first:pt-0">
                                <div class="w-12 h-14 bg-stone-50 border border-stone-200/70 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    @if($item->dropshipperProduct->originalProduct && $item->dropshipperProduct->originalProduct->images->count() > 0)
                                        <img src="{{ $item->dropshipperProduct->originalProduct->primary_image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-stone-300"><i class="fa-solid fa-image text-xs"></i></div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-medium text-stone-900 truncate leading-tight">{{ $item->product_name }}</h4>
                                    <span class="inline-block mt-1 text-[10px] font-semibold text-stone-400 bg-stone-100 px-1.5 py-0.5 rounded">Qty: {{ $item->quantity }}</span>
                                </div>
                                <span class="text-xs font-semibold text-stone-950 whitespace-nowrap">₦{{ number_format($item->total) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Financial Ledger Data Aggregation Rows Grid Node -->
                    <div class="space-y-3 pt-4 border-t border-stone-200/60 text-xs sm:text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-stone-500">Cart Subtotal</span>
                            <span class="font-medium text-stone-800">₦{{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-stone-500">Estimated VAT (7.5%)</span>
                            <span class="font-medium text-stone-800">₦{{ number_format($tax) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-stone-500">Logistics Routing Fees</span>
                            <span class="font-medium text-stone-800">₦{{ number_format($shipping) }}</span>
                        </div>

                        @if($delivery_location_id)
                            <div class="flex justify-between items-start bg-stone-50 border border-stone-200/40 rounded-xl px-2.5 py-2 text-[11px]">
                                <span class="text-stone-400 flex items-center gap-1"><i class="fa-solid fa-map-location-dot"></i> Route Profile</span>
                                <span class="font-semibold text-stone-700 text-right max-w-[150px] truncate">{{ $cart->location ? $cart->location->name : '--' }}</span>
                            </div>
                        @endif

                        @if($discount > 0)
                            <div class="flex justify-between items-center text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-1 rounded-lg">
                                <span class="font-medium text-[11px] flex items-center gap-1"><i class="fa-solid fa-tag"></i> Active Deductions</span>
                                <span class="font-bold">-₦{{ number_format($discount) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-baseline pt-4 border-t border-stone-200">
                            <span class="text-base font-semibold text-stone-950">Grand Total</span>
                            <span class="text-xl font-bold text-[var(--store-primary)] tracking-tight">₦{{ number_format($total) }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
