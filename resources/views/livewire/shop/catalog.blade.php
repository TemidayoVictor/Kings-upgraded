
<div>
    @php
        $totalCount = $items->total();
        $firstNumber = $items->firstItem() ?? 0;
        $lastNumber = $items->lastItem() ?? 0;

        $aspectRatios = ['3/4', '1/1', '4/5', '3/4', '4/3', '3/4', '1/1', '4/5'];

        $brandName = $brand->brand_name ?? 'This Brand';

        $lightboxData = $items->values()->map(fn ($item) => [
            'image' => asset('storage/' . $item->image_path),
            'title' => $item->original_name ?? 'Catalog Image',
            'origin' => $brandName,
        ])->all();
    @endphp

    <div x-data="{
            lightboxOpen: false,
            currentIndex: 0,
            items: @js($lightboxData),

            openLightbox(idx) {
                this.currentIndex = idx;
                this.lightboxOpen = true;
                document.body.style.overflow = 'hidden';
            },

            closeLightbox() {
                this.lightboxOpen = false;
                document.body.style.overflow = '';
            },

            next() {
                this.currentIndex = (this.currentIndex + 1) % Math.max(1, this.items.length);
            },

            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.items.length) % Math.max(1, this.items.length);
            }
        }"
         @keydown.escape.window="lightboxOpen && closeLightbox()"
         @keydown.arrow-right.window="lightboxOpen && next()"
         @keydown.arrow-left.window="lightboxOpen && prev()">

        {{-- ==================== INTRO HEADER ==================== --}}
        <section class="w-full px-4 sm:px-8 pt-4 pb-6">
            <div class="max-w-7xl mx-auto flex flex-col gap-5">

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <h1 class="font-editorial text-[32px] sm:text-[48px] leading-tight sm:leading-[56px] tracking-tight text-[var(--on-surface)] font-normal">
                            Catalog
                        </h1>
                    </div>
                </div>

            </div>
        </section>

        @if($items->isEmpty())

            {{-- ==================== EMPTY STATE ==================== --}}
            <section class="w-full px-4 sm:px-8 py-16">
                <div class="max-w-3xl mx-auto bg-[var(--surface-lowest)] rounded-xl p-10 sm:p-16 text-center shadow-sm flex flex-col items-center">

                    <div class="w-20 h-24 bg-[var(--surface-low)] rounded-lg flex items-center justify-center mb-6 shadow-inner relative overflow-hidden">
                        <div class="absolute inset-2 rounded bg-[var(--surface-lowest)] flex items-center justify-center">
                            <span class="material-symbols-outlined text-[28px] text-[var(--outline)]">
                                photo_library
                            </span>
                        </div>
                    </div>

                    <span class="text-[10px] uppercase tracking-[0.24em] text-[var(--secondary)] font-semibold mb-2">
                        Brand Showcase
                    </span>

                    <h2 class="font-editorial text-[28px] leading-9 text-[var(--on-surface)] mb-3 font-normal">
                        This Catalog Is Coming Soon
                    </h2>

                    <p class="text-[15px] leading-6 text-[var(--on-surface-variant)] max-w-lg mb-8 font-light">
                        {{ $brandName }} hasn't added any catalog images yet.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('shop', $brand) }}"
                           class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[var(--primary)] hover:bg-[var(--secondary)] text-white text-xs font-semibold transition-all active:scale-[0.98] cursor-pointer shadow-md">
                            Explore Brand Store
                        </a>
                    </div>

                </div>
            </section>

        @else

            {{-- ==================== MASONRY GRID ==================== --}}
            <section class="w-full px-4 sm:px-8 pb-12">
                <div class="max-w-7xl mx-auto">

                    <div id="catalog-grid" class="columns-2 md:columns-3 lg:columns-4 xl:columns-5 gap-3 lg:gap-4">

                        @foreach($items as $index => $item)

                            @php
                                $plateNumber = $firstNumber + $index;
                                $displayNumber = str_pad($plateNumber, 2, '0', STR_PAD_LEFT);
                                $aspect = $aspectRatios[$index % count($aspectRatios)];

                                $imageUrl = asset('storage/' . $item->image_path)
                            @endphp

                            <figure
                                class="break-inside-avoid mb-3 lg:mb-4 group relative overflow-hidden rounded-xl cursor-pointer bg-[var(--surface-container)] shadow-sm"
                                @click="openLightbox({{ $index }})"
                                wire:key="catalog-item-{{ $item->id }}">

                                <div class="relative w-full overflow-hidden" style="aspect-ratio: {{ $aspect }};">

                                    @if($imageUrl)
                                        <img
                                            src="{{ $imageUrl }}"
                                            alt="{{ $item->original_name ?? 'Catalog image ' . $displayNumber }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                        />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[var(--outline)]">
                                            <span class="material-symbols-outlined text-[32px]">
                                                image_not_supported
                                            </span>
                                        </div>
                                    @endif

                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">

                                        <span class="text-white text-[10px] uppercase tracking-[0.22em] font-semibold text-[var(--secondary-container)]">
                                            Image {{ $displayNumber }}/{{ $totalCount }}
                                        </span>

                                        <p class="text-white text-[13px] leading-5 font-light truncate">
                                            {{ $item->original_name ?? 'Catalog Image' }}
                                        </p>

                                    </div>

                                    <div class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-[var(--on-surface)]">
                                        <span class="material-symbols-outlined text-[16px]">
                                            fullscreen
                                        </span>
                                    </div>

                                </div>
                            </figure>

                        @endforeach

                    </div>

                    {{-- ==================== PAGINATION ==================== --}}
                    @if($items->hasPages())

                        @php
                            $current = $items->currentPage();
                            $last = $items->lastPage();
                            $windowStart = max(1, $current - 2);
                            $windowEnd = min($last, $current + 2);
                        @endphp

                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 pb-12">

                            <div class="text-[10px] uppercase tracking-[0.22em] font-semibold text-[var(--on-surface-variant)]">
                                Showing
                                <span class="text-[var(--on-surface)]">{{ $firstNumber }} – {{ $lastNumber }}</span>
                                of {{ $totalCount }} Catalog Images
                            </div>

                            <nav class="flex items-center gap-1.5">

                                @if($items->onFirstPage())
                                    <span class="w-9 h-9 rounded-full flex items-center justify-center text-[var(--on-surface-variant)] opacity-40 cursor-not-allowed">
                                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                    </span>
                                @else
                                    <button wire:click="previousPage" aria-label="Previous"
                                            class="w-9 h-9 rounded-full flex items-center justify-center text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] hover:bg-[var(--surface-container)] transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                    </button>
                                @endif

                                @if($windowStart > 1)
                                    <button wire:click="gotoPage(1)"
                                            class="w-9 h-9 rounded-full text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] hover:bg-[var(--surface-container)] text-[10px] font-semibold flex items-center justify-center transition-colors">
                                        1
                                    </button>

                                    @if($windowStart > 2)
                                        <span class="w-7 text-center text-[10px] font-semibold text-[var(--outline-variant)]">…</span>
                                    @endif
                                @endif

                                @for($page = $windowStart; $page <= $windowEnd; $page++)

                                    @if($page == $current)
                                        <span class="w-9 h-9 rounded-full bg-[var(--primary)] text-[var(--on-primary)] text-[10px] font-semibold flex items-center justify-center">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})"
                                                class="w-9 h-9 rounded-full text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] hover:bg-[var(--surface-container)] text-[10px] font-semibold flex items-center justify-center transition-colors">
                                            {{ $page }}
                                        </button>
                                    @endif

                                @endfor

                                @if($windowEnd < $last)

                                    @if($windowEnd < $last - 1)
                                        <span class="w-7 text-center text-[10px] font-semibold text-[var(--outline-variant)]">…</span>
                                    @endif

                                    <button wire:click="gotoPage({{ $last }})"
                                            class="w-9 h-9 rounded-full text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] hover:bg-[var(--surface-container)] text-[10px] font-semibold flex items-center justify-center transition-colors">
                                        {{ $last }}
                                    </button>

                                @endif

                                @if($items->hasMorePages())
                                    <button wire:click="nextPage" aria-label="Next"
                                            class="w-9 h-9 rounded-full flex items-center justify-center text-[var(--on-surface-variant)] hover:text-[var(--on-surface)] hover:bg-[var(--surface-container)] transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                    </button>
                                @else
                                    <span class="w-9 h-9 rounded-full flex items-center justify-center text-[var(--on-surface-variant)] opacity-40 cursor-not-allowed">
                                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                    </span>
                                @endif

                            </nav>
                        </div>

                    @else

                        <div class="text-center pt-4 pb-12 text-[10px] uppercase tracking-[0.22em] font-semibold text-[var(--on-surface-variant)]">
                            Showing all {{ $totalCount }} Catalog Images
                        </div>

                    @endif

                </div>
            </section>

        @endif

        {{-- ==================== LIGHTBOX ==================== --}}
        <div
            x-show="lightboxOpen"
            x-cloak
            x-transition.opacity.duration.300ms
            class="fixed inset-0 z-[60] bg-black/85 backdrop-blur-md flex flex-col justify-between p-4 sm:p-8"
            style="display: none;"
            @click.self="closeLightbox()">

            {{-- Top bar --}}
            <div class="w-full max-w-7xl mx-auto flex items-center justify-between text-white pt-2">

                <div class="flex items-center gap-3">

                    <span
                        class="text-[10px] uppercase tracking-[0.22em] font-semibold text-[var(--secondary-container)] bg-white/10 px-3 py-1 rounded-full"
                        x-text="'Image ' + String(currentIndex + {{ $firstNumber }}).padStart(2, '0') + ' of ' + String({{ $totalCount }}).padStart(2, '0')">
                    </span>

                    <span class="text-[var(--outline)] hidden sm:inline">•</span>

                    <span class="text-[10px] uppercase tracking-[0.22em] font-semibold text-[var(--outline)] hidden sm:inline">
                        KING'S BRAND CATALOG
                    </span>

                </div>

                <div class="flex items-center gap-4">

                    <span class="text-[10px] uppercase tracking-[0.22em] font-semibold text-[var(--outline)] hidden md:inline">
                        ← → keys • Esc to close
                    </span>

                    <button
                        @click="closeLightbox()"
                        aria-label="Close"
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>

                </div>
            </div>

            {{-- Image stage --}}
            <div class="relative w-full flex-1 flex items-center justify-center my-4 overflow-hidden">

                <button
                    @click.stop="prev()"
                    aria-label="Previous"
                    class="absolute left-2 sm:left-6 z-10 w-12 h-12 rounded-full bg-black/40 hover:bg-black/70 text-white backdrop-blur-sm flex items-center justify-center transition-all -translate-y-1/2 top-1/2 group">
                    <span class="material-symbols-outlined text-[24px] group-hover:-translate-x-0.5 transition-transform">
                        arrow_back
                    </span>
                </button>

                <div class="max-w-5xl max-h-[768px] sm:max-h-[839px] flex items-center justify-center px-4">

                    <template x-if="items.length && items[currentIndex] && items[currentIndex].image">
                        <img
                            :src="items[currentIndex].image"
                            :alt="items[currentIndex].title"
                            class="max-h-[768px] sm:max-h-[839px] w-auto max-w-full object-contain rounded shadow-2xl transition-opacity duration-300"
                        />
                    </template>

                </div>

                <button
                    @click.stop="next()"
                    aria-label="Next"
                    class="absolute right-2 sm:right-6 z-10 w-12 h-12 rounded-full bg-black/40 hover:bg-black/70 text-white backdrop-blur-sm flex items-center justify-center transition-all -translate-y-1/2 top-1/2 group">
                    <span class="material-symbols-outlined text-[24px] group-hover:translate-x-0.5 transition-transform">
                        arrow_forward
                    </span>
                </button>

            </div>

            {{-- Bottom caption --}}
            <div class="w-full max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between text-white pb-2 gap-2 text-center sm:text-left">

                <div>
                    <p
                        class="text-[15px] leading-6 text-white font-medium"
                        x-text="items[currentIndex]?.title || ''">
                    </p>

                    <span class="text-[10px] uppercase tracking-[0.22em] font-semibold text-[var(--outline)]">
                        DISCOVERED ON KING'S • {{ $brandName }}
                    </span>
                </div>

                <div class="flex items-center gap-3">

                    <a
                        href="{{ route('shop', $brand) }}"
                        class="text-[10px] uppercase tracking-[0.22em] font-semibold text-[var(--secondary-container)] hover:text-white transition-colors flex items-center gap-1.5 bg-white/5 px-3 py-1.5 rounded">

                        <span class="material-symbols-outlined text-[14px]">storefront</span>

                        <span>Explore Brand Store</span>

                    </a>

                </div>

            </div>

        </div>

        {{-- Runtime class injection for Tailwind's arbitrary var() values --}}
        <style>
            .bg-surface {
                background-color: var(--surface);
            }

            .bg-surface-low {
                background-color: var(--surface-low);
            }

            .bg-surface-lowest {
                background-color: var(--surface-lowest);
            }

            .bg-surface-container {
                background-color: var(--surface-container);
            }

            .bg-surface-high {
                background-color: var(--surface-high);
            }

            .bg-primary {
                background-color: var(--primary);
            }

            .bg-secondary-container {
                background-color: var(--secondary-container);
            }

            .text-on-surface {
                color: var(--on-surface);
            }

            .text-on-surface-variant {
                color: var(--on-surface-variant);
            }

            .text-on-primary {
                color: var(--on-primary);
            }

            .text-outline {
                color: var(--outline);
            }

            .text-outline-variant {
                color: var(--outline-variant);
            }

            .text-secondary {
                color: var(--secondary);
            }
        </style>

    </div>
</div>
