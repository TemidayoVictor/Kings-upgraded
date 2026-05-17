<section class="w-full">
    @include('partials.add-brand-heading')

    <flux:heading class="sr-only">{{ __('Pricing Plans') }}</flux:heading>

    <div class="sm:px-6 lg:px-8">
        <div class="mx-auto">

            <!-- Header Section -->
            <div class="text-center mb-12">
                <flux:heading size="xl" class="mb-4">Simple, Transparent Pricing</flux:heading>
                <flux:subheading class="text-gray-600 dark:text-gray-400">
                    Choose the perfect plan for your business needs
                </flux:subheading>
            </div>

            <!-- Pricing Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">

                <!-- Basic Plan -->
                <div class="relative bg-white dark:bg-[#18181B] rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border">
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <div class="inline-block px-4 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-semibold mb-4">
                                Basic
                            </div>
                            <div class="mb-3">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">₦{{number_format(generalSetting()->basic_fee)}}</span>
                                <span class="text-gray-500 dark:text-gray-400">/month</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                Perfect for small businesses getting started
                            </p>
                        </div>

                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Comprehensive Brand Profile</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Up to {{number_format(generalSetting()->basic_products_number)}} products/services</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Fully Functional Storefront</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Direct WhatsApp messaging</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Contract Bidding</span>
                            </div>
                        </div>

                        <flux:button size="sm" variant="primary" wire:click="addBrand('{{App\Enums\Status::BASIC}}')" wire:key="basic" class="w-full">
                            Get Started Free
                        </flux:button>
                    </div>
                </div>

                <!-- Premium Plan (Most Popular) -->
                <div class="relative rounded-2xl shadow-xl transform sm:scale-105 border-2">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-1.5 rounded-full text-sm font-semibold shadow-lg">
                            Most Popular
                        </div>
                    </div>

                    <div class="p-6 pt-8">
                        <div class="text-center mb-6">
                            <div class="inline-block px-4 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-sm font-semibold mb-4">
                                Premium
                            </div>
                            <div class="mb-3">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">₦{{number_format(generalSetting()->premium_fee)}}</span>
                                <span class="text-gray-500 dark:text-gray-400">/month</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                Everything in Basic, plus advanced features
                            </p>
                        </div>

                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>✓ Everything in Basic</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Up to {{number_format(generalSetting()->premium_products_number)}} products/services</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Social Media & Web Links</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>More Enhanced Storefront</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Contract Bidding & Direct Messaging</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Client Reviews</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Boosted Visibility</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Sales Mode</span>
                            </div>
                        </div>

                        <flux:button size="sm" variant="primary" wire:click="addBrand('{{App\Enums\Status::PREMIUM}}')" wire:key="premium" class="w-full   ">
                            Get Started
                        </flux:button>
                    </div>
                </div>

                <!-- Platinum Plan -->
                <div class="relative bg-white dark:bg-[#18181B] rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border">
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <div class="inline-block px-4 py-1 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 text-sm font-semibold mb-4">
                                Platinum
                            </div>
                            <div class="mb-3">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">₦{{number_format(generalSetting()->platinum_fee)}}</span>
                                <span class="text-gray-500 dark:text-gray-400">/month</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                Everything in Premium, plus advanced features
                            </p>
                        </div>

                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>✓ Everything in Premium</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Up to {{number_format(generalSetting()->platinum_products_number)}} products/services</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Sales Boost with Dropshippers</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Boosted Visibility (Priority)</span>
                            </div>
                        </div>

                        <flux:button size="sm" variant="primary" wire:click="addBrand('{{App\Enums\Status::PLATINUM}}')" wire:key="platinum" class="w-full   ">
                            Get Started
                        </flux:button>
                    </div>
                </div>
            </div>

            <!-- Comparison Table Section -->
            <div class="mb-20">
                <div class="text-center mb-8">
                    <flux:heading size="lg" class="mb-2">Compare All Features</flux:heading>
                    <flux:subheading>Find the perfect plan for your business needs</flux:subheading>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full bg-white dark:bg-[#18181B] rounded-2xl shadow-lg overflow-hidden">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Features</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">Basic</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-blue-600 dark:text-blue-400">Premium</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-purple-600 dark:text-purple-400">Platinum</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">Price per month</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600 dark:text-gray-400">₦{{number_format(generalSetting()->basic_fee)}}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600 dark:text-gray-400">₦{{number_format(generalSetting()->premium_fee)}}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600 dark:text-gray-400">₦{{number_format(generalSetting()->platinum_fee)}}</td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">Products/Services Limit</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600 dark:text-gray-400">Up to {{number_format(generalSetting()->basic_products_number)}}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600 dark:text-gray-400">Up to {{number_format(generalSetting()->premium_products_number)}}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600 dark:text-gray-400">Up to {{number_format(generalSetting()->platinum_products_number)}}</td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">Store Front</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">Direct WhatsApp messaging</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">Contract Bidding</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">Message Contract Clients</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-red-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">Social Media & Web Links</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-red-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">Client Reviews</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-red-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">Sales Mode</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-red-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 font-medium">Sales Boost with Dropshippers</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-red-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-red-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FAQ Section -->
            <div>
                <div class="text-center mb-8">
                    <flux:heading size="lg" class="mb-2">Frequently Asked Questions</flux:heading>
                    <flux:subheading>Everything you need to know about our plans</flux:subheading>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-[#18181B] rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Can I switch plans later?</h3>
                        <p class="text-gray-600 dark:text-gray-400">Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately.</p>
                    </div>

                    <div class="bg-white dark:bg-[#18181B] rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Is there a long-term contract?</h3>
                        <p class="text-gray-600 dark:text-gray-400">No, all plans are month-to-month. Cancel anytime with no hidden fees.</p>
                    </div>

                    <div class="bg-white dark:bg-[#18181B] rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Do you offer discounts for annual billing?</h3>
                        <p class="text-gray-600 dark:text-gray-400">Yes! Get 2 months free when you choose annual billing on Premium or Platinum plans.</p>
                    </div>

                    <div class="bg-white dark:bg-[#18181B] rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">What payment methods do you accept?</h3>
                        <p class="text-gray-600 dark:text-gray-400">We accept all major credit/debit cards and bank transfers.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
