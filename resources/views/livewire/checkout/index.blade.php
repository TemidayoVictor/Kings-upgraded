{{-- resources/views/livewire/checkout/index.blade.php --}}
<div class="min-h-screen bg-[#f7f6f2] py-16 sm:py-24 text-neutral-800 antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Premium Minimalist Header Block -->
        <div class="border-b border-neutral-300/70 pb-8 mb-12">
            <span class="text-[10px] font-bold uppercase tracking-[3px] text-neutral-400 block mb-2">Secure Order Processing</span>
            <h1 class="text-3xl sm:text-5xl font-light tracking-tight text-neutral-900 font-serif">Checkout</h1>
        </div>

        <!-- Elegant Streamlined Progress Steps -->
        <div class="mb-16 max-w-3xl mx-auto">
            <div class="flex items-center w-full relative">

                <!-- Step 1 Info Segment -->
                <div class="flex items-center relative z-10 bg-[#f7f6f2] pr-4">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full text-xs font-semibold tracking-wider transition-all duration-500 border
                        {{ $currentStep >= 1 ? 'bg-neutral-900 border-neutral-900 text-white shadow-md' : 'bg-white border-neutral-300 text-neutral-400' }}">
                        1
                    </div>
                    <span class="ml-3 text-xs font-medium uppercase tracking-widest hidden sm:inline
                        {{ $currentStep >= 1 ? 'text-neutral-900' : 'text-neutral-400' }}">
                        Information
                    </span>
                </div>

                <!-- Connecting Line 1 to 2 -->
                <div class="flex-1 h-[2px] transition-colors duration-500 -mx-1
                    {{ $currentStep >= 2 ? 'bg-neutral-900' : 'bg-neutral-300' }}">
                </div>

                <!-- Step 2 Delivery Segment -->
                <div class="flex items-center relative z-10 bg-[#f7f6f2] px-4">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full text-xs font-semibold tracking-wider transition-all duration-500 border
                        {{ $currentStep >= 2 ? 'bg-neutral-900 border-neutral-900 text-white shadow-md' : 'bg-white border-neutral-300 text-neutral-400' }}">
                        2
                    </div>
                    <span class="ml-3 text-xs font-medium uppercase tracking-widest hidden sm:inline
                        {{ $currentStep >= 2 ? 'text-neutral-900' : 'text-neutral-400' }}">
                        Delivery
                    </span>
                </div>

                <!-- Connecting Line 2 to 3 -->
                <div class="flex-1 h-[2px] transition-colors duration-500 -mx-1
                    {{ $currentStep >= 3 ? 'bg-neutral-900' : 'bg-neutral-300' }}">
                </div>

                <!-- Step 3 Payment Segment -->
                <div class="flex items-center relative z-10 bg-[#f7f6f2] pl-4">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full text-xs font-semibold tracking-wider transition-all duration-500 border
                        {{ $currentStep >= 3 ? 'bg-neutral-900 border-neutral-900 text-white shadow-md' : 'bg-white border-neutral-300 text-neutral-400' }}">
                        3
                    </div>
                    <span class="ml-3 text-xs font-medium uppercase tracking-widest hidden sm:inline
                        {{ $currentStep >= 3 ? 'text-neutral-900' : 'text-neutral-400' }}">
                        Payment
                    </span>
                </div>

            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

            <!-- Core Form Flow Window -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[24px] p-6 sm:p-10 border border-neutral-200/60 shadow-xs">

                    @if($currentStep === 1)
                        <!-- Step 1: Customer Information -->
                        <div class="space-y-6 animate-fade-in">
                            <div>
                                <h2 class="text-xl font-medium text-neutral-900 tracking-tight font-serif">
                                    Customer Information
                                </h2>

                                <p class="text-xs text-neutral-400 font-light mt-1">
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

                    @if($currentStep === 2)
                        <!-- Step 2: Delivery Information -->
                        <div class="space-y-6 animate-fade-in">
                            <div>
                                <h2 class="text-xl font-medium text-neutral-900 tracking-tight font-serif">Delivery Framework</h2>
                                <p class="text-xs text-neutral-400 font-light mt-1">Select location matrix maps to establish exact premium routing weights</p>
                            </div>

                            <div class="space-y-5 pt-2 checkout-custom-inputs">
                                <!-- Delivery Location Selection -->
                                <div>
                                    <label class="block text-xs font-medium text-neutral-500 uppercase tracking-wider mb-3">Select Delivery Region</label>
                                    <div class="space-y-3">
                                        @foreach($delivery_locations as $location)
                                            <div class="border rounded-2xl overflow-hidden transition-all duration-300 bg-neutral-50/30 {{ $delivery_location_id == $location->id || $this->isParentOfSelectedChild($location->id) ? 'border-neutral-900 ring-1 ring-neutral-900/5 shadow-xs' : 'border-neutral-200' }}">

                                                <!-- Parent Location Container -->
                                                <div class="flex items-center p-4.5 hover:bg-neutral-50 transition-colors">
                                                    <input
                                                        type="radio"
                                                        name="delivery_location"
                                                        value="{{ $location->id }}"
                                                        wire:click="selectDeliveryLocation({{ $location->id }})"
                                                        id="loc-{{ $location->id }}"
                                                        class="w-4 h-4 text-neutral-900 bg-white border-neutral-300 focus:ring-0 outline-none focus:ring-offset-0"
                                                        {{ $delivery_location_id == $location->id ? 'checked' : '' }}
                                                    >
                                                    <label for="loc-{{ $location->id }}" class="ml-3.5 flex-1 flex items-center justify-between cursor-pointer select-none">
                                                        <span class="text-sm font-medium text-neutral-800">{{ $location->name }}</span>
                                                        <span class="text-sm font-semibold text-neutral-900">₦{{ number_format($location->delivery_price) }}</span>
                                                    </label>
                                                </div>

                                                <!-- Child Locations Dropdown Stack -->
                                                @if($location->children->count() > 0 && ($delivery_location_id == $location->id || $this->isParentOfSelectedChild($location->id)))
                                                    <div class="pl-11 pr-5 pb-4 space-y-2 bg-white border-t border-neutral-200/60 pt-3 animate-fade-in">
                                                        @foreach($location->children as $child)
                                                            <div class="flex items-center py-2 px-3 rounded-xl hover:bg-neutral-50/50 transition-colors">
                                                                <input
                                                                    type="radio"
                                                                    name="delivery_location"
                                                                    value="{{ $child->id }}"
                                                                    wire:click="selectDeliveryLocation({{ $child->id }})"
                                                                    id="loc-{{ $child->id }}"
                                                                    class="w-3.5 h-3.5 text-neutral-900 bg-white border-neutral-300 focus:ring-0 outline-none focus:ring-offset-0"
                                                                    {{ $delivery_location_id == $child->id ? 'checked' : '' }}
                                                                >
                                                                <label for="loc-{{ $child->id }}" class="ml-3 flex-1 flex items-center justify-between cursor-pointer select-none">
                                                                    <span class="text-xs text-neutral-600 font-light">{{ $child->name }}</span>
                                                                    <span class="text-xs font-medium text-neutral-700">
                                                                        @if($child->delivery_price)
                                                                            ₦{{ number_format($child->delivery_price) }}
                                                                        @else
                                                                            <span class="text-[10px] text-neutral-400 font-light">(Inherits ₦{{ number_format($child->effective_price) }})</span>
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
                                    <p class="text-rose-600 text-[11px] mt-2 font-medium flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation text-[9px]"></i> {{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address Elements Grid -->
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

                    @if($currentStep === 3)
                        <!-- Step 3: Payment -->
                        <div class="space-y-6 animate-fade-in">
                            <div>
                                <h2 class="text-xl font-medium text-neutral-900 tracking-tight font-serif">Payment Modality</h2>
                                <p class="text-xs text-neutral-400 font-light mt-1">Select your preferred transactional exchange interface</p>
                            </div>

                            <div class="space-y-4 pt-2 checkout-custom-inputs">
                                <!-- Payment Radio Selection Array Stack Grid -->
                                <div class="grid grid-cols-1 gap-3">

                                    <!-- Card option element -->
                                    <label class="flex items-center p-4.5 border rounded-2xl cursor-pointer transition-all duration-300 hover:bg-neutral-50/40 {{ $payment_method === 'card' ? 'border-neutral-900 bg-neutral-50/20 ring-1 ring-neutral-900/5 shadow-xs' : 'border-neutral-200' }}">
                                        <input
                                            type="radio"
                                            wire:model="payment_method"
                                            value="card"
                                            class="w-4 h-4 text-neutral-900 bg-white border-neutral-300 focus:ring-0 outline-none focus:ring-offset-0"
                                        >
                                        <span class="ml-4 flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-white border border-neutral-200 flex items-center justify-center text-neutral-500">
                                                <i class="fa-regular fa-credit-card text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-neutral-800">Credit / Debit Card gateway</span>
                                        </span>
                                    </label>

                                    <!-- Bank transfer option element -->
                                    <label class="flex items-center p-4.5 border rounded-2xl cursor-pointer transition-all duration-300 hover:bg-neutral-50/40 {{ $payment_method === 'bank_transfer' ? 'border-neutral-900 bg-neutral-50/20 ring-1 ring-neutral-900/5 shadow-xs' : 'border-neutral-200' }}">
                                        <input
                                            type="radio"
                                            wire:model="payment_method"
                                            value="bank_transfer"
                                            class="w-4 h-4 text-neutral-900 bg-white border-neutral-300 focus:ring-0 outline-none focus:ring-offset-0"
                                        >
                                        <span class="ml-4 flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-white border border-neutral-200 flex items-center justify-center text-neutral-500">
                                                <i class="fa-solid fa-building-columns text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-neutral-800">Direct Wire Bank Transfer</span>
                                        </span>
                                    </label>

                                    <!-- Cash on delivery option element -->
                                    <label class="flex items-center p-4.5 border rounded-2xl cursor-pointer transition-all duration-300 hover:bg-neutral-50/40 {{ $payment_method === 'cash_on_delivery' ? 'border-neutral-900 bg-neutral-50/20 ring-1 ring-neutral-900/5 shadow-xs' : 'border-neutral-200' }}">
                                        <input
                                            type="radio"
                                            wire:model="payment_method"
                                            value="cash_on_delivery"
                                            class="w-4 h-4 text-neutral-900 bg-white border-neutral-300 focus:ring-0 outline-none focus:ring-offset-0"
                                        >
                                        <span class="ml-4 flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-white border border-neutral-200 flex items-center justify-center text-neutral-500">
                                                <i class="fa-solid fa-hand-holding-dollar text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-neutral-800">Cash on Delivery metrics</span>
                                        </span>
                                    </label>
                                </div>

                                <!-- Customer Notes -->
                                <div class="pt-2">
                                    <flux:textarea label="Order Notes (Optional)" wire:model="customer_notes" placeholder="Any special instructions regarding logistics execution frameworks?" class="w-full text-xs" />
                                </div>

                                <!-- Terms and Conditions Agreement Layer -->
                                <div class="mt-6 bg-neutral-50/70 rounded-2xl p-4.5 border border-neutral-200/80">
                                    <label class="flex items-start cursor-pointer select-none">
                                        <input
                                            type="checkbox"
                                            wire:model="termsAccepted"
                                            id="termsAccepted"
                                            class="w-4 h-4 mt-0.5 rounded border-neutral-300 text-neutral-900 focus:ring-0 outline-none bg-white"
                                        >
                                        <span class="ml-3 text-xs text-neutral-500 font-light leading-relaxed">
                                            I verify that all recorded data metrics matches identity properties and fully agree to the corporate <a href="#" class="text-neutral-900 font-medium hover:underline underline-offset-4">Terms and Conditions</a> policy architecture.
                                        </span>
                                    </label>
                                    @error('termsAccepted')
                                    <p class="text-rose-600 text-[11px] mt-2 font-medium flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation text-[9px]"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Step Processing Navigation Controls Section -->
                    <div class="flex items-center justify-between mt-10 pt-6 border-t border-neutral-200/70">
                        @if($currentStep > 1)
                            <button
                                type="button"
                                wire:click="previousStep"
                                wire:key="back-btn"
                                class="inline-flex items-center gap-2 border border-neutral-300 hover:border-neutral-800 text-neutral-600 hover:text-neutral-900 text-xs font-semibold px-6 py-3 rounded-xl transition-all active:scale-98"
                            >
                                <i wire:loading wire:target="previousStep" class="fa-solid fa-spinner animate-spin text-[10px]"></i>
                                <span wire:loading.remove wire:target="previousStep"><i class="fa-solid fa-chevron-left text-[9px] mr-1"></i> Back</span>
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if($currentStep < 3)
                            <button
                                type="button"
                                wire:click="nextStep"
                                wire:key="continue-btn-{{$currentStep}}"
                                class="inline-flex items-center gap-2 bg-neutral-950 hover:bg-[var(--primary)] text-white text-xs font-semibold px-6 py-3.5 rounded-xl transition-all shadow-md active:scale-98"
                            >
                                <i wire:loading wire:target="nextStep" class="fa-solid fa-spinner animate-spin text-[10px]"></i>
                                <span wire:loading.remove wire:target="nextStep">Continue <i class="fa-solid fa-chevron-right text-[9px] ml-1"></i></span>
                            </button>
                        @else
                            <button
                                type="button"
                                wire:click="placeOrder"
                                wire:key="place-order-btn"
                                class="inline-flex items-center gap-2 bg-neutral-950 hover:bg-[var(--primary)] text-white text-xs font-semibold tracking-widest uppercase px-8 py-4 rounded-xl transition-all shadow-lg active:scale-98"
                            >
                                <i wire:loading wire:target="placeOrder" class="fa-solid fa-spinner animate-spin text-[11px]"></i>
                                <span wire:loading.remove wire:target="placeOrder">{{ __('Place Order') }}</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Immutable Order Summary Sidebar Right Side Column Panel -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-[28px] p-6 sm:p-8 border border-neutral-200/60 shadow-xl shadow-neutral-200/20 sticky top-28 space-y-6">
                    <h2 class="text-lg font-medium text-neutral-900 tracking-tight font-serif">Order Summary</h2>

                    <!-- Items List Container (Unfiltered True Product Color Images) -->
                    <div class="space-y-4 mb-2 max-h-64 overflow-y-auto pr-1 divide-y divide-neutral-100">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-4 pt-4 {{ $loop->first ? 'pt-0 border-none' : '' }}">
                                <div class="w-12 h-14 bg-neutral-50 rounded-xl overflow-hidden shrink-0 border border-neutral-200/60 p-1 flex items-center justify-center">
                                    @if($item->product && $item->product->images->count() > 0)
                                        <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                    @else
                                        <span class="text-neutral-400 text-[10px] font-bold uppercase">{{ substr($item->product_name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0 space-y-0.5">
                                    <p class="text-xs font-medium text-neutral-800 truncate">{{ $item->product_name }}</p>
                                    <p class="text-[11px] text-neutral-400 font-light">Quantity: <span class="text-neutral-700 font-medium">{{ $item->quantity }}</span></p>
                                </div>
                                <span class="text-xs font-semibold text-neutral-900 shrink-0">₦{{ number_format($item->total) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Invoice totals breakdown details matrix container -->
                    <div class="space-y-3.5 pt-5 border-t border-neutral-200 text-xs text-neutral-500 font-light">
                        <div class="flex justify-between items-center">
                            <span>Subtotal</span>
                            <span class="text-neutral-900 font-medium">₦{{ number_format($subtotal) }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span>VAT (7.5%)</span>
                            <span class="text-neutral-900 font-medium">₦{{ number_format($tax) }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span>Shipping Fee</span>
                            <span class="text-neutral-900 font-medium">₦{{ number_format($shipping) }}</span>
                        </div>

                        @if($delivery_location_id)
                            <div class="flex justify-between items-start bg-neutral-50/70 p-3 rounded-xl border border-neutral-200/80 text-[11px]">
                                <span class="text-neutral-400">Delivery Location</span>
                                <span class="text-neutral-800 font-medium text-right max-w-[140px] truncate">{{ $cart->location ? $cart->location->name : '--' }}</span>
                            </div>
                        @endif

                        @if($discount > 0)
                            <div class="flex justify-between items-center text-emerald-600 font-medium bg-emerald-50/40 p-2.5 rounded-xl border border-emerald-200/50">
                                <span>Reward Discount</span>
                                <span>-₦{{ number_format($discount) }}</span>
                            </div>
                        @endif

                        <!-- absolute value sum summary layer section -->
                        <div class="flex justify-between items-baseline pt-4 border-t border-neutral-200 mt-2">
                            <span class="text-sm font-medium text-neutral-900">Total Due</span>
                            <span class="text-2xl font-semibold text-neutral-900 tracking-tight">₦{{ number_format($total) }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Global layout override style patches targeting standard and Flux input component containers --}}
    <style>
        .checkout-custom-inputs input,
        .checkout-custom-inputs select,
        .checkout-custom-inputs textarea,
        [data-flux-input] input,
        [data-flux-select] select,
        [data-flux-textarea] textarea {
            outline: none !important;
            box-shadow: none !important;
            border: 1px solid #c4c2bc !important; /* Noticeable clean custom border gray */
            background-color: #faf9f6 !important;
            border-radius: .5rem !important;
            color: black;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
        }

        .checkout-custom-inputs input:focus,
        .checkout-custom-inputs select:focus,
        .checkout-custom-inputs textarea:focus,
        [data-flux-input] input:focus,
        [data-flux-select] select:focus,
        [data-flux-textarea] textarea:focus {
            border-color: #171717 !important; /* Striking modern high contrast border on focus */
        }
    </style>
</div>
