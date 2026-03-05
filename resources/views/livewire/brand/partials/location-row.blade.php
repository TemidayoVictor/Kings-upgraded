{{-- resources/views/livewire/brand/partials/location-row.blade.php --}}
@props(['location', 'level'])

<tr class="hover:bg-gray-750 transition-colors">
    <td class="">
        <div class="flex items-center" style="padding-left: {{ $level * 24 }}px;">
            @if($location->children->count() > 0)
                <button
                    wire:click="toggleExpand({{ $location->id }})"
                    class="mr-2 text-gray-400 hover:text-gray-200 focus:outline-none"
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
            @else
                <div class="w-6"></div>
            @endif

            <div class="flex items-center">
                <div class="flex-shrink-0 h-8 w-8 bg-[#27272a] rounded-full flex items-center justify-center">
                    <span class="text-gray-300 font-medium">{{ substr($location->name, 0, 1) }}</span>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-200">
                        {{ $location->name }}
                    </div>
                    <div class="text-xs text-gray-500">
                        @if($location->children->count() > 0)
                            {{ $location->children->count() }} sub-location{{ $location->children->count() != 1 ? 's' : '' }}
                        @else
                            No sub-locations
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </td>

    <td class="px-6 py-4">
        @if($location->delivery_price)
            <span class="text-sm text-gray-200">₦{{ number_format($location->delivery_price, 2) }}</span>
        @else
            @if($location->parent)
                <span class="text-sm text-gray-400">Inherits: ₦{{ number_format($location->effective_price, 2) }}</span>
            @else
                <span class="text-sm text-gray-400">Not set</span>
            @endif
        @endif
    </td>

    <td class="px-6 py-4 text-right">
        <div class="flex items-center justify-end space-x-3">
            <button
                wire:click="openCreateModal({{ $location->id }})"
                class="text-gray-400 hover:text-gray-200 transition-colors"
                title="Add sub-location"
                type="button"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>

            <button
                wire:click="edit({{ $location->id }})"
                class="text-gray-400 hover:text-gray-200 transition-colors"
                title="Edit location"
                type="button"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>

            <button
                wire:click="confirmDelete({{ $location->id }})"
                class="text-gray-400 hover:text-red-400 transition-colors"
                title="Delete location"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    </td>
</tr>

@if(in_array($location->id, $expandedLocations) && $location->children->count() > 0)
    @foreach($location->children as $child)
        @include('livewire.brand.partials.location-row', ['location' => $child, 'level' => $level + 1])
    @endforeach
@endif
