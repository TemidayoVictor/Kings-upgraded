{{-- resources/views/livewire/brand/partials/location-card.blade.php --}}
@props(['location', 'level'])

<div class="p-4 hover:bg-gray-750 transition-colors">
    <div class="flex items-start justify-between" style="margin-left: {{ $level * 16 }}px;">
        <div class="flex items-center space-x-3">
            @if($location->children->count() > 0)
                <button
                    wire:click="toggleExpand({{ $location->id }})"
                    class="text-gray-400 hover:text-gray-200 focus:outline-none"
                >
                    @if(in_array($location->id, $expandedLocations))
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    @endif
                </button>
            @endif

{{--            <div class="flex-shrink-0 h-10 w-10 bg-[#27272a] rounded-full flex items-center justify-center">--}}
{{--                <span class="text-gray-300 font-medium">{{ substr($location->name, 0, 1) }}</span>--}}
{{--            </div>--}}
            <div>
                <div class="font-medium text-gray-200">{{ $location->name }}</div>
                <div class="text-xs text-gray-500">
                    @if($location->delivery_price)
                        ₦{{ number_format($location->delivery_price, 2) }}
                    @else
                        @if($location->parent)
                            <span class="text-gray-400">Inherits: ₦{{ number_format($location->effective_price, 2) }}</span>
                        @else
                            <span class="text-gray-400">Price not set</span>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <button
                wire:click="openCreateModal({{ $location->id }})"
                class="p-2 text-gray-400 hover:text-gray-200 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>
            <button
                wire:click="edit({{ $location->id }})"
                class="p-2 text-gray-400 hover:text-gray-200 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
            <button
                wire:click="confirmDelete({{ $location->id }})"
                class="p-2 text-gray-400 hover:text-red-400 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    </div>

    @if(in_array($location->id, $expandedLocations) && $location->children->count() > 0)
        <div class="mt-2 space-y-2">
            @foreach($location->children as $child)
                @include('livewire.brand.partials.location-card', ['location' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
