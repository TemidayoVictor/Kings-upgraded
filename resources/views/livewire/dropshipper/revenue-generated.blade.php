{{-- resources/views/livewire/dropshipper-earnings.blade.php --}}
<section class="w-full">
    @include('partials.partnerships')

    <flux:heading class="sr-only">{{ __('Monthly Earnings') }}</flux:heading>
    <x-dropshippers.layout :heading="__('Earnings Overview')" :subheading="__('Track your monthly earnings and performance')">

        <!-- Earnings Summary Cards -->
        @php
            $totalEarnings = $earnings->sum('total_amount');
            $averageMonthly = $earnings->count() > 0 ? $totalEarnings / $earnings->count() : 0;
            $bestMonth = $earnings->sortByDesc('total_amount')->first();
            $recentMonth = $earnings->first();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            @php
                $totalEarnings = $earnings->sum('total_amount');
                $averageMonthly = $earnings->count() > 0 ? $totalEarnings / $earnings->count() : 0;
                $bestMonth = $earnings->sortByDesc('total_amount')->first();
                $recentMonth = $earnings->first();
            @endphp

            <div class="bg-[#27272a] rounded-lg p-4 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Total Earnings</p>
                        <p class="text-2xl font-bold text-white">₦{{ number_format($totalEarnings, 2) }}</p>
                    </div>
                    <div class="h-10 w-10 bg-[#3d3d40] rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-[#27272a] rounded-lg p-4 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Average Monthly</p>
                        <p class="text-2xl font-bold text-white">₦{{ number_format($averageMonthly, 2) }}</p>
                    </div>
                    <div class="h-10 w-10 bg-[#3d3d40] rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-[#27272a] rounded-lg p-4 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Best Month</p>
                        <p class="text-xl font-bold text-white truncate">
                            @if($bestMonth)
                                {{ $bestMonth->month_name }} {{ $bestMonth->year }}
                            @else
                                --
                            @endif
                        </p>
                        <p class="text-sm text-green-400">₦{{ number_format($bestMonth?->total_amount ?? 0, 2) }}</p>
                    </div>
                    <div class="h-10 w-10 bg-[#3d3d40] rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-[#27272a] rounded-lg p-4 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Months Tracked</p>
                        <p class="text-2xl font-bold text-white">{{ $earnings->count() }}</p>
                    </div>
                    <div class="h-10 w-10 bg-[#3d3d40] rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <flux:separator/>

        <div class="min-h-screen">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 my-3">
                    <div>
                        @if($selectedMonth)
                            <div class="flex items-center gap-2">
                                <flux:button size="xs" variant="subtle" wire:click="clearSelectedMonth" class="!p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                </flux:button>
                                <flux:heading size="lg">{{ $selectedMonthName }} {{ $selectedYear }} Details</flux:heading>
                            </div>
                        @else
                            <flux:heading class="sr-only">{{ __('Monthly Earnings List') }}</flux:heading>
                        @endif
                    </div>
                </div>

                @if($selectedMonth)
                    <!-- Individual Records View -->
                    <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                        <div class="p-4 border-b border-gray-500 bg-[#27272a]">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-400">Total for {{ $selectedMonthName }} {{ $selectedYear }}</p>
                                    <p class="text-2xl font-bold text-white">₦{{ number_format($selectedMonthTotal, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">Number of Orders</p>
                                    <p class="text-xl font-bold text-white">{{ $monthlyRecords->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Desktop Table View for Records -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-500">
                                <thead class="bg-[#3d3d40]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">DATE</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">DESCRIPTION</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">AMOUNT</th>
                                </tr>
                                </thead>
                                <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                                @forelse($monthlyRecords as $record)
                                    <tr class="hover:bg-gray-750 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-200">{{ $record->created_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $record->created_at->format('g:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-200">{{ $record->description ?? 'Dropshipping earning' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="text-sm font-semibold text-green-400">+₦{{ number_format($record->amount, 2) }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                            No individual records found for this month.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View for Records -->
                        <div class="sm:hidden divide-y divide-gray-500">
                            @forelse($monthlyRecords as $record)
                                <div class="p-4 hover:bg-gray-750 transition-colors">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <div class="text-sm font-medium text-gray-200">{{ $record->created_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $record->created_at->format('g:i A') }}</div>
                                        </div>
                                        <div class="text-sm font-semibold text-green-400">+₦{{ number_format($record->amount, 2) }}</div>
                                    </div>
                                    <div class="text-xs text-gray-400">{{ $record->description ?? 'Dropshipping earning' }}</div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-400">
                                    No individual records found for this month.
                                </div>
                            @endforelse
                        </div>
                    </div>
                @else
                    <!-- Monthly Summary View -->
                    <div class="bg-[#3d3d40] rounded-lg shadow-lg overflow-hidden">
                        @if($earnings->count() > 0)
                            <!-- Desktop Table View (hidden on mobile) -->
                            <div class="hidden sm:block overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-500">
                                    <thead class="bg-[#3d3d40]">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            MONTH
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            TOTAL EARNINGS
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            ORDERS
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                            ACTIONS
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-[#3d3d40] divide-y divide-gray-500">
                                    @foreach($earnings as $earning)
                                        <tr class="hover:bg-gray-750 transition-colors cursor-pointer" wire:click="viewMonthDetails({{ $earning->year }}, {{ $earning->month_number }}, '{{ $earning->month_name }}')">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-200">
                                                            {{ $earning->month_name }} {{ $earning->year }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <div class="text-sm font-semibold text-white">
                                                    ₦{{ number_format($earning->total_amount, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#27272a] text-gray-300">
                                                        {{ $earning->transactions_count ?? 0 }} order{{ ($earning->transactions_count ?? 0) == 1 ? '' : 's' }}
                                                    </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button
                                                    wire:click.stop="viewMonthDetails({{ $earning->year }}, {{ $earning->month_number }}, '{{ $earning->month_name }}')"
                                                    class="text-gray-400 hover:text-gray-200 transition-colors"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card View (visible only on mobile) -->
                            <div class="sm:hidden divide-y divide-gray-500">
                                @foreach($earnings as $earning)
                                    <div class="p-4 hover:bg-gray-750 transition-colors cursor-pointer" wire:click="viewMonthDetails({{ $earning->year }}, {{ $earning->month_number }}, '{{ $earning->month_name }}')">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div>
                                                    <div class="font-medium text-gray-200">{{ $earning->month_name }} {{ $earning->year }}</div>
                                                    <div class="text-xs text-gray-500">{{ $earning->transactions_count ?? 0 }} order{{ ($earning->transactions_count ?? 0) == 1 ? '' : 's' }} </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-bold text-white">₦{{ number_format($earning->total_amount, 2) }}</div>
                                                <svg class="w-4 h-4 text-gray-400 ml-auto mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 px-4">
                                <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-300">No earnings data</h3>
                                <p class="mt-1 text-sm text-gray-500">Earnings will appear here once you start selling.</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </x-dropshippers.layout>
</section>
