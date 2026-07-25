<section class="w-full space-y-6">
    @include('partials.business')

    <flux:heading class="sr-only">{{ __('Subscriptions') }}</flux:heading>

    <x-dropshippers.revenue :heading="__('Subscriptions')" :subheading="__('Track your subscriptions')">
        <!-- Current Subscription Status -->

            <div class="mb-6 p-4 bg-gray-50 dark:bg-[#3d3d40] border border-gray-200 dark:border-[#3d3d40] rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="p-1.5 bg-black dark:bg-white rounded-full">
                        <svg class="w-4 h-4 text-white dark:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-semibold text-black dark:text-white">
                                {{ __('Current Plan:') }}
                            </span>

                            <span class="font-bold text-black dark:text-white">
                                {{ $isMonthly ? __('Monthly Plan') : __('Commission Plan') }}
                            </span>

                            <span class="mx-2">•</span>

                            @if($isMonthly)
                                <span class="font-medium {{ $isActive ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $isActive ? __('Active') : __('Inactive') }}
                                </span>

                                <span class="mx-2">•</span>

                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('Expires:') }}
                                        {{ $dropshipper->exp_date
                                            ? $dropshipper->exp_date->format('d F, Y')
                                            : __('N/A') }}
                                </span>
                            @else
                                <span class="font-medium text-green-600 ">
                                    {{ __('Active') }}
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>


        <!-- Subscription Type Selection -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Commission-Based Subscription Card -->
            <div class="bg-white dark:bg-[#3d3d40] border-2 rounded-lg p-6 transition-all duration-200
                {{ $isCommission
                    ? 'border-black dark:border-white ring-2 ring-black dark:ring-white'
                    : 'border-gray-200 dark:border-[#3d3d40] hover:border-black dark:hover:border-white'
                }}"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-black dark:text-white">{{ __('Commission Based Subscription') }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Pay per successful sale') }}</p>
                    </div>
                    <div class="flex items-center">
                        @if($isCommission)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-black text-white dark:bg-white dark:text-black">
                                Active
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-4 flex items-baseline">
                    <span class="text-3xl font-bold text-black dark:text-white">{{number_format(generalSetting()->dropshipper_percent)}}%</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">{{ __('of profit per sale') }}</span>
                </div>

                @if(!$isCommission)
                    <flux:button
                        variant="primary"
                        size="sm"
                        class="mt-2 w-full"
                        wire:click="submit('{{ App\Enums\Status::COMMISSION }}')"
                    >
                        Select Plan
                    </flux:button>
                @endif
            </div>

            <!-- Monthly Subscription Card -->
            <div class="bg-white dark:bg-[#3d3d40] border-2 rounded-lg p-6 transition-all duration-200
                {{ $isMonthly
                    ? 'border-black dark:border-white ring-2 ring-black dark:ring-white'
                    : 'border-gray-200 dark:border-[#3d3d40] hover:border-black dark:hover:border-white'
                }}"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-black dark:text-white">{{ __('Monthly Subscription') }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Pay a fixed monthly fee') }}</p>
                    </div>
                    <div class="flex items-center">
                        @if($isMonthly)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-black text-white dark:bg-white dark:text-black">
                                Active
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-4 flex items-baseline">
                    <span class="text-3xl font-bold text-black dark:text-white">₦{{number_format(generalSetting()->dropshipper_fee)}}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">/{{ __('month') }}</span>
                </div>
                @if(!$isMonthly)
                    <flux:button
                        variant="primary"
                        size="sm"
                        class="mt-2 w-full"
                        wire:click="submit('{{ App\Enums\Status::MONTHLY }}')"
                    >
                        Select Plan
                    </flux:button>
                @endif
                @if($isMonthly)
                    <div class="mt-4 flex items-start gap-3 rounded-xl border border-amber-200/80 bg-gradient-to-br from-amber-50/80 to-amber-50/80 px-4 py-3 text-sm text-amber-900 shadow-sm backdrop-blur-sm dark:amber-blue-800/50 dark:from-amber-950/40 dark:to-amber-950/40 dark:text-amber-200">
                        <!-- Icon with subtle background -->
                        <div class="mt-0.5 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-amber-100/60 text-amber-300 shadow-inner dark:bg-amber-900/40 dark:amber-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 19l-7-7h4V5h6v7h4l-7 7z" />
                            </svg>
                        </div>

                        <!-- Message with improved typography -->
                        <div class="flex-1 space-y-0.5">
                            <p class="font-medium leading-relaxed text-amber-900 dark:text-amber-100">
                                {{ __('Almost done!') }}
                            </p>
                            <p class="leading-relaxed text-amber-700/90 dark:text-amber-300/90">
                                {{ __('Scroll down to choose your subscription duration and complete your payment.') }}
                            </p>
                        </div>

                        <!-- Optional: subtle pulse animation to draw attention -->
                        <div class="hidden sm:block">
                            <span class="inline-flex h-2 w-2 animate-pulse rounded-full bg-amber-400 dark:bg-amber-500"></span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($isMonthly)
            <div class="mb-6 p-4 bg-gray-50 dark:bg-[#3d3d40] border border-gray-200 dark:border-[#3d3d40] rounded-lg">
                <div class="flex justify-between">
                    <h3 class="text-lg font-bold text-black dark:text-white mb-2">{{ $dropshipper->exp_date ? __('Renew Subscription') : __('Subscribe') }}</h3>
                </div>

                <div class="p-2 mb-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-white">
                            {{ __('Amount to Pay') }}
                        </span>
                        <span class="text-[1rem] font-bold tracking-tight text-white">
                            ₦{{ number_format($total) }}
                        </span>
                    </div>
                </div>

                <flux:select wire:model.live="duration">
                    <option value="">Select Duration</option>
                    <option value="1">1 Month</option>
                    <option value="3">3 Months</option>
                    <option value="6">6 Months</option>
                </flux:select>
                <flux:button
                    variant="primary"
                    size="sm"
                    class="mt-3 w-full"
                    wire:click="renewSubscription"
                >
                    Subscribe
                </flux:button>
            </div>
        @endif
    </x-dropshippers.revenue>
</section>
