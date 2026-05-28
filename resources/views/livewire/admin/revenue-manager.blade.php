{{-- resources/views/livewire/admin/revenue-manager.blade.php --}}

<section class="w-full">
    @include('partials.admin-heading')

    <flux:heading class="sr-only">
        {{ __('Revenue Report') }}
    </flux:heading>

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4 gap-4">
        <div class="flex-1 max-w-md">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search by user, brand or description..."
                type="search"
            />
        </div>
    </div>

    <flux:separator />

    <div class="min-h-screen mt-3">
        <div class="max-w-7xl mx-auto">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

                {{-- Total Revenue --}}
                <div
                    class="bg-[#3d3d40] rounded-lg p-4 cursor-pointer hover:bg-[#444447] transition"
                    wire:click="setFilter('all')"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">
                                Total Revenue
                            </p>

                            <p class="text-2xl font-bold text-green-400">
                                ₦{{ number_format($totalRevenue) }}
                            </p>
                        </div>

                        <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0-6v2m0 16v2m8-10h2M2 12H4m12.95 6.95l1.414 1.414M5.636 5.636L7.05 7.05m9.9-1.414L18.364 4.222M5.636 18.364l1.414-1.414"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Monthly Revenue --}}
                <div
                    class="bg-[#3d3d40] rounded-lg p-4 cursor-pointer hover:bg-[#444447] transition"
                    wire:click="setFilter('this-month')"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">
                                This Month
                            </p>

                            <p class="text-2xl font-bold text-blue-400">
                                ₦{{ number_format($monthlyRevenue) }}
                            </p>
                        </div>

                        <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Today Revenue --}}
                <div
                    class="bg-[#3d3d40] rounded-lg p-4 cursor-pointer hover:bg-[#444447] transition"
                    wire:click="setFilter('today')"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">
                                Today
                            </p>

                            <p class="text-2xl font-bold text-purple-400">
                                ₦{{ number_format($todayRevenue) }}
                            </p>
                        </div>

                        <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Renewals --}}
                <div
                    class="bg-[#3d3d40] rounded-lg p-4 cursor-pointer hover:bg-[#444447] transition"
                    wire:click="setFilter('renewals')"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">
                                Renewals
                            </p>

                            <p class="text-2xl font-bold text-yellow-400">
                                {{ $renewals }}
                            </p>
                        </div>

                        <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4v6h6M20 20v-6h-6"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Upgrades --}}
                <div
                    class="bg-[#3d3d40] rounded-lg p-4 cursor-pointer hover:bg-[#444447] transition"
                    wire:click="setFilter('upgrades')"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-400 mb-1">
                                Upgrades
                            </p>

                            <p class="text-2xl font-bold text-pink-400">
                                {{ $upgrades }}
                            </p>
                        </div>

                        <div class="w-10 h-10 bg-pink-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Revenue Table --}}
            <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">

                @if($revenues->count() > 0)

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-500">

                            {{-- Table Head --}}
                            <thead class="bg-[#3d3d40]">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    User
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Brand
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Amount
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Description
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Date
                                </th>
                            </tr>
                            </thead>

                            {{-- Table Body --}}
                            <tbody class="bg-[#3d3d40] divide-y divide-gray-500">

                            @foreach($revenues as $revenue)

                                <tr class="hover:bg-gray-750 transition-colors">

                                    {{-- User --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">
                                                <span class="text-gray-300 font-medium text-sm">
                                                    {{ strtoupper(substr($revenue->user?->name ?? 'NA', 0, 2)) }}
                                                </span>
                                            </div>

                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-200">
                                                    {{ $revenue->user?->name ?? 'Deleted User' }}
                                                </div>

                                                <div class="text-xs text-gray-500">
                                                    {{ $revenue->user?->email ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Brand --}}
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-300">
                                            {{ $revenue->brand?->brand_name ?? 'N/A' }}
                                        </span>
                                    </td>

                                    {{-- Amount --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-green-400">
                                            ₦{{ number_format($revenue->amount) }}
                                        </span>
                                    </td>

                                    {{-- Description --}}
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-300 capitalize">
                                            {{ $revenue->description }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">

                                        @php
                                            $plan = strtolower($revenue->brand?->subscription_status ?? '');
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

                                    {{-- Date --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-400">
                                            {{ $revenue->created_at->format('F d, Y H:i:s') }}
                                        </span>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>

                @else

                    {{-- Empty State --}}
                    <div class="text-center py-12">

                        <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0-6v2m0 16v2m8-10h2M2 12H4"
                            />
                        </svg>

                        <h3 class="mt-2 text-sm font-medium text-gray-300">
                            No revenue records found
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Revenue transactions will appear here.
                        </p>
                    </div>

                @endif
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $revenues->links() }}
            </div>
        </div>
    </div>
</section>
