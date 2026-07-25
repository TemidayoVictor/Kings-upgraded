<div>
    <!-- ==================== HERO HEADER ==================== -->
    <header class="bg-premium-dark text-white pt-14 pb-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff01_1px,transparent_1px),linear-gradient(to_bottom,#ffffff01_1px,transparent_1px)] bg-[size:32px_32px]"></div>
        <div class="absolute top-1/2 left-1/3 w-[400px] h-[400px] bg-brand-primary/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-6">
            <div class="space-y-2">
                <span class="text-brand-primary font-bold text-xs uppercase tracking-widest block">
                    Brands
                </span>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight max-w-3xl mx-auto leading-tight">
                    Find Your Favorite Brands
                </h1>

                <p class="text-stone-400 text-sm max-w-xl mx-auto">
                    Search for a brand or browse by category to discover brands available on our platform.
                </p>
            </div>

            <div class="max-w-xl mx-auto pt-2">
                <div class="bg-white p-2 rounded-2xl border border-white/10 shadow-xl flex items-center gap-2">
                    <div class="flex items-center gap-3 pl-3 flex-1">
                        <i class="fas fa-search text-stone-400"></i>
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            placeholder="Search brands..."
                            class="w-full bg-transparent border-none text-sm text-stone-900 placeholder-stone-400 focus:outline-none focus:ring-0"
                        >
                    </div>
                    @if($search || $selectedCategory || $selectedSubcategory)
                        <button
                            wire:click="clearFilters"
                            class="text-stone-400 hover:text-stone-600 transition-colors px-2"
                            title="Clear filters"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                    <button
                        wire:click="$set('search', search)"
                        class="bg-brand-primary hover:bg-amber-400 text-brand-dark font-bold text-sm px-5 py-3 rounded-xl transition">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row gap-12">

            <!-- Sidebar: Categories -->
            <div x-data="{ sidebarOpen: $wire.entangle('sidebarOpen') }"
                 @keydown.escape.window="sidebarOpen = false"
                 class="bg-gray-50/50">

                <!-- Mobile Trigger -->
                <div class="md:hidden sticky top-0 z-40 bg-white/80 backdrop-blur-md px-6 py-4 border-b border-gray-100/80 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-6 bg-brand-primary rounded-full"></div>
                        <span class="font-semibold text-sm text-gray-700 tracking-wide">Browse Categories</span>
                        @if($selectedCategory || $selectedSubcategory)
                            <span class="ml-2 px-2 py-0.5 bg-brand-primary/10 text-brand-primary text-xs rounded-full">
                                Active
                            </span>
                        @endif
                    </div>
                    <button @click="sidebarOpen = true" class="p-2.5 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all duration-200 hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Overlay -->
                <div x-show="sidebarOpen"
                     x-transition:enter="transition-opacity ease-in-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-in-out duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm md:hidden"
                     @click="sidebarOpen = false">
                </div>

                <!-- The Sidebar Container -->
                <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                       class="fixed inset-y-0 left-0 z-50 w-80 bg-white/95 backdrop-blur-xl p-6 transform transition-transform duration-400 ease-[cubic-bezier(0.32,0.72,0,1)] md:static md:translate-x-0 md:w-72 md:block md:backdrop-blur-none md:bg-transparent md:p-0">

                    <div class="md:hidden flex justify-between items-center mb-8">
                        <h2 class="font-semibold text-lg text-brand-primary">Categories</h2>
                        <button @click="sidebarOpen = false" class="p-2 hover:bg-gray-100 rounded-xl transition-all duration-200">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Desktop Header -->
                    <div class="hidden md:block mb-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Categories</h3>
                        <div class="mt-2 h-0.5 w-12 bg-brand-primary rounded-full"></div>
                    </div>

                    <!-- Active Filters Summary -->
                    @if($selectedCategory || $selectedSubcategory)
                        <div class="mb-4 p-3 bg-brand-primary/5 rounded-xl border border-brand-primary/10">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-700">Active filter:</span>
                                <button
                                    wire:click="clearFilters"
                                    class="text-xs text-brand-primary hover:text-brand-dark font-medium transition-colors"
                                >
                                    Clear all
                                </button>
                            </div>
                            @if($selectedSubcategory)
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ \App\Models\Subcategory::find($selectedSubcategory)?->name }}
                                </p>
                            @elseif($selectedCategory)
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ \App\Models\Category::find($selectedCategory)?->name }}
                                </p>
                            @endif
                        </div>
                    @endif

                    <nav class="space-y-1">
                        @forelse($categories as $category)
                            <div x-data="{ active: {{ $selectedCategory == $category->id ? 'true' : 'false' }} }" class="group">
                                <button @click="active = !active; $wire.selectedCategory = active ? {{ $category->id }} : null; $wire.selectedSubcategory = null; $wire.resetPage()"
                                        class="w-full flex justify-between items-center px-4 py-3.5 rounded-xl transition-all duration-200 hover:bg-white/80 hover:shadow-sm group-hover:bg-white/80">
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors duration-200">
                                        {{ $category->name }}
                                        <span class="ml-2 text-xs font-normal text-gray-400">{{ $category->subcategories->count() }}</span>
                                    </span>
                                    <span x-text="active ? '−' : '+'"
                                          class="text-gray-300 text-xl font-light transition-all duration-200 group-hover:text-brand-primary"></span>
                                </button>

                                <div x-show="active"
                                     x-collapse.duration.300ms
                                     class="overflow-hidden">
                                    <ul class="ml-4 pl-4 py-2 space-y-1 border-l-2 border-gray-100/80">
                                        @foreach($category->subcategories as $sub)
                                            <li>
                                                <a href="#"
                                                   wire:click.prevent="filterBySubcategory({{ $sub->id }})"
                                                   class="block px-4 py-2.5 text-sm {{ $selectedSubcategory == $sub->id ? 'text-brand-primary bg-brand-primary/5 font-medium' : 'text-gray-500 hover:text-brand-primary hover:bg-indigo-50/50' }} rounded-lg transition-all duration-200 hover:pl-6">
                                                    {{ $sub->name }}
{{--                                                    <span class="ml-2 text-xs text-gray-400">{{ $sub->brands_count ?? $sub->brands()->count() }}</span>--}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-sm text-gray-400">No categories available</p>
                            </div>
                        @endforelse
                    </nav>

                    <!-- Bottom Decoration -->
                    <div class="hidden md:block mt-8 pt-6 border-t border-gray-100/80">
                        <div class="flex items-center gap-3 text-xs text-gray-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-primary"></span>
                            <span>{{ $categories->count() }} categories available</span>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- Main Content: Brands Grid -->
            <main class="flex-1">
                <!-- Results Count -->
                <div class="flex justify-between items-center mb-6">
                    <p class="text-sm text-gray-500">
                        Showing <span class="font-semibold text-gray-700">{{ $brands->firstItem() ?? 0 }}</span>
                        to <span class="font-semibold text-gray-700">{{ $brands->lastItem() ?? 0 }}</span>
                        of <span class="font-semibold text-gray-700">{{ $brands->total() }}</span> brands
                    </p>
                    @if($search)
                        <p class="text-sm text-gray-400">
                            Results for: "<span class="font-medium text-gray-600">{{ $search }}</span>"
                        </p>
                    @endif
                </div>

                @if($brands->count() > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($brands as $brand)
                            <div class="group relative flex flex-col justify-between bg-white border border-stone-200/60 rounded-2xl overflow-hidden hover:shadow-xl hover:border-amber-200/50 transition-all duration-300">

                                <!-- OPTIONAL: Top accent bar/gradient for visual weight -->
                                <div class="h-2"></div>

                                <div class="p-6">
                                    <!-- Category Tag (If applicable) -->
                                    <div class="mb-4">
                                     <span class="px-2.5 py-0.5 rounded-full bg-stone-100 text-[10px] font-bold uppercase tracking-wider text-stone-500">
                                        {{ $brand->subcategoryModel->name ?? 'General' }}
                                     </span>
                                    </div>

                                    <div class="flex items-center gap-4 mb-5">
                                        @if($brand->image)
                                            <img src="{{ Storage::url($brand->image) }}" alt="{{ $brand->brand_name }}" class="h-14 w-14 rounded-xl object-cover shadow-sm">
                                        @else
                                            <div class="h-14 w-14 rounded-xl flex items-center justify-center bg-stone-100 text-stone-500 text-xl font-bold">
                                                {{ substr($brand->brand_name, 0, 1) }}
                                            </div>
                                        @endif

                                        <div class="min-w-0">
                                            <h3 class="font-bold text-stone-900 text-base leading-tight truncate">{{$brand->brand_name}}</h3>
                                            <p class="text-[11px] text-stone-400 mt-0.5 uppercase tracking-wide font-medium">Verified Brand</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4 text-xs font-medium text-stone-500 py-3 border-y border-stone-100">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fas fa-star text-amber-400"></i>
                                            <span class="text-stone-800">{{$brand->ratings()->avg('rating') > 0 ? number_format($brand->ratings()->avg('rating'), 1) : '0.0'}}</span>
                                        </div>
                                        <div class="w-px h-3 bg-stone-200"></div>
                                        <div><span class="text-stone-800">{{$brand->products->count()}}</span> Product{{$brand->products->count() == 1 ? '' : 's'}} </div>
                                    </div>
                                </div>

                                <div class="p-6 pt-0">
                                    <a href="{{route('shop', $brand)}}" class="block w-full text-center bg-stone-900 text-white font-semibold text-xs py-3 rounded-xl hover:bg-amber-600 transition-colors">
                                        Visit Store
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $brands->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
                        <div class="max-w-md mx-auto text-center py-16 px-4 space-y-6">

                            <!-- Subtle Icon Stack -->
                            <div class="relative w-20 h-20 mx-auto flex items-center justify-center">
                                <!-- Light Decorative Background Glow Layer -->
                                <div class="absolute inset-0 bg-amber-500/5 rounded-full blur-xl"></div>

                                <!-- Central Icon Design -->
                                <div class="relative w-16 h-16 bg-white border border-stone-200/80 rounded-2xl flex items-center justify-center text-stone-400 shadow-sm">
                                    <i class="fas fa-store-slash text-xl text-stone-300"></i>
                                    <!-- Tiny Accent Dot -->
                                    <span class="absolute top-2 right-2 w-2 h-2 bg-brand-primary rounded-full animate-pulse"></span>
                                </div>
                            </div>

                            <!-- Descriptive Text Elements -->
                            <div class="space-y-2">
                                <h3 class="text-lg font-black text-stone-900 tracking-tight">No Brand Found</h3>
                                <p class="text-xs text-brand-muted leading-relaxed max-w-xs mx-auto">
                                    We couldn't find any brands try adjusting your search keywords.
                                </p>
                            </div>

                            <!-- Clean Action Buttons -->
                            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                                <button wire:click="clearFilters" class="w-full sm:w-auto bg-brand-dark hover:bg-stone-800 text-white text-xs font-bold px-5 py-3 rounded-xl transition shadow-sm">
                                    Clear All Filters
                                </button>
                            </div>

                        </div>
                    </div>
                @endif
            </main>

        </div>
    </div>
</div>
