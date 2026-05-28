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
                            <p class="text-sm text-gray-400 mb-1">Total Brands</p>
                            <p class="text-2xl font-bold text-blue-500">
                                {{ $totalBrands }}
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
                            <p class="text-sm text-gray-400 mb-1">Active Brands</p>
                            <p class="text-2xl font-bold text-green-400">
                                {{ $activeBrands }}
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
                            <p class="text-sm text-gray-400 mb-1">Expired Brands</p>
                            <p class="text-2xl font-bold text-red-400">
                                {{ $expiredBrands }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Inactive --}}
                <div
                    wire:click="setFilter('inactive')"
                    class="rounded-lg p-4 cursor-pointer transition-all border
                    {{ $filter === 'inactive'
                        ? 'bg-yellow-500/20 border-yellow-500'
                        : 'bg-[#3d3d40] border-transparent hover:bg-[#4a4a4d]'
                    }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Inactive Brands</p>
                            <p class="text-2xl font-bold text-yellow-400">
                                {{ $inactiveBrands }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- New --}}
                <div
                    wire:click="setFilter('new')"
                    class="rounded-lg p-4 cursor-pointer transition-all border
                    {{ $filter === 'new'
                        ? 'bg-purple-500/20 border-purple-500'
                        : 'bg-[#3d3d40] border-transparent hover:bg-[#4a4a4d]'
                    }}"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">New Brands</p>
                            <p class="text-2xl font-bold text-purple-400">
                                {{ $newBrands }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">

                @if($brands->count() > 0)

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-500">

                            <thead class="bg-[#3d3d40]">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Brand
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Owner
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Products
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Subscription
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">
                                    Plan
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

                            @foreach($brands as $brand)

                                <tr class="hover:bg-[#4a4a4d] transition-colors">

                                    {{-- Brand --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">

                                            @if($brand->image)
                                                <img
                                                    src="{{ Storage::url($brand->image) }}"
                                                    class="w-10 h-10 rounded-full object-cover"
                                                >
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-[#27272a] flex items-center justify-center">
                                                    <span class="text-sm text-gray-300 font-bold">
                                                        {{ strtoupper(substr($brand->brand_name, 0, 2)) }}
                                                    </span>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="text-sm font-medium text-gray-200">
                                                    {{ $brand->brand_name ?? 'Brand Not Set' }}
                                                </div>

                                                <div class="text-xs text-gray-500">
                                                    {{ $brand->brand_email ?? 'Email not set' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Owner --}}
                                    <td class="px-6 py-4 text-sm text-gray-300 whitespace-nowrap">
                                        {{ $brand->user?->name ?? 'N/A' }}
                                    </td>

                                    {{-- Products --}}
                                    <td class="px-6 py-4 text-sm text-gray-300">
                                        {{ number_format($brand->products->count() ?? 0)}} / {{number_format($brand->no_of_products ?? 0) }}
                                    </td>

                                    {{-- Subscription Amount --}}
                                    <td class="px-6 py-4 text-sm text-gray-300">
                                        ₦{{ number_format($brand->subscription_amount ?? 0) }}
                                    </td>

                                    {{-- Plan --}}
                                    <td class="px-6 py-4">

                                        @php
                                            $plan = strtolower($brand->subscription_status ?? '');
                                        @endphp

                                        @if($plan === \App\Enums\Status::BASIC)
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-500/20 text-gray-300 border border-gray-500/30">
                                                Basic
                                            </span>

                                        @elseif($plan === \App\Enums\Status::PREMIUM)
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                                Premium
                                            </span>

                                        @elseif($plan === \App\Enums\Status::PLATINUM)
                                            <span class="px-2 py-1 text-xs rounded-full bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                                Platinum
                                            </span>

                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                No Plan
                                            </span>
                                        @endif

                                    </td>

                                    {{-- Expiry --}}
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        @if($brand->exp_date)
                                            <span class="{{ expiryDate($brand->exp_date)['isExpired'] ? 'text-red-400' : 'text-green-400' }}">
                                                {{ \Carbon\Carbon::parse($brand->exp_date)->format('F d, Y') }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">N/A</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">
                                        @if($brand->status === \App\Enums\Status::COMPLETED)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                Completed
                                            </span>

                                        @elseif($brand->status === \App\Enums\Status::UNLISTED)
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                Unlisted
                                            </span>

                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                                N/A
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        @if($brand->brand_name)
                                            <div class="flex items-center space-x-1" wire:click.stop>
                                                <flux:dropdown position="bottom" align="end" offset="-15">
                                                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                                    <flux:menu>
                                                        @if($brand->status === \App\Enums\Status::COMPLETED)
                                                            <flux:menu.item href="{{route('shop', $brand)}}">View Shop</flux:menu.item>
                                                        @endif

                                                        @if(($brand->subscription_status != \App\Enums\Status::BASIC && expiryDate($brand->exp_date)['isExpired']) || ! $brand->subscription_status)
                                                            <flux:menu.item wire:click="downgrade({{ $brand->id }})" wire:confirm="Are you sure you want to downgrade this brand?" wire:key="downgrade">Downgrade</flux:menu.item>
                                                        @endif

                                                        @if($brand->subscription_status != \App\Enums\Status::PLATINUM)
                                                            <flux:menu.item wire:click="openModal({{ $brand->id }}, 'upgrade')" wire:key="upgrade">Upgrade</flux:menu.item>
                                                        @endif

                                                        @if($brand->subscription_status != \App\Enums\Status::BASIC)
                                                            <flux:menu.item wire:click="openModal({{ $brand->id }}, 'resubscribe')" wire:key="resubscribe">Resubscribe</flux:menu.item>
                                                        @endif

                                                        <flux:menu.item wire:click="openModal({{ $brand->id }}, 'increase')" wire:key="increase">Increase Slots</flux:menu.item>
                                                    </flux:menu>
                                                </flux:dropdown>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Joined --}}
                                    <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">
                                        {{ $brand->created_at?->format('M d, Y') }}
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>

                @else

                    <div class="text-center py-12">
                        <h3 class="text-sm font-medium text-gray-300">
                            No brands found
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            No brands match this filter.
                        </p>
                    </div>

                @endif
            </div>

            <div class="mt-4">
                {{ $brands->links() }}
            </div>
        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 bg-black/70 flex items-center justify-center p-4" style="z-index: 50;">
            <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                @if($type == 'upgrade')

                    <h3 class="text-lg font-medium text-white mb-4">
                        Upgrade Brand
                    </h3>
                    <form wire:submit="getTotal">
                        <div class="space-y-4">

                            <div>
                                <flux:select label="Select Plan" wire:model="plan">
                                    <option value="">Select Plan</option>
                                    @if($selectedBrand->subscription_status == \App\Enums\Status::BASIC)
                                        <option value="premium" class="capitalize">Premium Plan</option>
                                    @endif
                                    <option value="platinum" class="capitalize">Platinum Plan</option>
                                </flux:select>
                            </div>

                            <div>
                                <flux:select label="Subscription Duration" wire:model="month">
                                    <option value="">Select Subscription Duration</option>
                                    <option value="1">1 Month</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">12 Months</option>
                                </flux:select>
                            </div>

                            @if($resolvedPrice)
                                <div class="mt-3 pt-3 border-t border-white/10">
                                    <p class="text-sm text-gray-400">
                                        You have {{ expiryDate($selectedBrand->exp_date)['daysRemaining'] }} days remaining on your current plan.
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

                            <div class="flex justify-end space-x-2">
                                <flux:button type="button" variant="subtle" size="sm" wire:click="closeModal">
                                    Cancel
                                </flux:button>

                                <flux:button type="submit" size="sm" variant="primary">
                                    <flux:icon.loading wire:loading wire:target="getTotal" />

                                    <span wire:loading.remove wire:target="getTotal">
                                            Proceed
                                        </span>
                                </flux:button>
                            </div>

                            @if($showTotal)
                                <div class="flex justify-end space-x-2">
                                    <flux:button type="button" size="sm" color="green" variant="primary" wire:click="upgrade">
                                        <flux:icon.loading wire:loading wire:target="upgrade" />
                                        <span>
                                            Upgrade
                                        </span>
                                    </flux:button>
                                </div>
                            @endif

                        </div>
                    </form>

                @elseif($type == 'resubscribe')

                    <h3 class="text-lg font-medium text-white mb-4">
                        Resubscribe
                    </h3>
                    <form wire:submit="resubscribe">
                        <div class="space-y-4">
                            <div>
                                <flux:select label="Resubscription Duration" wire:model="month">
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
                                    <flux:icon.loading wire:loading wire:target="resubscribe" />

                                    <span wire:loading.remove wire:target="resubscribe">
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
