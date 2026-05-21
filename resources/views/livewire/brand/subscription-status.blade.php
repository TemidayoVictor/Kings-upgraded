<section class="w-full">
    @include('partials.subscription-heading')

    <div class="">
        <div class="mx-auto space-y-10">

            <!-- Header -->
            <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-indigo-600 via-blue-600 to-slate-900 p-8 sm:p-10 shadow-2xl">
                <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-sm text-white mb-5">
                            <span>✨</span>
                            <span>Subscription Overview</span>
                        </div>

                        <flux:heading size="xl" class="text-white mb-3">
                            Manage Your Subscription
                        </flux:heading>

                        <flux:subheading class="text-blue-100 max-w-2xl">
                            View your current plan, monitor your usage, renew your subscription, or upgrade anytime to unlock more features.
                        </flux:subheading>
                    </div>
                </div>
            </div>

            <!-- Current Subscription Card -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                <!-- Left Main Card -->
                <div class="xl:col-span-2 bg-white dark:bg-[#18181B] rounded-2xl border border-gray-200 dark:border-white/10 shadow-xl overflow-hidden">

                    <div class="p-8 border-b border-gray-200 dark:border-white/10">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                            <div class="flex items-start sm:items-center gap-5">
                                <div class="hidden sm:flex h-10 w-10 sm:h-16 sm:w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>

                                <div>
                                    <div class="flex flex-col-reverse sm:flex-row items-start sm:items-center gap-3 mb-1">
                                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white capitalize">
                                            {{$brand->subscription_status}} Plan
                                        </h2>

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/10 text-green-500 border border-green-500/20">
                                            Active
                                        </span>
                                    </div>

                                    @if (!$brand->exp_date)
                                        <p class="text-red-500 dark:text-red-400">
                                            No active subscription
                                        </p>
                                    @elseif (\Carbon\Carbon::parse($brand->exp_date)->isPast())
                                        <p class="text-red-500 dark:text-red-400">
                                            Subscription expired on
                                            <span class="font-semibold">
                                                {{ \Carbon\Carbon::parse($brand->exp_date)->format('F d, Y') }}
                                            </span>
                                        </p>
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400">
                                            Your subscription renews on
                                            <span class="font-semibold text-gray-700 dark:text-gray-200">
                                                {{ \Carbon\Carbon::parse($brand->exp_date)->format('F d, Y') }}
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="text-left lg:text-right">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                    Monthly Subscription
                                </p>

                                <div class="flex items-end gap-1">
                                    <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                        ₦{{number_format($brand->subscription_amount)}}
                                    </span>
                                    <span class="text-gray-500 dark:text-gray-400 mb-1">
                                        /month
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Usage Stats -->
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                            <!-- Products -->
                            <div class="rounded-xl border border-gray-200 dark:border-white/10 p-5 bg-gray-50 dark:bg-[#232326]">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="h-11 w-11 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                        </svg>
                                    </div>

                                    <span class="text-xs px-2 py-1 rounded-full bg-blue-500/10 text-blue-500">
                                        {{number_format(($brand->products->count() / $brand->no_of_products) * 100, 0)}}%
                                    </span>
                                </div>

                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                                    {{$brand->products->count()}} / {{$brand->no_of_products}}
                                </h3>

                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    Products Used
                                </p>

                                <div class="w-full h-2 bg-gray-200 dark:bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full"
                                         style="width: {{ ($brand->products->count() / $brand->no_of_products) * 100 }}%">
                                    </div>
                                </div>
                            </div>

                            <!-- Store Views -->
                            <div class="rounded-xl border border-gray-200 dark:border-white/10 p-5 bg-gray-50 dark:bg-[#232326]">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="h-11 w-11 rounded-xl bg-purple-500/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-6 2H5a2 2 0 01-2-2V10a2 2 0 012-2h4m6 8V8a2 2 0 00-2-2H9"/>
                                        </svg>
                                    </div>

                                    <span class="text-xs px-2 py-1 rounded-full bg-purple-500/10 text-purple-500">
                                        +18%
                                    </span>
                                </div>

                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                                    12.4k
                                </h3>

                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Monthly Store Views
                                </p>
                            </div>

                            <!-- Days Left -->
                            <div class="rounded-xl border border-gray-200 dark:border-white/10 p-5 bg-gray-50 dark:bg-[#232326]">
                                @php
                                    $expiry = expiryDate($brand->exp_date);
                                    $daysRemaining = $expiry['daysRemaining'];
                                    $isExpired = $expiry['isExpired'];

                                    // Determine status and colors
                                    if ($isExpired) {
                                        $statusText = 'Expired';
                                        $statusColor = 'red';
                                        $daysDisplay = '0 Days';
                                        $iconColor = 'red';
                                    } elseif ($daysRemaining >= 10) {
                                        $statusText = 'Active';
                                        $statusColor = 'emerald';
                                        $daysDisplay = $daysRemaining . ' Days';
                                        $iconColor = 'emerald';
                                    } elseif ($daysRemaining >= 5) {
                                        $statusText = 'Warning';
                                        $statusColor = 'yellow';
                                        $daysDisplay = $daysRemaining . ' Days';
                                        $iconColor = 'yellow';
                                    } else {
                                        $statusText = 'Expiring Soon';
                                        $statusColor = 'red';
                                        $daysDisplay = $daysRemaining . ' Days';
                                        $iconColor = 'red';
                                    }
                                @endphp

                                <div class="flex items-center justify-between mb-4">
                                    <div class="h-11 w-11 rounded-xl bg-{{ $iconColor }}-500/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-{{ $iconColor }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                                        </svg>
                                    </div>

                                    <span class="text-xs px-2 py-1 rounded-full bg-{{ $statusColor }}-500/10 text-{{ $statusColor }}-500">
                                        {{ $statusText }}
                                    </span>
                                </div>

                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                                    {{ $daysDisplay }}
                                </h3>

                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $isExpired ? 'Subscription Expired' : 'Remaining' }}
                                </p>

                                @if(!$isExpired && $daysRemaining <= 5)
                                    <p class="text-xs text-{{ $statusColor }}-500 mt-2 font-medium">
                                        ⚠️ Subscription ends on {{ \Carbon\Carbon::parse($brand->exp_date)->format('M d, Y') }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-6">

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-[#18181B] rounded-2xl border border-gray-200 dark:border-white/10 shadow-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">
                            Quick Actions
                        </h3>

                        <div class="space-y-3">

                            <!-- Renew Subscription -->
                            @if($brand->subscription_status == \App\Enums\Status::BASIC || $brand->subscription_status == \App\Enums\Status::PREMIUM)
                                <button class="w-full flex items-center justify-between p-4 rounded-2xl border border-gray-200 dark:border-white/10 hover:border-purple-500/30 hover:bg-purple-500/5 transition-all" onclick="document.getElementById('plans-section').scrollIntoView({ behavior: 'smooth' })">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-purple-500/10 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 15l7-7 7 7"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 8v12"/>
                                            </svg>
                                        </div>

                                        <div class="text-left">
                                            <p class="font-medium text-gray-900 dark:text-white">
                                                Upgrade Plan
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Unlock more features
                                            </p>
                                        </div>
                                    </div>

                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            @elseif($brand->subscription_status == \App\Enums\Status::PREMIUM || $brand->subscription_status == \App\Enums\Status::PLATINUM)
                                <button class="w-full flex items-center justify-between p-4 rounded-2xl border border-gray-200 dark:border-white/10 hover:border-blue-500/30 hover:bg-blue-500/5 transition-all" wire:click="displayModal('renew')">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4 4v6h6M20 20v-6h-6"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M20 9A8 8 0 006.34 5.34L4 10m16 4l-2.34 4.66A8 8 0 0112 20"/>
                                            </svg>
                                        </div>

                                        <div class="text-left">
                                            <p class="font-medium text-gray-900 dark:text-white">
                                                Renew Subscription
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Extend your subscription
                                            </p>
                                        </div>
                                    </div>

                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            @endif
                            <!-- Buy More Products -->
                            <button class="w-full flex items-center justify-between p-4 rounded-2xl border border-gray-200 dark:border-white/10 hover:border-green-500/30 hover:bg-green-500/5 transition-all" wire:click="displayModal('increase')">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-green-500/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4"/>
                                            <circle cx="9" cy="19" r="1.5"/>
                                            <circle cx="17" cy="19" r="1.5"/>
                                        </svg>
                                    </div>

                                    <div class="text-left">
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            Buy More Product Slots
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Expand your product limit
                                        </p>
                                    </div>
                                </div>

                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Plans -->
            <div id="plans-section">
                <div class="text-center mb-10">
                    <flux:heading size="xl" class="mb-4">Upgrade or Change Your Plan</flux:heading>
                    <flux:subheading class="text-gray-600 dark:text-gray-400">
                        Choose a plan that fits your business goals
                    </flux:subheading>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Basic -->
                    <div class="rounded-3xl border bg-white dark:bg-[#18181B] p-7 shadow-lg hover:shadow-2xl transition-all duration-300 {{ $brand->subscription_status == 'basic' ? 'border-2 border-emerald-500 scale-[1.02] relative' : '' }}">
                        @if($brand->subscription_status == 'basic')
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                                <div class="px-5 py-1.5 rounded-full bg-gradient-to-r from-emerald-600 to-green-600 text-white text-sm font-semibold shadow-lg">
                                    Current Plan
                                </div>
                            </div>
                        @endif

                        <div class="mb-6 {{ $brand->subscription_status == 'basic' ? 'mt-2' : '' }}">
                            <span class="px-4 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-sm font-medium">
                                Basic
                            </span>
                        </div>

                        <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                            ₦{{number_format(planDetails(\App\Enums\Status::BASIC)['fee'])}}
                            <span class="text-base text-gray-500 font-normal">/month</span>
                        </h3>

                        <p class="text-gray-500 dark:text-gray-400 mb-6">
                            Perfect for businesses getting started.
                        </p>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>

                                <span>Up to {{number_format(planDetails(\App\Enums\Status::BASIC)['number'])}} Products</span>
                            </div>

                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>

                                <span>Functional Storefront</span>
                            </div>
                        </div>
                    </div>

                    <!-- Premium -->
                    <div class="rounded-3xl border bg-white dark:bg-[#18181B] p-7 shadow-lg hover:shadow-2xl transition-all duration-300 {{ $brand->subscription_status == 'premium' ? 'border-2 border-blue-500 scale-[1.02] relative' : '' }}">
                        @if($brand->subscription_status == 'premium')
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                                <div class="px-5 py-1.5 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold shadow-lg">
                                    Current Plan
                                </div>
                            </div>
                        @endif

                        <div class="mb-6 {{ $brand->subscription_status == 'premium' ? 'mt-2' : '' }}">
            <span class="px-4 py-1 rounded-full bg-blue-500/10 text-blue-500 text-sm font-medium">
                Premium
            </span>
                        </div>

                        <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                            ₦{{number_format(planDetails(\App\Enums\Status::PREMIUM)['fee'])}}
                            <span class="text-base text-gray-500 font-normal">/month</span>
                        </h3>

                        <p class="text-gray-500 dark:text-gray-400 mb-6">
                            Best for growing businesses and increased visibility.
                        </p>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>

                                <span>Up to {{number_format(planDetails(\App\Enums\Status::PREMIUM)['number'])}} Products</span>
                            </div>

                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>

                                <span>Reviews & Messaging</span>
                            </div>
                        </div>

                        @if($brand->subscription_status == \App\Enums\Status::BASIC)
                            <button variant="primary" class="w-full" wire:click="displayModal('upgrade', 'premium')">
                                Upgrade to Premium
                            </button>
                        @endif
                    </div>

                    <!-- Platinum -->
                    <div class="rounded-3xl border bg-white dark:bg-[#18181B] p-7 shadow-lg hover:shadow-2xl transition-all duration-300 {{ $brand->subscription_status == 'platinum' ? 'border-2 border-purple-500 scale-[1.02] relative' : '' }}">
                        @if($brand->subscription_status == 'platinum')
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                                <div class="px-5 py-1.5 rounded-full bg-gradient-to-r from-purple-600 to-pink-600 text-white text-sm font-semibold shadow-lg">
                                    Current Plan
                                </div>
                            </div>
                        @endif

                        <div class="mb-6 {{ $brand->subscription_status == 'platinum' ? 'mt-2' : '' }}">
                            <span class="px-4 py-1 rounded-full bg-purple-500/10 text-purple-500 text-sm font-medium">
                                Platinum
                            </span>
                        </div>

                        <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                            ₦{{number_format(planDetails(\App\Enums\Status::PLATINUM)['fee'])}}
                            <span class="text-base text-gray-500 font-normal">/month</span>
                        </h3>

                        <p class="text-gray-500 dark:text-gray-400 mb-6">
                            Maximum visibility and dropshipping support.
                        </p>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>

                                <span>Unlimited Growth</span>
                            </div>

                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>

                                <span>Dropshipper Boost</span>
                            </div>
                        </div>

                        @if($brand->subscription_status == \App\Enums\Status::BASIC || $brand->subscription_status == \App\Enums\Status::PREMIUM)
                            <flux:button variant="primary" class="w-full" wire:click="displayModal('upgrade', 'platinum')">
                                Upgrade to Platinum
                            </flux:button>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
            <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="text-lg font-medium text-white mb-4">
                    @php
                        $titles = [
                            'renew' => 'Renew Subscription',
                            'upgrade' => 'Upgrade Subscription',
                            'capacity' => 'Increase Store Capacity',
                        ];
                    @endphp

                    {{ $titles[$type] ?? 'Subscription Action' }}
                </h3>

                @if($type == 'renew')
                    <form wire:submit="renewSubscription">
                        <div class="space-y-4">

                            <div>
                                <flux:select label="Select Subscription Period" wire:model="month">
                                    <option value="">Select Period</option>
                                    <option value="1">1 month</option>
                                    <option value="3">3 months</option>
                                    <option value="6">6 months</option>
                                    <option value="12">12 months</option>
                                </flux:select>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm text-gray-400">
                                            Current Plan
                                        </p>

                                        <p class="text-white font-semibold text-lg mt-1 capitalize">
                                            {{
                                                auth()->user()->brand->subscription_status
                                            }}
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-sm text-gray-400">
                                            Price
                                        </p>

                                        <p class="font-bold mt-1">
                                            ₦{{
                                                number_format(auth()->user()->brand->subscription_amount). ' / month'
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-3 pt-3 border-t border-white/10">
                                    <p class="text-xs text-gray-400">
                                        Subscription will be renewed immediately after payment confirmation.
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Cancel
                                </flux:button>

                                <flux:button type="submit" size="sm" variant="primary">
                                    <flux:icon.loading wire:loading wire:target="renewSubscription" />

                                    <span wire:loading.remove wire:target="renewSubscription">
                                        Proceed
                                    </span>
                                </flux:button>
                            </div>
                        </div>
                    </form>
                @elseif($type == 'increase')
                    <form wire:submit="increaseProducts">
                        <div class="space-y-4">

                            <div>
                                <flux:select label="Product Amount" wire:model="additionalProductNumber">
                                    <option value="">Select Product Amount</option>
                                    <option value="1">10 Products</option>
                                    <option value="2">20 Products</option>
                                    <option value="3">30 Products</option>
                                </flux:select>
                            </div>

                            <!-- Pricing Card -->
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm text-gray-400">
                                            Current Plan
                                        </p>

                                        <p class="text-white font-semibold text-lg mt-1 capitalize">
                                            {{
                                                auth()->user()->brand->subscription_status
                                            }}
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-sm text-gray-400">
                                            Price
                                        </p>

                                        <p class="font-bold mt-1">
                                            ₦{{
                                                number_format(planDetails(auth()->user()->brand->subscription_status)['additional_fee']). ' / '.
                                                planDetails(auth()->user()->brand->subscription_status)['additional_number']. ' products'
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-3 pt-3 border-t border-white/10">
                                    <p class="text-xs text-gray-400">
                                        Capacity upgrade will be added immediately after payment confirmation.
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Cancel
                                </flux:button>

                                <flux:button type="submit" size="sm" variant="primary">
                                    <flux:icon.loading wire:loading wire:target="increaseProducts" />

                                    <span wire:loading.remove wire:target="increaseProducts">
                                        Proceed
                                    </span>
                                </flux:button>
                            </div>

                        </div>
                    </form>
                @else
                    <form wire:submit="getTotal">
                        <div class="space-y-4">

                            <div>
                                <flux:select label="Select Subscription Period" wire:model="month">
                                    <option value="">Select Period</option>
                                    <option value="1">1 month</option>
                                    <option value="3">3 months</option>
                                    <option value="6">6 months</option>
                                    <option value="12">12 months</option>
                                </flux:select>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm text-gray-400">
                                            Plan
                                        </p>

                                        <p class="text-white font-semibold text-lg mt-1 capitalize">
                                            {{
                                                $plan
                                            }}
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-sm text-gray-400">
                                            Price
                                        </p>

                                        <p class="font-bold mt-1">
                                            ₦{{
                                                number_format(planDetails($plan)['fee']). ' / month'
                                            }}
                                        </p>
                                    </div>
                                </div>
                                @if($resolvedPrice)
                                    <div class="mt-3 pt-3 border-t border-white/10">
                                        <p class="text-sm text-gray-400">
                                            You have {{ expiryDate($brand->exp_date)['daysRemaining'] }} days remaining on your current plan.
                                            When you upgrade, your subscription will be prorated, and you’ll only pay the difference of ₦{{ number_format($resolvedPrice) }}.
                                        </p>
                                    </div>
                                @endif

                                @if($showTotal)
                                    <div class="mt-3 pt-3 border-t border-white/10">
                                        <p class="text-white font-semibold text-sm mt-1 capitalize flex justify-between">
                                            <span>Total</span>
                                            <span>₦{{number_format($total)}}</span>
                                        </p>
                                    </div>
                                @endif

                                <div class="mt-3 pt-3 border-t border-white/10">
                                    <p class="text-xs text-gray-400">
                                        Your plan will be updated immediately after payment confirmation.
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Cancel
                                </flux:button>

                                <flux:button type="submit" size="sm" variant="primary">
                                    <flux:icon.loading wire:loading wire:target="getTotal" />
                                    <span wire:loading.remove wire:target="getTotal">
                                                Check Total
                                            </span>
                                </flux:button>
                            </div>
                            @if($showTotal)
                                <div class="flex justify-end space-x-2">
                                    <flux:button type="button" size="sm" color="green" variant="primary" wire:click="upgradePlan">
                                        <flux:icon.loading wire:loading wire:target="upgradePlan" />
                                        <span>
                                            Make Payment
                                        </span>
                                    </flux:button>
                                </div>
                            @endif
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
</section>
