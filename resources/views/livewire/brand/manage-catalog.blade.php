
<section class="w-full">

    @include('partials.products-heading')

    <flux:heading class="sr-only">
        {{ __('Catalog') }}
    </flux:heading>

    <x-products.layout
        :heading="__('Catalog')"
        :subheading="__('Showcase multiple products at once without creating individual product listings')"
    >

        <div class="space-y-6">

            {{-- ==================== SUCCESS MESSAGE ==================== --}}
            @if (session()->has('catalog_message'))
                <flux:callout
                    icon="check-circle"
                    color="green"
                    class="mb-5"
                >
                    {{ session('catalog_message') }}
                </flux:callout>
            @endif


            {{-- ==================== UPLOAD SECTION ==================== --}}
            <flux:fieldset>

                <div class="space-y-6">

                    <div>
                        {{-- Multiple file input --}}
                        <div class="flex items-center justify-center w-full mt-2">

                            <label
                                for="catalog-upload"
                                class="flex flex-col items-center justify-center w-full min-h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer transition-colors"
                            >

                                <div class="flex flex-col items-center justify-center py-7 px-4 text-center">

                                    <svg
                                        class="w-9 h-9 mb-4 text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 20 16"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                                        />
                                    </svg>

                                    <p class="mb-2 text-sm text-white">
                                        <span class="font-semibold text-[#e9a35d]">
                                            Click to upload
                                        </span>
                                        or drag and drop
                                    </p>

                                    <p class="text-xs text-gray-300">
                                        Select multiple images at once
                                    </p>

                                    <p class="mt-2 text-xs text-gray-400">
                                        JPG, JPEG, PNG, WEBP or GIF
                                        (Max 10MB per image)
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        Videos and unsupported files will automatically be skipped.
                                    </p>

                                </div>

                                <input
                                    id="catalog-upload"
                                    type="file"
                                    multiple
                                    accept="image/*,video/*"
                                    class="hidden"
                                    x-on:change="
                                        const selected = Array.from($event.target.files || []);

                                        const images = selected.filter(file =>
                                            file.type.startsWith('image/')
                                        );

                                        const skipped = selected.length - images.length;

                                        if (skipped > 0) {
                                            $wire.addSkippedFiles(skipped);
                                        }

                                        if (images.length > 0) {
                                            $wire.uploadMultiple(
                                                'photos',
                                                images,
                                                () => {},
                                                (error) => {
                                                    console.error(error);
                                                },
                                                (event) => {
                                                    progress = event.detail.progress;
                                                }
                                            );
                                        }

                                        $event.target.value = '';
                                    "
                                />

                            </label>

                        </div>


                        {{-- Loading indicator --}}
                        <div
                            wire:loading
                            wire:target="photos"
                            class="mt-4 p-4 rounded-lg bg-[#3d3d40]"
                        >
                            <div class="flex items-center space-x-3">

                                <svg
                                    class="animate-spin h-5 w-5 text-[#e9a35d]"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>

                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>

                                <span class="text-sm text-gray-200">
                                    <i>Processing selected images...</i>
                                </span>

                            </div>
                        </div>


                        {{-- Validation errors --}}
                        <flux:error name="photos" />

                    </div>


                    {{-- ==================== SELECTED PHOTOS ==================== --}}
                    @if ($photos && count($photos) > 0)

                        <div class="mb-6">

                            <div class="flex justify-between items-center mb-3">

                                <flux:subheading>
                                    Selected Photos ({{ count($photos) }})
                                </flux:subheading>

                                <button
                                    type="button"
                                    wire:click="$set('photos', [])"
                                    class="text-sm text-orange-500 hover:text-red-500 transition"
                                >
                                    Clear all
                                </button>

                            </div>


                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                                @foreach ($photos as $index => $photo)

                                    <div
                                        class="relative group"
                                        wire:key="catalog-preview-{{ $index }}"
                                    >

                                        {{-- Image Preview --}}
                                        <div class="relative aspect-square rounded-lg overflow-hidden border-2 border-gray-700 group-hover:border-[#e9a35d] transition-all bg-[#3d3d40]">

                                            <img
                                                src="{{ $photo->temporaryUrl() }}"
                                                alt="Preview {{ $index + 1 }}"
                                                class="w-full h-full object-cover"
                                                loading="lazy"
                                            >

                                            {{-- File info overlay --}}
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">

                                                <div class="text-white text-xs text-center px-2 break-all">

                                                    <div>
                                                        {{ $photo->getClientOriginalName() }}
                                                    </div>

                                                    <div class="mt-1">
                                                        {{ round($photo->getSize() / 1024) }} KB
                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        {{-- Index badge --}}
                                        <span class="absolute -top-2 -left-2 bg-white text-black text-xs rounded-full w-6 h-6 flex items-center justify-center shadow-lg">
                                            {{ $index + 1 }}
                                        </span>

                                    </div>

                                @endforeach

                            </div>


                            {{-- Upload action --}}
                            <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                                <p class="text-xs text-gray-400">
                                    Your selected images will be added to your public catalog.
                                </p>

                                <flux:button
                                    type="button"
                                    variant="primary"
                                    size="sm"
                                    wire:click="save"
                                    wire:loading.attr="disabled"
                                    wire:target="save,photos"
                                >

                                    <flux:icon.loading
                                        wire:loading
                                        wire:target="save"
                                    />

                                    <span wire:loading.remove wire:target="save">
                                        Upload {{ count($photos) }} Images
                                    </span>

                                    <span wire:loading wire:target="save">
                                        Processing...
                                    </span>

                                </flux:button>

                            </div>

                        </div>

                    @endif


                    {{-- Skipped files --}}
                    @if ($skippedFiles > 0)

                        <flux:callout
                            icon="information-circle"
                            color="yellow"
                        >
                            {{ $skippedFiles }}
                            unsupported file(s) will be skipped.
                            Your valid images can still be uploaded.
                        </flux:callout>

                    @endif

                </div>

            </flux:fieldset>


            {{-- ==================== SEPARATOR ==================== --}}
            <flux:separator />


            {{-- ==================== EXISTING CATALOG ==================== --}}
            <div class="space-y-5">

                {{-- Section heading --}}
                <div class="w-full">
                    <flux:input
                        type="search"
                        wire:model.live.debounce.400ms="search"
                        placeholder="Search by image filename..."
                        icon="magnifying-glass"
                    />
                </div>

                {{-- Catalog images --}}
                @if ($items->count() > 0)

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                        @foreach ($items as $item)

                            <div
                                class="relative group rounded-lg overflow-hidden border border-gray-700 bg-[#27272a]"
                                wire:key="catalog-item-{{ $item->id }}"
                            >

                                {{-- Image --}}
                                <div class="aspect-square overflow-hidden">

                                    <img
                                        src="{{ asset('storage/' . $item->image_path) }}"
                                        alt="{{ $item->original_name ?? 'Catalog image' }}"
                                        loading="lazy"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                    />

                                </div>


                                {{-- Image information --}}
                                <div class="p-3">

                                    <p class="text-xs text-gray-300 truncate">
                                        {{ $item->original_name ?? 'Catalog image' }}
                                    </p>

                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $item->created_at->format('M d, Y') }}
                                    </p>

                                </div>


                                {{-- Delete button --}}
                                <button
                                    type="button"
                                    wire:click="delete({{ $item->id }})"
                                    wire:confirm="Are you sure you want to delete this catalog image?"
                                    wire:loading.attr="disabled"
                                    class="absolute top-2 right-2 bg-black/70 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 shadow-lg transition-all opacity-100 sm:opacity-0 sm:group-hover:opacity-100"
                                    title="Delete image"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        />
                                    </svg>

                                </button>

                            </div>

                        @endforeach

                    </div>


                    {{-- ==================== PAGINATION ==================== --}}
                    <div class="pt-4">
                        {{ $items->onEachSide(1)->links() }}
                    </div>


                @else

                    {{-- Empty state --}}
                    <div class="rounded-lg border border-gray-700 border-dashed bg-[#27272a] px-5 py-16 text-center">

                        <div class="flex justify-center">

                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-[#3d3d40]">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-8 w-8 text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 16.5V6.75A2.25 2.25 0 015.25 4.5h13.5A2.25 2.25 0 0121 6.75v10.5a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 17.25v-.75z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 15l5.25-5.25a2.25 2.25 0 013.182 0L16.5 14.25m-2.25-2.25l1.318-1.318a2.25 2.25 0 013.182 0L21 12.75"
                                    />
                                </svg>

                            </div>

                        </div>


                        <h3 class="mt-4 text-base font-semibold text-white">
                            No Catalog Images Found
                        </h3>

                        <p class="mx-auto mt-2 max-w-sm text-sm text-gray-400">
                            Your catalog is currently empty.
                            Upload multiple product images above to start showcasing
                            your products to customers.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </x-products.layout>

</section>
