<div class="min-h-screen bg-[var(--surface)] py-8 sm:py-16 text-[var(--on-surface)] antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Editorial header --}}
        <div class="border-b border-[var(--outline-variant)]/30 pb-8 mb-10">
            <span class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[var(--outline)] block mb-2">
                Secure Order Processing
            </span>
            <h1 class="font-editorial text-3xl sm:text-5xl tracking-tight text-[var(--on-surface)] uppercase">
                Checkout
            </h1>
        </div>

        {{-- Stepper --}}
        <div class="mb-12 max-w-3xl mx-auto">
            <div class="flex items-center w-full relative">

                {{-- Step 1 --}}
                <div class="flex items-center relative z-10 bg-[var(--surface)] pr-4">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full text-xs font-semibold tracking-wider transition-all duration-500 border
                        {{ $currentStep > 1 ? 'bg-[var(--on-surface)] border-[var(--on-surface)] text-white' : ($currentStep === 1 ? 'bg-[var(--on-surface)] border-[var(--on-surface)] text-white shadow-md' : 'bg-white border-[var(--outline-variant)] text-[var(--outline)]') }}">
                        @if($currentStep > 1)
                            <i class="fa-solid fa-check text-[10px]"></i>
                        @else
                            1
                        @endif
                    </div>
                    <span class="ml-3 text-xs font-medium uppercase tracking-widest hidden sm:inline
                        {{ $currentStep >= 1 ? 'text-[var(--on-surface)]' : 'text-[var(--outline)]' }}">
                        Information
                    </span>
                </div>

                <div class="flex-1 h-[2px] -mx-1 transition-colors duration-500
                    {{ $currentStep > 1 ? 'bg-[var(--on-surface)]' : 'bg-[var(--outline-variant)]/50' }}"></div>

                {{-- Step 2 --}}
                <div class="flex items-center relative z-10 bg-[var(--surface)] px-4">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full text-xs font-semibold tracking-wider transition-all duration-500 border
                        {{ $currentStep > 2 ? 'bg-[var(--on-surface)] border-[var(--on-surface)] text-white' : ($currentStep === 2 ? 'bg-[var(--on-surface)] border-[var(--on-surface)] text-white shadow-md' : 'bg-white border-[var(--outline-variant)] text-[var(--outline)]') }}">
                        @if($currentStep > 2)
                            <i class="fa-solid fa-check text-[10px]"></i>
                        @else
                            2
                        @endif
                    </div>
                    <span class="ml-3 text-xs font-medium uppercase tracking-widest hidden sm:inline
                        {{ $currentStep >= 2 ? 'text-[var(--on-surface)]' : 'text-[var(--outline)]' }}">
                        Delivery
                    </span>
                </div>

                <div class="flex-1 h-[2px] -mx-1 transition-colors duration-500
                    {{ $currentStep > 2 ? 'bg-[var(--on-surface)]' : 'bg-[var(--outline-variant)]/50' }}"></div>

                {{-- Step 3 --}}
                <div class="flex items-center relative z-10 bg-[var(--surface)] pl-4">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full text-xs font-semibold tracking-wider transition-all duration-500 border
                        {{ $currentStep === 3 ? 'bg-[var(--on-surface)] border-[var(--on-surface)] text-white shadow-md' : 'bg-white border-[var(--outline-variant)] text-[var(--outline)]' }}">
                        3
                    </div>
                    <span class="ml-3 text-xs font-medium uppercase tracking-widest hidden sm:inline
                        {{ $currentStep >= 3 ? 'text-[var(--on-surface)]' : 'text-[var(--outline)]' }}">
                        Payment
                    </span>
                </div>
            </div>
        </div>

        {{-- Main grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

            {{-- FORM --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl p-6 sm:p-10 border border-[var(--outline-variant)]/25 shadow-xs">

                    {{-- STEP 1: Customer Information --}}
                    @if($currentStep === 1)
                        <div class="space-y-6">
                            <div>
                                <h2 class="font-editorial text-xl text-[var(--on-surface)] tracking-tight">
                                    Customer Information
                                </h2>
                                <p class="text-xs text-[var(--outline)] font-light mt-1">
                                    Fill in your details to complete your order
                                </p>
                            </div>

                            <div class="space-y-5 pt-2 checkout-custom-inputs">
                                <flux:input label="Full Name" wire:model="customer_name" placeholder="Adekunle Haruna Ciroma" class="w-full text-xs" />
                                <flux:input label="Email Address" wire:model="customer_email" type="email" placeholder="ade@example.com" class="w-full text-xs" />
                                <flux:input label="Phone Number" wire:model="customer_phone" placeholder="+234 800 000 0000" class="w-full text-xs" />
                            </div>
                        </div>
                    @endif

                    {{-- STEP 2: Delivery Location --}}
                    @if($currentStep === 2)
                        <div class="space-y-6">
                            <div>
                                <h2 class="font-editorial text-xl text-[var(--on-surface)] tracking-tight">
                                    Delivery Location
                                </h2>
                                <p class="text-xs text-[var(--outline)] font-light mt-1">
                                    Select your delivery location
                                </p>
                            </div>

                            <div class="space-y-5 pt-2 checkout-custom-inputs">

                                {{-- Location radios --}}
                                <div>
                                    <div class="space-y-3">
                                        @foreach($delivery_locations as $location)
                                            <div class="border rounded-2xl overflow-hidden transition-all duration-300 bg-[var(--surface-low)]/40 {{ $delivery_location_id == $location->id || $this->isParentOfSelectedChild($location->id) ? 'border-[var(--on-surface)] ring-1 ring-[var(--on-surface)]/5 shadow-xs' : 'border-[var(--outline-variant)]/30' }}">

                                                {{-- Parent --}}
                                                <div class="flex items-center p-4 hover:bg-[var(--surface-low)]/60 transition-colors">
                                                    <input
                                                        type="radio"
                                                        name="delivery_location"
                                                        value="{{ $location->id }}"
                                                        wire:click="selectDeliveryLocation({{ $location->id }})"
                                                        id="loc-{{ $location->id }}"
                                                        class="w-4 h-4 text-[var(--on-surface)] bg-white border-[var(--outline-variant)] focus:ring-0 outline-none focus:ring-offset-0"
                                                        {{ $delivery_location_id == $location->id ? 'checked' : '' }}
                                                    >
                                                    <label for="loc-{{ $location->id }}" class="ml-3.5 flex-1 flex items-center justify-between cursor-pointer select-none">
                                                        <span class="text-sm font-medium text-[var(--on-surface)]">{{ $location->name }}</span>
                                                        <span class="text-sm font-semibold text-[var(--on-surface)]">₦{{ number_format($location->delivery_price) }}</span>
                                                    </label>
                                                </div>

                                                {{-- Children --}}
                                                @if($location->children->count() > 0 && ($delivery_location_id == $location->id || $this->isParentOfSelectedChild($location->id)))
                                                    <div class="pl-11 pr-5 pb-4 space-y-2 bg-white border-t border-[var(--outline-variant)]/30 pt-3">
                                                        @foreach($location->children as $child)
                                                            <div class="flex items-center py-2 px-3 rounded-xl hover:bg-[var(--surface-low)]/60 transition-colors">
                                                                <input
                                                                    type="radio"
                                                                    name="delivery_location"
                                                                    value="{{ $child->id }}"
                                                                    wire:click="selectDeliveryLocation({{ $child->id }})"
                                                                    id="loc-{{ $child->id }}"
                                                                    class="w-3.5 h-3.5 text-[var(--on-surface)] bg-white border-[var(--outline-variant)] focus:ring-0 outline-none focus:ring-offset-0"
                                                                    {{ $delivery_location_id == $child->id ? 'checked' : '' }}
                                                                >
                                                                <label for="loc-{{ $child->id }}" class="ml-3 flex-1 flex items-center justify-between cursor-pointer select-none">
                                                                    <span class="text-xs text-[var(--on-surface-variant)] font-light">{{ $child->name }}</span>
                                                                    <span class="text-xs font-medium text-[var(--on-surface)]">
                                                                        @if($child->delivery_price)
                                                                            ₦{{ number_format($child->delivery_price) }}
                                                                        @else
                                                                            <span class="text-[10px] text-[var(--outline)] font-light">
                                                                                (Inherits ₦{{ number_format($child->effective_price) }})
                                                                            </span>
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

                                    @error('delivery_location_id')
                                    <p class="text-rose-600 text-[11px] mt-2 font-medium flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-exclamation text-[9px]"></i> {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                {{-- Address --}}
                                <flux:input label="Street Address" wire:model="delivery_address" placeholder="123 Main Street" class="w-full text-xs" />

                                <div class="grid grid-cols-2 gap-4">
                                    <flux:select label="State" wire:model="delivery_state" class="text-xs">
                                        <option>Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state }}">{{ $state }}</option>
                                        @endforeach
                                    </flux:select>
                                    <flux:input label="City" wire:model="delivery_city" placeholder="Ikeja" class="w-full text-xs" />
                                </div>

                                <flux:input label="Zip/Postal Code (Optional)" wire:model="delivery_zip" placeholder="100001" class="w-full text-xs" />
                                <flux:textarea label="Delivery Instructions (Optional)" wire:model="delivery_instructions" placeholder="Gate code, landmark specifications, etc." class="w-full text-xs" />
                            </div>
                        </div>
                    @endif

                    {{-- STEP 3: Complete Order --}}
                    @if($currentStep === 3)
                        <div>
                            <div>
                                <h2 class="font-editorial text-xl text-[var(--on-surface)] tracking-tight">
                                    Complete Order
                                </h2>
                                <p class="text-xs text-[var(--outline)] font-light mt-1">
                                    Make Payment to complete your Order
                                </p>
                            </div>

                            <div class="checkout-custom-inputs">
                                <div class="pt-4">
                                    <flux:textarea label="Order Notes (Optional)" wire:model="customer_notes" placeholder="Add any extra information for the brand owner" class="w-full text-xs" />
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Navigation --}}
                    <div class="flex items-center justify-between mt-10 pt-6 border-t border-[var(--outline-variant)]/30">
                        @if($currentStep > 1)
                            <button
                                type="button"
                                wire:click="previousStep"
                                wire:key="back-btn"
                                class="inline-flex items-center gap-2 border border-[var(--outline-variant)] hover:border-[var(--on-surface)] text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] text-xs font-semibold px-6 py-3 rounded-xl transition-all active:scale-[0.98]"
                            >
                                <i wire:loading wire:target="previousStep" class="fa-solid fa-spinner animate-spin text-[10px]"></i>
                                <span wire:loading.remove wire:target="previousStep">
                                    <i class="fa-solid fa-chevron-left text-[9px] mr-1"></i> Back
                                </span>
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if($currentStep < 3)
                            <button
                                type="button"
                                wire:click="nextStep"
                                wire:key="continue-btn-{{ $currentStep }}"
                                class="inline-flex items-center gap-2 bg-[var(--on-surface)] hover:bg-[var(--secondary)] text-white text-xs font-semibold px-6 py-3.5 rounded-xl transition-all shadow-md active:scale-[0.98]"
                            >
                                <i wire:loading wire:target="nextStep" class="fa-solid fa-spinner animate-spin text-[10px]"></i>
                                <span wire:loading.remove wire:target="nextStep">
                                    Continue <i class="fa-solid fa-chevron-right text-[9px] ml-1"></i>
                                </span>
                            </button>
                        @else
                            <button
                                type="button"
                                wire:click="placeOrder"
                                wire:key="place-order-btn"
                                class="inline-flex items-center gap-2 bg-[var(--on-surface)] hover:bg-[var(--secondary)] text-white text-xs font-semibold tracking-widest uppercase px-8 py-4 rounded-xl transition-all shadow-lg active:scale-[0.98]"
                            >
                                <i wire:loading wire:target="placeOrder" class="fa-solid fa-spinner animate-spin text-[11px]"></i>
                                <span wire:loading.remove wire:target="placeOrder">{{ __('Place Order') }}</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ORDER SUMMARY --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[var(--outline-variant)]/25 shadow-lg shadow-black/[0.02] sticky top-32 space-y-6">
                    <h2 class="font-editorial text-xl text-[var(--on-surface)] tracking-tight">
                        Order Summary
                    </h2>

                    {{-- Items --}}
                    <div class="space-y-4 mb-2 max-h-64 overflow-y-auto pr-1 divide-y divide-[var(--outline-variant)]/20">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-3 pt-4 {{ $loop->first ? 'pt-0 border-none' : '' }}">
                                <div class="w-12 h-14 bg-[var(--surface-low)] rounded-lg overflow-hidden shrink-0 relative">
                                    @if($item->product && $item->product->images->count() > 0)
                                        <img src="{{ $item->product->primary_image_url }}"
                                             alt="{{ $item->product_name }}"
                                             class="absolute inset-0 w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <span class="text-[var(--outline)] text-[10px] font-bold uppercase">
                                                {{ substr($item->product_name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0 space-y-0.5">
                                    <p class="text-xs font-medium text-[var(--on-surface)] truncate">
                                        {{ $item->product_name }}
                                    </p>
                                    <p class="text-[11px] text-[var(--outline)] font-light">
                                        Quantity: <span class="text-[var(--on-surface)] font-medium">{{ $item->quantity }}</span>
                                    </p>
                                </div>
                                <span class="text-xs font-semibold text-[var(--on-surface)] shrink-0">
                                    ₦{{ number_format($item->total) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Totals --}}
                    <div class="space-y-3.5 pt-5 border-t border-[var(--outline-variant)]/30 text-xs text-[var(--on-surface-variant)] font-light">
                        <div class="flex justify-between items-center">
                            <span>Subtotal</span>
                            <span class="text-[var(--on-surface)] font-medium">₦{{ number_format($subtotal) }}</span>
                        </div>
{{--                        <div class="flex justify-between items-center">--}}
{{--                            <span>VAT (7.5%)</span>--}}
{{--                            <span class="text-[var(--on-surface)] font-medium">₦{{ number_format($tax) }}</span>--}}
{{--                        </div>--}}
                        <div class="flex justify-between items-center">
                            <span>Shipping Fee</span>
                            <span class="text-[var(--on-surface)] font-medium">₦{{ number_format($shipping) }}</span>
                        </div>

                        @if($delivery_location_id)
                            <div class="flex justify-between items-start bg-[var(--surface-low)]/70 p-3 rounded-xl border border-[var(--outline-variant)]/30 text-[11px]">
                                <span class="text-[var(--outline)]">Delivery Location</span>
                                <span class="text-[var(--on-surface)] font-medium text-right max-w-[140px] truncate">
                                    {{ $cart->location ? $cart->location->name : '--' }}
                                </span>
                            </div>
                        @endif

                        @if($discount > 0)
                            <div class="flex justify-between items-center text-emerald-600 font-medium bg-emerald-50/40 p-2.5 rounded-xl border border-emerald-200/50">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-gift text-[10px]"></i>
                                    Reward Discount
                                </span>
                                <span>-₦{{ number_format($discount) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-baseline pt-4 border-t border-[var(--outline-variant)]/30 mt-2">
                            <span class="text-sm font-medium text-[var(--on-surface)]">Total Due</span>
                            <span class="text-2xl font-semibold text-[var(--on-surface)] tracking-tight">
                                ₦{{ number_format($total) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Flux input restyling — scoped to `.checkout-custom-inputs` and Flux's data attributes --}}
    <style>
        .checkout-custom-inputs input,
        .checkout-custom-inputs select,
        .checkout-custom-inputs textarea,
        [data-flux-input] input,
        [data-flux-select] select,
        [data-flux-textarea] textarea {
            outline: none !important;
            box-shadow: none !important;
            border: 1px solid var(--outline-variant) !important;
            background-color: var(--surface-low) !important;
            border-radius: 0.5rem !important;
            color: var(--on-surface) !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
        }

        .checkout-custom-inputs input:focus,
        .checkout-custom-inputs select:focus,
        .checkout-custom-inputs textarea:focus,
        [data-flux-input] input:focus,
        [data-flux-select] select:focus,
        [data-flux-textarea] textarea:focus {
            border-color: var(--on-surface) !important;
        }
    </style>
</div>
