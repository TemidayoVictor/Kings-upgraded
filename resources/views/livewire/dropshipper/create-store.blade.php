<section class="w-full">
    @include('partials.partnerships')

    <flux:heading class="sr-only">{{ __('Create Store') }}</flux:heading>

    <x-dropshippers.layout :heading="__('Create Store')" :subheading="__('Customize your store below')">
        <div class="flex justify-end mb-4">
            <flux:button href=" {{ route('dropshipper-browse-brands')  }} " size="sm" variant="primary">
                Browse Brands
            </flux:button>
        </div>

        <flux:separator/>

        <div class="min-h-screen">
            <div class="max-w-3xl mx-auto">
                <!-- Main Form Card -->
                <div class="mt-4 bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                    <!-- Brand Header -->
                    <div class="h-32 bg-gradient-to-r from-[#27272a] to-[#3d3d40] relative">
                        @if($brand->image)
                            <img src="{{ Storage::url($brand->image) }}"
                                 alt="{{ $brand->brand_name }}"
                                 class="w-full h-full object-cover opacity-30">
                        @endif
                        <div class="absolute inset-0 bg-black/40 flex items-center px-6">
                            <div class="flex items-center">
                                <div class="h-16 w-16 bg-[#27272a] rounded-xl overflow-hidden border-2 border-gray-600">
                                    @if($brand->image)
                                        <img src="{{ Storage::url($brand->image) }}"
                                             alt="{{ $brand->brand_name }}"
                                             class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-2xl font-bold text-gray-400">
                                            {{ substr($brand->brand_name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-xl font-bold text-white">{{ $brand->brand_name }}</h2>
                                    <p class="text-sm text-gray-400">{{ $brand->category }} • {{ $brand->products->count() ?? 0 }} products</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Content -->
                    <div class="p-6">
                        <form wire:submit.prevent="createStore" class="space-y-6">
                            <!-- Store Name -->
                            <div>
                                <flux:label class="mb-2">Store Name</flux:label>
                                <flux:input
                                    wire:model.live="storeName"
                                    placeholder="e.g., John's Nike Store"
                                    class="w-full"
                                    :class="$errors->has('storeName') ? 'border-red-500' : ''"
                                />
                                <div class="flex justify-between mt-1">
                                    <flux:error name="storeName" />
                                    <span class="text-xs text-gray-500">{{ strlen($storeName ?? '') }}/100</span>
                                </div>
                            </div>

                            <!-- Store URL / Slug -->
                            <div>
                                @if(strlen($storeSlug ?? '') > 0)
                                    <div class="mt-2 flex items-center space-x-2">
                                        @if($isCheckingSlug)
                                            <svg class="animate-spin h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-400">Checking availability...</span>
                                        @elseif($slugAvailable && !$errors->has('storeSlug'))
                                            <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-sm text-green-400">URL is available!</span>
                                        @elseif(!$slugAvailable)
                                            <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"></circle>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 8l8 8M16 8l-8 8"></path>
                                            </svg>
                                            <span class="text-sm text-red-500">URL is NOT available!</span>
                                        @endif
                                    </div>
                                @endif

                                <!-- URL preview -->
                                @if(strlen($storeSlug ?? '') > 0 && !$errors->has('storeSlug'))
                                    <div class="mt-2 text-xs text-gray-500">
                                        Full URL: <span class="text-blue-400">www.knkings.com/store/{{ $storeSlug }}</span>
                                    </div>
                                @endif

                                <flux:error name="storeSlug" class="mt-1" />
                            </div>

                            <!-- Tips Box -->
                            <div class="bg-[#27272a] rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    URL Tips
                                </h4>
                                <ul class="text-xs text-gray-400 space-y-1 ml-6 list-disc">
                                    <li>Use only lowercase letters, numbers, and hyphens</li>
                                    <li>Keep it short and memorable</li>
                                    <li>Avoid special characters and spaces</li>
                                    <li>Minimum 3 characters</li>
                                </ul>
                            </div>

                            <!-- Terms Agreement -->
                            <div class="flex items-start space-x-3">
                                <div class="flex items-center h-5">
                                    <flux:checkbox
                                        wire:model.live="agreedToTerms"
                                        id="terms"
                                        class="rounded border-gray-600"
                                    />
                                </div>
                                <div class="flex-1">
                                    <label for="terms" class="text-sm text-gray-300">
                                        I agree to the
                                        <a href="#" class="text-blue-400 hover:text-blue-300">Terms of Service</a>
                                        and
                                        <a href="#" class="text-blue-400 hover:text-blue-300">Dropshipping Agreement</a>
                                        , and confirm that I will comply with the brand's dropshipping guidelines.
                                    </label>
                                    <flux:error name="agreedToTerms" class="mt-1" />
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-600">
                                <flux:button
                                    type="button"
                                    variant="subtle"
                                    href="{{ route('dropshipper-applications') }}"
                                    size="sm"
                                >
                                    Cancel
                                </flux:button>

                                <flux:button
                                    type="submit"
                                    variant="primary"
                                    class="min-w-[120px]"
                                    size="sm"
                                >
                                    <flux:icon.loading wire:loading wire:target="createStore" />
                                    <span wire:loading.remove wire:target="createStore">Create Store</span>
                                    <span wire:loading wire:target="createStore">Creating...</span>
                                </flux:button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Information Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    <div class="bg-[#3d3d40] rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-600/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-white">Secure & Safe</h4>
                                <p class="text-xs text-gray-400">Your store data is protected</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#3d3d40] rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-600/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-white">Auto Sync</h4>
                                <p class="text-xs text-gray-400">Products sync automatically</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#3d3d40] rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-purple-600/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-white">Custom Pricing</h4>
                                <p class="text-xs text-gray-400">Set your own profit margins</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help Text -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        By creating a store, you agree to our
                        <a href="#" class="text-blue-400 hover:text-blue-300">Terms of Service</a>
                        and
                        <a href="#" class="text-blue-400 hover:text-blue-300">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>
    </x-dropshippers.layout>
</section>
