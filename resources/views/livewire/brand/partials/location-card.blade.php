{{-- resources/views/livewire/brand/partials/location-card.blade.php --}}

<div class="p-4 hover:bg-gray-750 transition-colors">
    <div
        class="flex items-start justify-between"
        style="margin-left: {{ $level * 16 }}px;"
    >
        <div class="flex items-center space-x-3">

            @if($location->children->count() > 0)
                <button
                    type="button"
                    x-on:click="toggleExpand({{ $location->id }})"
                    class="text-gray-400 hover:text-gray-200 focus:outline-none"
                    :aria-expanded="expandedLocations[{{ $location->id }}] ? 'true' : 'false'"
                    aria-label="Toggle {{ $location->name }}"
                >
                    {{-- Right arrow - collapsed --}}
                    <svg
                        x-show="!expandedLocations[{{ $location->id }}]"
                        x-cloak
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"
                        />
                    </svg>

                    {{-- Down arrow - expanded --}}
                    <svg
                        x-show="expandedLocations[{{ $location->id }}]"
                        x-cloak
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </button>
            @endif

            <div>
                <div class="font-medium text-gray-200">
                    {{ $location->name }}
                </div>

                <div class="text-xs text-gray-500">
                    @if($location->delivery_price)
                        ₦{{ number_format($location->delivery_price, 2) }}
                    @elseif($location->parent)
                        <span class="text-gray-400">
                            Inherits: ₦{{ number_format($location->effective_price, 2) }}
                        </span>
                    @else
                        <span class="text-gray-400">
                            Price not set
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-2">

            {{-- Add sub-location --}}
            <button
                type="button"
                x-on:click="openSubLocation(
                    {{ $location->id }},
                    @js($location->name),
                    {{ $location->delivery_price ?? 0 }}
                )"
                class="p-2 text-gray-400 hover:text-gray-200 transition-colors"
                title="Add sub-location"
            >
                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    />
                </svg>
            </button>

            {{-- Edit --}}
            <button
                type="button"
                x-on:click="openEdit({{ $location->id }})"
                class="p-2 text-gray-400 hover:text-gray-200 transition-colors"
                title="Edit location"
            >
                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                    />
                </svg>
            </button>

            {{-- Delete --}}
            <button
                type="button"
                x-on:click="openDelete(
                    {{ $location->id }},
                    @js($location->name)
                )"
                class="p-2 text-gray-400 hover:text-red-400 transition-colors"
                title="Delete location"
            >
                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    />
                </svg>
            </button>

        </div>
    </div>

    {{-- Children --}}
    @if($location->children->count() > 0)
        <div
            x-show="expandedLocations[{{ $location->id }}]"
            x-cloak
            class="mt-2 space-y-2"
        >
            @foreach($location->children as $child)
                @include(
                    'livewire.brand.partials.location-card',
                    [
                        'location' => $child,
                        'level' => $level + 1
                    ]
                )
            @endforeach
        </div>
    @endif
</div>
