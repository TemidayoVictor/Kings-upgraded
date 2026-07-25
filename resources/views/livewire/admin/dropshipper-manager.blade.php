{{-- resources/views/livewire/admin/brand-manager.blade.php --}}

<section class="w-full">
    @include('partials.admin-heading')

    <flux:heading class="sr-only">
        {{ __('Manage Brands') }}
    </flux:heading>

    <div class="flex justify-between items-center mb-4 gap-4">
        <div class="flex-1 max-w-md">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search brands..."
                type="search"
            />
        </div>
    </div>

    <flux:separator />

    <div class="min-h-screen mt-3">
        <div class="max-w-7xl mx-auto">

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

                {{-- Total --}}
                <div
                    wire:click="setFilter('all')"
                    class="rounded-lg p-4 cursor-pointer transition-all border
                    {{ $filter === 'all'
                        ? 'bg-blue-500/20 border-blue-500'
                        : 'bg-[#3d3d40] border-transparent hover:bg-[#4a4a4d]'
                    }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Total Dropshippers</p>
                            <p class="text-2xl font-bold text-blue-500">
                                {{ $totalDropshippers }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Active --}}
                <div
                    wire:click="setFilter('active')"
                    class="rounded-lg p-4 cursor-pointer transition-all border
                    {{ $filter === 'active'
                        ? 'bg-green-500/20 border-green-500'
                        : 'bg-[#3d3d40] border-transparent hover:bg-[#4a4a4d]'
                    }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Active Dropshippers</p>
                            <p class="text-2xl font-bold text-green-400">
                                {{ $activeDropshippers }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Expired --}}
                <div
                    wire:click="setFilter('expired')"
                    class="rounded-lg p-4 cursor-pointer transition-all border
                    {{ $filter === 'expired'
                        ? 'bg-red-500/20 border-red-500'
                        : 'bg-[#3d3d40] border-transparent hover:bg-[#4a4a4d]'
                    }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Expired Dropshippers</p>
                            <p class="text-2xl font-bold text-red-400">
                                {{ $expiredDropshippers }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">

                @if($dropshippers->count() > 0)

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-500">

                            <thead class="bg-[#3d3d40]">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Dropshipper
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Subscription
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Expiry Date
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase">
                                    Actions
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Joined
                                </th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-500">

                            @foreach($dropshippers as $dropshipper)

                                <tr class="hover:bg-[#4a4a4d] transition-colors">

                                    {{-- Brand --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">

                                            @if($dropshipper->image)
                                                <img
                                                    src="{{ Storage::url($dropshipper->image) }}"
                                                    class="w-10 h-10 rounded-full object-cover"
                                                >
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-[#27272a] flex items-center justify-center">
                                                    <span class="text-sm text-gray-300 font-bold">
                                                        {{ strtoupper(substr($dropshipper->username, 0, 2)) }}
                                                    </span>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="text-[1em] font-bold text-gray-300 whitespace-nowrap">
                                                    {{ $dropshipper->user?->name ?? 'N/A' }}
                                                </div>
                                                <div class="text-sm font-medium text-gray-200">
                                                    {{ $dropshipper->username ?? 'Dropshipper Not Set' }}
                                                </div>

                                                <div class="text-xs text-gray-500">
                                                    {{ $dropshipper->user->email ?? 'Email not set' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Plan --}}
                                    <td class="px-6 py-4">

                                        @php
                                            $plan = strtolower($dropshipper->subscription_type ?? '');
                                        @endphp

                                        @if($plan === \App\Enums\Status::MONTHLY)
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-500/20 text-gray-300 border border-gray-500/30">
                                                Monthly
                                            </span>

                                        @elseif($plan === \App\Enums\Status::COMMISSION)
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                                Commission
                                            </span>

                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                No Plan
                                            </span>
                                        @endif

                                    </td>

                                    {{-- Expiry --}}
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        @if($dropshipper->exp_date)
                                            <span class="{{ expiryDate($dropshipper->exp_date)['isExpired'] ? 'text-red-400' : 'text-green-400' }}">
                                                {{ \Carbon\Carbon::parse($dropshipper->exp_date)->format('F d, Y') }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">N/A</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">
                                        @if($dropshipper->status === \App\Enums\Status::COMPLETED)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                Completed
                                            </span>

                                        @elseif($dropshipper->status === \App\Enums\Status::UNLISTED)
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                Unlisted
                                            </span>

                                        @elseif($dropshipper->status === \App\Enums\Status::DEACTIVATED)
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                Deactivated
                                            </span>

                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                                N/A
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        @if($dropshipper->username)
                                            <div class="flex items-center space-x-1" wire:click.stop>
                                                <flux:dropdown position="bottom" align="end" offset="-15">
                                                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                                    <flux:menu>
                                                        @foreach($dropshipper->stores as $store)
                                                            <flux:menu.item href="{{route('dropshipper-store', $store)}}">View {{$store->store_name}}</flux:menu.item>
                                                        @endforeach

                                                        @if(($dropshipper->subscription_type == \App\Enums\Status::MONTHLY ))
                                                            <flux:menu.item wire:click="openModal({{ $dropshipper->id }}, 'renew')" wire:key="renew">Renew Subscription</flux:menu.item>
                                                        @endif

                                                        @if(($dropshipper->subscription_type == \App\Enums\Status::MONTHLY && expiryDate($dropshipper->exp_date)['isExpired'] && ($dropshipper->status != \App\Enums\Status::DEACTIVATED)))
                                                            <flux:menu.item wire:click="deactivate({{ $dropshipper->id }})" wire:confirm="Are you sure you want to deactivate this dropshipper?" wire:key="deactivate">Deactivate</flux:menu.item>
                                                        @endif

                                                        @if(($dropshipper->status == \App\Enums\Status::DEACTIVATED))
                                                            <flux:menu.item wire:click="activate({{ $dropshipper->id }})" wire:confirm="Are you sure you want to activate this dropshipper?" wire:key="activate">Activate</flux:menu.item>
                                                        @endif

                                                        <flux:menu.item wire:click="openModal({{ $dropshipper->id }}, 'change')" wire:key="change">Change Subscription</flux:menu.item>
                                                    </flux:menu>

                                                </flux:dropdown>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Joined --}}
                                    <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">
                                        {{ $dropshipper->created_at?->format('M d, Y') }}
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>

                @else

                    <div class="text-center py-12">
                        <h3 class="text-sm font-medium text-gray-300">
                            No dropshippers found
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            No dropshippers match this filter.
                        </p>
                    </div>

                @endif
            </div>

            <div class="mt-4">
                {{ $dropshippers->links() }}
            </div>
        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
            <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                @if($type == 'change')

                    <div class="bg-white dark:bg-[#3d3d40] border-2 rounded-lg p-6 transition-all duration-200 border-gray-200 dark:border-[#3d3d40] hover:border-black dark:hover:border-white">
                        @if($selectedDropshipper->subscription_type == App\Enums\Status::MONTHLY)
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-black dark:text-white">{{ __('Change to Commission Based Subscription') }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Pay per successful sale') }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-baseline">
                                <span class="text-3xl font-bold text-black dark:text-white">{{number_format(generalSetting()->dropshipper_percent)}}%</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">{{ __('of profit per sale') }}</span>
                            </div>
                        @else
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-black dark:text-white">{{ __('Change to Monthly Subscription') }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Pay a fixed monthly fee') }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-baseline">
                                <span class="text-3xl font-bold text-black dark:text-white">₦{{number_format(generalSetting()->dropshipper_fee)}}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">/{{ __('month') }}</span>
                            </div>
                        @endif

                        @if($dropshipper->subscription_type == App\Enums\Status::MONTHLY )
                            <div class="flex justify-end space-x-2 mt-2 ">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Cancel
                                </flux:button>

                                <flux:button
                                    variant="primary"
                                    size="sm"
                                    wire:click="changeSubscription('{{ App\Enums\Status::COMMISSION }}', {{$selectedDropshipper->id}})"
                                >
                                    Change
                                </flux:button>
                            </div>
                        @else
                            <div class="flex justify-end space-x-2 mt-2 ">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Cancel
                                </flux:button>

                                <flux:button
                                    variant="primary"
                                    size="sm"
                                    wire:click="changeSubscription('{{ App\Enums\Status::MONTHLY }}', {{$selectedDropshipper->id}})"
                                >
                                    Change
                                </flux:button>
                            </div>
                        @endif
                    </div>

                @elseif($type == 'renew')

                    <h3 class="text-lg font-medium text-white mb-4">
                        Resubscribe
                    </h3>
                    <form wire:submit="renewSubscription">
                        <div class="space-y-4">
                            <div>
                                <flux:select label="Resubscription Duration" wire:model="duration">
                                    <option value="">Select Subscription Duration</option>
                                    <option value="1">1 Month</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">12 Months</option>
                                </flux:select>
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
                    <h3 class="text-lg font-medium text-white mb-4">
                        Increase Store Capacity
                    </h3>
                    <form wire:submit="increase">
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
                                                $selectedBrand->subscription_status
                                            }}
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-sm text-gray-400">
                                            Price
                                        </p>

                                        <p class="font-bold mt-1">
                                            ₦{{
                                                    number_format(planDetails($selectedBrand->subscription_status)['additional_fee']). ' / '.
                                                    planDetails($selectedBrand->subscription_status)['additional_number']. ' products'
                                                }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-3 pt-3 border-t border-white/10">
                                    <p class="text-xs text-gray-400">
                                        Capacity upgrade will be added immediately.
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Cancel
                                </flux:button>

                                <flux:button type="submit" size="sm" variant="primary">
                                    <flux:icon.loading wire:loading wire:target="increase" />

                                    <span wire:loading.remove wire:target="increase">
                                            Proceed
                                        </span>
                                </flux:button>
                            </div>

                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
</section>
