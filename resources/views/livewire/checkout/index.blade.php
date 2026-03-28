{{-- resources/views/livewire/checkout/index.blade.php --}}
<div class="min-h-screen bg-[#1a1a1c] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-light text-white mb-2">Checkout</h1>
            <p class="text-gray-400">Complete your purchase</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-between max-w-2xl mx-auto">
                <!-- Step 1 -->
                <div class="w-full">
                    <div class="flex items-center justify-between">

                        {{-- Step 1 --}}
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full
                                {{ $currentStep >= 1 ? 'bg-white text-black' : 'bg-gray-700 text-gray-400' }}">
                                1
                            </div>
                            <span class="ml-2 text-sm hidden sm:inline
                                {{ $currentStep >= 1 ? 'text-white' : 'text-gray-400' }}">
                                Information
                            </span>
                        </div>

                        {{-- Line --}}
                        <div class="flex-1 h-px mx-2
                            {{ $currentStep >= 2 ? 'bg-white' : 'bg-gray-700' }}">
                        </div>

                        {{-- Step 2 --}}
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full
                                {{ $currentStep >= 2 ? 'bg-white text-black' : 'bg-gray-700 text-gray-400' }}">
                                2
                            </div>
                            <span class="ml-2 text-sm hidden sm:inline
                                {{ $currentStep >= 2 ? 'text-white' : 'text-gray-400' }}">
                                Delivery
                            </span>
                        </div>

                        {{-- Line --}}
                        <div class="flex-1 h-px mx-2
                            {{ $currentStep >= 3 ? 'bg-white' : 'bg-gray-700' }}">
                        </div>

                        {{-- Step 3 --}}
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full
                                {{ $currentStep >= 3 ? 'bg-white text-black' : 'bg-gray-700 text-gray-400' }}">
                                3
                            </div>
                            <span class="ml-2 text-sm hidden sm:inline
                                {{ $currentStep >= 3 ? 'text-white' : 'text-gray-400' }}">
                                Payment
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Checkout Form -->
            <div class="flex-1">
                <div class="bg-[#252528] rounded-2xl p-6 lg:p-8">
                    @if($currentStep === 1)
                        <!-- Step 1: Customer Information -->
                        <div>
                            <h2 class="text-xl font-light text-white mb-6">Customer Information</h2>

                            <div class="space-y-4">
                                <!-- Name -->
                                <flux:input label="Full Name" wire:model="customer_name" placeholder="Adekunle Haruna Ciroma" class="max-full" />
                                <!-- Email -->
                                <flux:input label="Email Address" wire:model="customer_email" type="email" placeholder="ade@example.com" class="max-full" />
                                <!-- Phone -->
                                <flux:input label="Phone Number" wire:model="customer_phone" placeholder="+234 800 000 0000" class="max-full" />

                            </div>
                        </div>
                    @endif

                    @if($currentStep === 2)
                        <!-- Step 2: Delivery Information -->
                        <div>
                            <h2 class="text-xl font-light text-white mb-6">Delivery Information</h2>

                            <div class="space-y-4">
                                <!-- Delivery Location Selection -->
                                <div>
                                    <label class="block text-sm text-gray-400 mb-2">Select Delivery Location</label>
                                    <div class="space-y-2">
                                        @foreach($delivery_locations as $location)
                                            <div class="border border-gray-700 rounded-xl overflow-hidden">
                                                <!-- Parent Location -->
                                                <div class="flex items-center p-4 bg-[#1a1a1c]">
                                                    <input
                                                        type="radio"
                                                        name="delivery_location"
                                                        value="{{ $location->id }}"
                                                        wire:click="selectDeliveryLocation({{ $location->id }})"
                                                        class="w-4 h-4 text-white bg-[#1a1a1c] border-gray-600 focus:ring-0"
                                                    >
                                                    <label class="ml-3 flex-1 flex items-center justify-between">
                                                        <span class="text-white">{{ $location->name }}</span>
                                                        <span class="text-gray-400">₦{{ number_format($location->delivery_price) }}</span>
                                                    </label>
                                                </div>

                                                <!-- Child Locations - Show if parent is selected OR if any child is selected -->
                                                @if($location->children->count() > 0 && ($delivery_location_id == $location->id || $this->isParentOfSelectedChild($location->id)))
                                                    <div class="pl-12 pr-4 pb-4 space-y-2 bg-[#1a1a1c] border-t border-gray-700">
                                                        @foreach($location->children as $child)
                                                            <div class="flex items-center py-2">
                                                                <input
                                                                    type="radio"
                                                                    name="delivery_location"
                                                                    value="{{ $child->id }}"
                                                                    wire:click="selectDeliveryLocation({{ $child->id }})"
                                                                    class="w-4 h-4 text-white bg-[#1a1a1c] border-gray-600 focus:ring-0"
                                                                >
                                                                <label class="ml-3 flex-1 flex items-center justify-between">
                                                                    <span class="text-gray-300">{{ $child->name }}</span>
                                                                    <span class="text-gray-400">
                                                                        @if($child->delivery_price)
                                                                            ₦{{ number_format($child->delivery_price) }}
                                                                        @else
                                                                            <span class="text-xs">(Inherits ₦{{ number_format($child->effective_price) }})</span>
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
                                    @error('delivery_location_id') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <!-- Address -->
                                <flux:input label="Street Address" wire:model="delivery_address" placeholder="123 Main Street" class="max-full" />

                                <!-- City and State -->
                                <div class="grid grid-cols-2 gap-4">
                                    <flux:select label="State" wire:model="delivery_state">
                                        <option>Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state }}">{{ $state }}</option>
                                        @endforeach
                                    </flux:select>
                                    <flux:input label="City" wire:model="delivery_city" placeholder="Ikeja" class="max-full" />
                                </div>

                                <!-- Zip Code -->
                                <flux:input label="Zip/Postal Code (Optional)" wire:model="delivery_zip" placeholder="100001" class="max-full" />

                                <!-- Delivery Instructions -->
                                <flux:textarea label="Delivery Instructions (Optional)" wire:model="delivery_instructions" placeholder="Gate code, landmark, etc." class="max-full" />
                            </div>
                        </div>
                    @endif

                    @if($currentStep === 3)
                        <!-- Step 3: Payment -->
                        <div>
                            <h2 class="text-xl font-light text-white mb-6">Payment Method</h2>

                            <div class="space-y-4">
                                <!-- Payment Methods -->
                                <div class="space-y-3">
                                    <label class="flex items-center p-4 border border-gray-700 rounded-xl cursor-pointer hover:bg-[#1a1a1c] transition-colors">
                                        <input
                                            type="radio"
                                            wire:model="payment_method"
                                            value="card"
                                            class="w-4 h-4 text-white bg-[#1a1a1c] border-gray-600 focus:ring-0"
                                        >
                                        <span class="ml-3 flex items-center gap-2">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            <span class="text-white">Credit/Debit Card</span>
                                        </span>
                                    </label>

                                    <label class="flex items-center p-4 border border-gray-700 rounded-xl cursor-pointer hover:bg-[#1a1a1c] transition-colors">
                                        <input
                                            type="radio"
                                            wire:model="payment_method"
                                            value="bank_transfer"
                                            class="w-4 h-4 text-white bg-[#1a1a1c] border-gray-600 focus:ring-0"
                                        >
                                        <span class="ml-3 flex items-center gap-2">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                            </svg>
                                            <span class="text-white">Bank Transfer</span>
                                        </span>
                                    </label>

                                    <label class="flex items-center p-4 border border-gray-700 rounded-xl cursor-pointer hover:bg-[#1a1a1c] transition-colors">
                                        <input
                                            type="radio"
                                            wire:model="payment_method"
                                            value="cash_on_delivery"
                                            class="w-4 h-4 text-white bg-[#1a1a1c] border-gray-600 focus:ring-0"
                                        >
                                        <span class="ml-3 flex items-center gap-2">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span class="text-white">Cash on Delivery</span>
                                        </span>
                                    </label>
                                </div>

                                <!-- Customer Notes -->
                                <flux:textarea label="Order Notes (Optional)" wire:model="customer_notes" placeholder="Any special instructions for your order?" class="max-full" />

                                <!-- Terms and Conditions -->
                                <div class="mt-6">
                                    <label class="flex items-center">
                                        <input
                                            type="checkbox"
                                            wire:model="termsAccepted"
                                            class="w-4 h-4 rounded bg-[#1a1a1c] border-gray-600 text-white focus:ring-0"
                                        >
                                        <span class="ml-2 text-sm text-gray-400">
                                            I agree to the <a href="#" class="text-white hover:underline">Terms and Conditions</a>
                                        </span>
                                    </label>
                                    @error('termsAccepted') <span class="text-red-400 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-700">
                        @if($currentStep > 1)
                            <flux:button type="submit" variant="subtle" size="sm" wire:click="previousStep" wire:key="back-btn">
                                <flux:icon.loading wire:loading wire:target="previousStep" />
                                <span wire:loading.remove wire:target="previousStep">Back</span>
                            </flux:button>
                        @else
                            <div></div>
                        @endif

                        @if($currentStep < 3)
                            <flux:button type="submit" variant="primary" size="sm" wire:click="nextStep" wire:key="{{$currentStep}}">
                                <flux:icon.loading wire:loading wire:target="nextStep" />
                                <span wire:loading.remove wire:target="nextStep">Continue</span>
                            </flux:button>
                        @else
                            <flux:button type="submit" variant="primary" size="sm" wire:click="placeOrder" wire:key="place-order">
                                <flux:icon.loading wire:loading wire:target="placeOrder" />
                                <span wire:loading.remove wire:target="placeOrder">{{ __('Place Order') }}</span>
                            </flux:button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:w-96">
                <div class="bg-[#252528] rounded-2xl p-6 sticky top-24">
                    <h2 class="text-xl font-light text-white mb-6">Order Summary</h2>

                    <!-- Items -->
                    <div class="space-y-3 mb-6 max-h-60 overflow-y-auto">
                        @foreach($cartItems as $item)
                            <div class="flex items-start gap-3">
                                <div class="w-12 h-12 bg-[#1a1a1c] rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->product && $item->product->images->count() > 0)
                                        <img src="{{ $item->product->primary_image_url }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-20 h-20 object-cover rounded-lg">
                                    @else
                                        <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                            <span class="text-gray-300 font-medium">{{ substr($item->product->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-white">{{ $item->product_name }}</p>
                                    <p class="text-xs text-gray-400">Qty: {{ $item->quantity }}</p>
                                </div>
                                <span class="text-sm text-white">₦{{ number_format($item->total) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="space-y-3 pt-4 border-t border-gray-700">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Subtotal</span>
                            <span class="text-white">₦{{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Tax (7.5%)</span>
                            <span class="text-white">₦{{ number_format($tax) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Shipping cost</span>
                            <span class="text-white">₦{{ number_format($shipping) }}</span>
                        </div>
                        @if($delivery_location_id)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Shipping location</span>
                                <span class="text-white">{{ $cart->location ? $cart->location->name : '--' }}</span>
                            </div>
                        @endif
                        @if($discount > 0)
                            <div class="flex justify-between text-sm text-green-400">
                                <span>Discount</span>
                                <span>-₦{{ number_format($discount) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between pt-3 border-t border-gray-700">
                            <span class="text-base font-medium text-white">Total</span>
                            <span class="text-xl font-light text-white">₦{{ number_format($total) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
