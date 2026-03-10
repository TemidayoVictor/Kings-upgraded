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
                <div class="flex items-center">
                    <div class="flex items-center justify-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentStep >= 1 ? 'bg-white text-black' : 'bg-[#252528] text-gray-500' }}">
                            <span class="text-sm font-medium">1</span>
                        </div>
                        <span class="ml-3 text-sm {{ $currentStep >= 1 ? 'text-white' : 'text-gray-500' }}">Information</span>
                    </div>
                </div>

                <!-- Line -->
                <div class="flex-1 mx-4 h-px {{ $currentStep >= 2 ? 'bg-white' : 'bg-gray-700' }}"></div>

                <!-- Step 2 -->
                <div class="flex items-center">
                    <div class="flex items-center justify-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentStep >= 2 ? 'bg-white text-black' : 'bg-[#252528] text-gray-500' }}">
                            <span class="text-sm font-medium">2</span>
                        </div>
                        <span class="ml-3 text-sm {{ $currentStep >= 2 ? 'text-white' : 'text-gray-500' }}">Delivery</span>
                    </div>
                </div>

                <!-- Line -->
                <div class="flex-1 mx-4 h-px {{ $currentStep >= 3 ? 'bg-white' : 'bg-gray-700' }}"></div>

                <!-- Step 3 -->
                <div class="flex items-center">
                    <div class="flex items-center justify-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentStep >= 3 ? 'bg-white text-black' : 'bg-[#252528] text-gray-500' }}">
                            <span class="text-sm font-medium">3</span>
                        </div>
                        <span class="ml-3 text-sm {{ $currentStep >= 3 ? 'text-white' : 'text-gray-500' }}">Payment</span>
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
                                <div>
                                    <label class="block text-sm text-gray-400 mb-2">Full Name</label>
                                    <input
                                        type="text"
                                        wire:model="customer_name"
                                        class="w-full bg-[#1a1a1c] text-white rounded-xl border border-gray-700 focus:border-gray-500 focus:ring-0 px-4 py-3"
                                        placeholder="John Doe"
                                    >
                                    @error('customer_name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm text-gray-400 mb-2">Email Address</label>
                                    <input
                                        type="email"
                                        wire:model="customer_email"
                                        class="w-full bg-[#1a1a1c] text-white rounded-xl border border-gray-700 focus:border-gray-500 focus:ring-0 px-4 py-3"
                                        placeholder="john@example.com"
                                    >
                                    @error('customer_email') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="block text-sm text-gray-400 mb-2">Phone Number</label>
                                    <input
                                        type="tel"
                                        wire:model="customer_phone"
                                        class="w-full bg-[#1a1a1c] text-white rounded-xl border border-gray-700 focus:border-gray-500 focus:ring-0 px-4 py-3"
                                        placeholder="+234 800 000 0000"
                                    >
                                    @error('customer_phone') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
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

                                                <!-- Child Locations -->
                                                @if($location->children->count() > 0 && $delivery_location_id == $location->id)
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
                                <div>
                                    <label class="block text-sm text-gray-400 mb-2">Street Address</label>
                                    <input
                                        type="text"
                                        wire:model="delivery_address"
                                        class="w-full bg-[#1a1a1c] text-white rounded-xl border border-gray-700 focus:border-gray-500 focus:ring-0 px-4 py-3"
                                        placeholder="123 Main Street"
                                    >
                                    @error('delivery_address') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- City and State -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm text-gray-400 mb-2">City</label>
                                        <input
                                            type="text"
                                            wire:model="delivery_city"
                                            class="w-full bg-[#1a1a1c] text-white rounded-xl border border-gray-700 focus:border-gray-500 focus:ring-0 px-4 py-3"
                                            placeholder="Lagos"
                                        >
                                        @error('delivery_city') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-400 mb-2">State</label>
                                        <input
                                            type="text"
                                            wire:model="delivery_state"
                                            class="w-full bg-[#1a1a1c] text-white rounded-xl border border-gray-700 focus:border-gray-500 focus:ring-0 px-4 py-3"
                                            placeholder="Lagos State"
                                        >
                                        @error('delivery_state') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Zip Code -->
                                <div>
                                    <label class="block text-sm text-gray-400 mb-2">Zip/Postal Code (Optional)</label>
                                    <input
                                        type="text"
                                        wire:model="delivery_zip"
                                        class="w-full bg-[#1a1a1c] text-white rounded-xl border border-gray-700 focus:border-gray-500 focus:ring-0 px-4 py-3"
                                        placeholder="100001"
                                    >
                                </div>

                                <!-- Delivery Instructions -->
                                <div>
                                    <label class="block text-sm text-gray-400 mb-2">Delivery Instructions (Optional)</label>
                                    <textarea
                                        wire:model="delivery_instructions"
                                        rows="3"
                                        class="w-full bg-[#1a1a1c] text-white rounded-xl border border-gray-700 focus:border-gray-500 focus:ring-0 px-4 py-3"
                                        placeholder="Gate code, landmark, etc."
                                    ></textarea>
                                </div>
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
                                <div class="mt-6">
                                    <label class="block text-sm text-gray-400 mb-2">Order Notes (Optional)</label>
                                    <textarea
                                        wire:model="customer_notes"
                                        rows="3"
                                        class="w-full bg-[#1a1a1c] text-white rounded-xl border border-gray-700 focus:border-gray-500 focus:ring-0 px-4 py-3"
                                        placeholder="Any special instructions for your order?"
                                    ></textarea>
                                </div>

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
                            <button
                                wire:click="previousStep"
                                class="px-6 py-3 bg-[#1a1a1c] text-gray-300 rounded-xl hover:bg-[#2a2a2d] transition-colors"
                            >
                                Back
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if($currentStep < 3)
                            <button
                                wire:click="nextStep"
                                class="px-6 py-3 bg-white text-black rounded-xl hover:bg-gray-200 transition-colors"
                            >
                                Continue
                            </button>
                        @else
                            <button
                                wire:click="placeOrder"
                                wire:loading.attr="disabled"
                                class="px-8 py-3 bg-white text-black rounded-xl hover:bg-gray-200 transition-colors flex items-center gap-2"
                            >
                                <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                                <span wire:loading wire:target="placeOrder">Processing...</span>
                                <svg wire:loading wire:target="placeOrder" class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
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
                                    @if($item->product && $item->product->cover_image)
                                        <img src="{{ $item->product->thumbnail }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
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
                            <span class="text-gray-400">Shipping</span>
                            <span class="text-white">₦{{ number_format($shipping) }}</span>
                        </div>
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
