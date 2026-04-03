{{-- resources/views/livewire/dropshipper/store/clone-progress.blade.php --}}
<section class="w-full">
    @include('partials.partnerships')

    <flux:heading class="sr-only">{{ __('Cloning Store') }}</flux:heading>

    <x-dropshippers.layout :heading="__('Cloning Store')" :subheading="$progress['is_complete'] ? __('Store cloned successfully') : __('Please wait . . .')">
        <div class="min-h-screen" wire:poll.3s="checkProgress" @if($progress['is_complete']) wire:poll.stop @endif>
            <div class="max-w-2xl mx-auto py-12">
                <div class="bg-[#3d3d40] rounded-lg shadow-lg p-8">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-white mb-2">Setting Up Your Store</h2>
                        <p class="text-gray-400">We're cloning products from {{ $store->brand->brand_name }}</p>
                    </div>

                    <!-- Progress Circle -->
                    <div class="flex justify-center mb-8">
                        <div class="relative">
                            <svg class="w-32 h-32">
                                <circle class="text-gray-600" stroke-width="4" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64"/>
                                <circle class="text-blue-500 progress-ring" stroke-width="4" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64"
                                        stroke-dasharray="351.86"
                                        stroke-dashoffset="{{ 351.86 * (1 - $progress['percentage'] / 100) }}"
                                        style="transition: stroke-dashoffset 0.5s;"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-2xl font-bold text-white">{{ $progress['percentage'] }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-[#27272a] rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-white">{{ $progress['cloned'] }}</div>
                            <div class="text-xs text-gray-400">Products Cloned</div>
                        </div>
                        <div class="bg-[#27272a] rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-white">{{ $progress['remaining'] }}</div>
                            <div class="text-xs text-gray-400">Remaining</div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex justify-between text-sm text-gray-400 mb-2">
                            <span>Progress</span>
                            <span>{{ $progress['cloned'] }}/{{ $progress['total'] }}</span>
                        </div>
                        <div class="w-full bg-[#27272a] rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500"
                                 style="width: {{ $progress['percentage'] }}%"></div>
                        </div>
                    </div>

                    <!-- Status Messages -->
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            @if($progress['cloned'] > 0)
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-300">Store created successfully</span>
                            @else
                                <svg class="animate-spin h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-gray-300">Creating store structure</span>
                            @endif
                        </div>

                        <div class="flex items-center text-sm">
                            @if($progress['cloned'] > 0)
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-300">Cloning products ({{ $progress['cloned'] }} of {{ $progress['total'] }})</span>
                            @else
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-500">Cloning products</span>
                            @endif
                        </div>

                        <div class="flex items-center text-sm">
                            @if($progress['is_complete'])
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-300">Configuring store settings</span>
                            @else
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-500">Configuring store settings</span>
                            @endif
                        </div>
                    </div>

                    <!-- Complete Button -->
                    @if($progress['is_complete'])
                        <div class="mt-8 text-center">
                            <flux:button href=" {{ route('dropshipper-store', $store)  }} "  variant="primary">
                                Visit Store
                            </flux:button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-dropshippers.layout>
</section>
