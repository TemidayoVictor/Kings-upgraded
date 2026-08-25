<section class="w-full">
    @include('partials.admin-heading')

    <flux:heading class="sr-only">{{ __('Manage Logs') }}</flux:heading>
    <x-settings.layout :heading="__('Logs Management')" :subheading="__('Monitor system activities via log')">
        <div class="space-y-6">
            <div class="flex items-center justify-between">

                <div class="flex items-center gap-2">

                    <flux:button wire:click="$refresh" variant="primary" size="sm">
                        Refresh
                    </flux:button>
                    <flux:button variant="primary" size="sm" href="{{ route('admin-download-logs', ['date' => $date]) }}">
                        Download logs
                    </flux:button>
                    <flux:button wire:click="confirmClear" variant="primary" size="sm">
                        Clear logs
                    </flux:button>
                </div>
            </div>

            {{-- Filters --}}
            <div class="rounded-lg bg-white p-4 dark:bg-[#3d3d40]">

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <flux:select label="Log Date" wire:model.live="date">
                            @foreach ($dates as $logDate)
                                <option value="{{ $logDate }}">
                                    {{ \Carbon\Carbon::parse($logDate)->format('F d, Y') }}
                                </option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:select label="Level" wire:model.live="level">
                            <option value="all">All levels</option>
                            <option value="emergency">Emergency</option>
                            <option value="alert">Alert</option>
                            <option value="critical">Critical</option>
                            <option value="error">Error</option>
                            <option value="warning">Warning</option>
                            <option value="notice">Notice</option>
                            <option value="info">Info</option>
                            <option value="debug">Debug</option>
                        </flux:select>
                    </div>

                    {{-- Search --}}
                    <div>
                        <flux:input wire:model.live.debounce.500ms="search" label="Search" type="text" required />
                    </div>

                </div>


                <div class="mt-4 flex items-center gap-2">
                    <flux:button variant="primary" wire:click="clearFilters" size="sm">
                        Clear Filters
                    </flux:button>
                </div>

            </div>


            {{-- Metadata --}}
            @if ($fileExists)

                <div class="grid gap-4 md:grid-cols-3">

                    <div class="rounded-lg bg-white p-4 dark:bg-[#3d3d40]">
                        <p class="text-xs text-gray-500">
                            File Size
                        </p>

                        <p class="mt-1 font-semibold">
                            {{ number_format($fileSize / 1024 / 1024, 2) }} MB
                        </p>
                    </div>

                    <div class="rounded-lg bg-white p-4 dark:bg-[#3d3d40]">
                        <p class="text-xs text-gray-500">
                            Last Modified
                        </p>

                        <p class="mt-1 font-semibold">
                            {{ $lastModified?->format('M d, Y H:i:s') }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-white p-4 dark:bg-[#3d3d40]">
                        <p class="text-xs text-gray-500">
                            Matching Entries
                        </p>

                        <p class="mt-1 font-semibold">
                            {{ number_format($logs['total']) }}
                        </p>
                    </div>

                </div>

            @endif


            {{-- Logs --}}
            <div class="overflow-hidden rounded-lg bg-white dark:bg-[#3d3d40]">

                @forelse ($logs['items'] as $log)

                    <button
                        wire:click="viewLog(@js($log))"
                        class="block w-full border-b p-4 text-left transition hover:bg-gray-50 dark:hover:bg-[#27272a]"
                    >

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <div class="mb-1 flex items-center gap-2">

                            <span class="text-xs text-gray-500">
                                {{ $log['timestamp'] }}
                            </span>

                                    <span class="rounded px-2 py-0.5 text-xs font-medium
                                @switch($log['level'])
                                    @case('ERROR')
                                    @case('CRITICAL')
                                        bg-red-100 text-red-700
                                        @break

                                    @case('WARNING')
                                        bg-yellow-100 text-yellow-700
                                        @break

                                    @case('INFO')
                                        bg-blue-100 text-blue-700
                                        @break

                                    @default
                                        bg-gray-100 text-gray-700
                                @endswitch
                            ">
                                {{ $log['level'] }}
                            </span>

                                </div>

                                <p class="truncate font-mono text-sm text-gray-800 dark:text-gray-200">
                                    {{ $log['message'] }}
                                </p>

                            </div>

                            <span class="text-sm text-gray-400">
                        View →
                    </span>

                        </div>

                    </button>

                @empty

                    <div class="p-12 text-center">

                        @if (!$fileExists)

                            <p class="font-medium">
                                No log file found.
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                No log file exists for {{ $date }}.
                            </p>

                        @else

                            <p class="font-medium">
                                No logs found.
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Try changing your search or filters.
                            </p>

                        @endif

                    </div>

                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($logs['last_page'] > 1)

                <div class="flex items-center justify-between">

                    <button
                        wire:click="previousPage"
                        @disabled($logs['current_page'] <= 1)
                        class="rounded-lg border px-4 py-2 text-sm disabled:opacity-50"
                    >
                        Previous
                    </button>

                    <span class="text-sm text-gray-500">
                Page {{ $logs['current_page'] }}
                of {{ $logs['last_page'] }}
            </span>

                    <button
                        wire:click="nextPage"
                        @disabled($logs['current_page'] >= $logs['last_page'])
                        class="rounded-lg border px-4 py-2 text-sm disabled:opacity-50"
                    >
                        Next
                    </button>

                </div>

            @endif


            {{-- Details Modal --}}
            @if ($showDetailsModal && $selectedLog)

                <div
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                >

                    <div
                        class="max-h-[90vh] w-full max-w-5xl overflow-hidden rounded-xl bg-white shadow-xl dark:bg-[#3d3d40]"
                    >

                        <div class="flex items-center justify-between border-b p-4">

                            <div>
                                <h2 class="font-semibold">
                                    Log Details
                                </h2>

                                <p class="text-xs text-gray-500">
                                    {{ $selectedLog['timestamp'] }}
                                </p>
                            </div>

                            <button
                                wire:click="closeDetails"
                                class="text-gray-500"
                            >
                                ✕
                            </button>

                        </div>

                        <div class="max-h-[75vh] overflow-y-auto p-6">

                            <div class="mb-6 grid gap-4 md:grid-cols-3">

                                <div>
                                    <p class="text-xs text-gray-500">
                                        Level
                                    </p>

                                    <p class="font-semibold">
                                        {{ $selectedLog['level'] }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500">
                                        Environment
                                    </p>

                                    <p class="font-semibold">
                                        {{ $selectedLog['environment'] }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500">
                                        Timestamp
                                    </p>

                                    <p class="font-semibold">
                                        {{ $selectedLog['timestamp'] }}
                                    </p>
                                </div>

                            </div>


                            <h3 class="mb-2 font-medium">
                                Message
                            </h3>

                            <pre class="mb-6 overflow-x-auto rounded-lg bg-gray-950 p-4 text-sm text-gray-100">{{ $selectedLog['message'] }}</pre>


                            <h3 class="mb-2 font-medium">
                                Raw Log
                            </h3>

                            <pre class="overflow-x-auto rounded-lg bg-gray-950 p-4 text-sm text-gray-100">{{ $selectedLog['raw'] }}</pre>

                        </div>

                    </div>

                </div>

            @endif


            {{-- Clear Modal --}}
            @if ($showClearModal)

                <div
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                >

                    <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-[#3d3d40]">

                        <h2 class="text-lg font-semibold">
                            Clear Log?
                        </h2>

                        <p class="mt-2 text-sm text-white">
                            This will permanently remove all entries from
                            {{ $date }}.
                            This action cannot be undone.
                        </p>

                        <div class="mt-6 flex justify-end gap-2">
                            <flux:button wire:click="$set('showClearModal', false)" variant="subtle" size="sm">
                                Cancel
                            </flux:button>

                            <flux:button wire:click="clearLog" variant="danger" size="sm">
                                Clear Log
                            </flux:button>

                        </div>

                    </div>

                </div>

            @endif

        </div>
    </x-settings.layout>
</section>
