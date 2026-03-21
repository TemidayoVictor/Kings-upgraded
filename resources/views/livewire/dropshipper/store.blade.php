{{-- resources/views/livewire/dropshipper-store/products.blade.php --}}
<div class="min-h-screen bg-[#f7f5f2]">
    <!-- Store Hero Section -->
    <div class="bg-[#e7dfd7] mx-4 sm:mx-6 lg:mx-8 mt-8 rounded-[32px] p-8 md:p-12 lg:p-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#e7dfd7] to-transparent"></div>
        <div class="relative max-w-2xl">
            <span class="text-sm uppercase tracking-[2px] text-[#6b4f40] mb-4 block">{{ $store->store_name }}</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-light text-[#1e1b1b] leading-tight">
                welcome to <span class="text-[#b55a3b] font-medium">{{ $store->store_name }}</span>
            </h1>
            <p class="text-lg md:text-xl text-[#3f332c] mt-6 max-w-lg">
                curated just for you by {{ $store->dropshipper->user->name }}
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Category Pills -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <button
                wire:click="$set('selectedSection', 'all')"
                class="bg-white border border-[#e5dbd2] rounded-full px-6 py-3 text-sm font-medium text-[#2c2420] hover:border-[#b55a3b] hover:bg-[#fffcf9] transition-all {{ $selectedSection === 'all' ? 'border-[#b55a3b] bg-[#fffcf9]' : '' }}"
            >
                <i class="fa-regular fa-sparkles text-[#b55a3b] mr-2"></i>
                all products
            </button>
            @foreach($sections as $section)
                <button
                    wire:click="$set('selectedSection', {{ $section->id }})"
                    class="bg-white border border-[#e5dbd2] rounded-full px-6 py-3 text-sm font-medium text-[#2c2420] hover:border-[#b55a3b] hover:bg-[#fffcf9] transition-all {{ $selectedSection == $section->id ? 'border-[#b55a3b] bg-[#fffcf9]' : '' }}"
                >
                    <i class="fa-regular fa-tag text-[#b55a3b] mr-2"></i>
                    {{ $section->name }}
                    <span class="ml-2 text-xs text-[#94897f]">({{ $section->products_count }})</span>
                </button>
            @endforeach
        </div>

        <!-- Filters Bar -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">
            <!-- Search -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search products..."
                        class="w-full bg-white text-[#2c2420] rounded-full border border-[#e5dbd2] focus:border-[#b55a3b] focus:ring-0 px-6 py-4 pl-14 transition-all shadow-sm"
                    >
                    <i class="fa-regular fa-magnifying-glass absolute left-5 top-4.5 text-[#94897f]"></i>
                </div>
            </div>

            <!-- Mobile Filters -->
            <div class="flex items-center gap-3 lg:hidden">
                <select
                    wire:model.live="sortBy"
                    class="flex-1 bg-white text-[#2c2420] px-5 py-4 rounded-full border border-[#e5dbd2] focus:ring-0 focus:border-[#b55a3b]"
                >
                    <option value="newest">Newest</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="popular">Most Popular</option>
                </select>
            </div>

            <!-- Desktop Filters -->
            <div class="hidden lg:flex items-center gap-6">
                <!-- Sort Dropdown -->
                <select
                    wire:model.live="sortBy"
                    class="bg-white text-[#2c2420] px-5 py-3 rounded-full border border-[#e5dbd2] focus:ring-0 focus:border-[#b55a3b] text-sm"
                >
                    <option value="newest">Sort by: Newest</option>
                    <option value="price_low">Sort by: Price: Low to High</option>
                    <option value="price_high">Sort by: Price: High to Low</option>
                    <option value="popular">Sort by: Most Popular</option>
                </select>

                <!-- Price Range -->
                <div class="flex items-center gap-3 bg-white px-5 py-2 rounded-full border border-[#e5dbd2]">
                    <span class="text-sm text-[#94897f]">₦{{ number_format($priceRange[0]) }}</span>
                    <input
                        type="range"
                        wire:model.live="priceRange.0"
                        min="{{ $minPrice }}"
                        max="{{ $maxPrice }}"
                        class="w-24 accent-[#b55a3b]"
                    >
                    <input
                        type="range"
                        wire:model.live="priceRange.1"
                        min="{{ $minPrice }}"
                        max="{{ $maxPrice }}"
                        class="w-24 accent-[#b55a3b]"
                    >
                    <span class="text-sm text-[#94897f]">₦{{ number_format($priceRange[1]) }}</span>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
            @forelse($products as $product)
                @php
                    $originalProduct = $product->originalProduct;
                @endphp
                <div
                    wire:key="product-{{ $product->id }}"
                    class="group bg-white rounded-[28px] overflow-hidden card-shadow hover:shadow-xl transition-all duration-500 hover:-translate-y-2 border border-[#f0e8e0]"
                >
                    <!-- Product Image -->
                    <div class="relative aspect-[3/4] bg-[#f8f3ef] p-6 flex items-center justify-center">
                        @if($originalProduct->cover_image)
                            <img
                                src="{{ $originalProduct->thumbnail }}"
                                alt="{{ $originalProduct->name }}"
                                class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-700 drop-shadow-lg"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fa-regular fa-image text-6xl text-[#d4c9c0]"></i>
                            </div>
                        @endif

                        <!-- Quick View Button -->
                        <button
                            wire:click="quickView({{ $product->id }})"
                            class="absolute inset-0 w-full h-full bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                        >
                            <span class="bg-white text-[#2c2420] px-6 py-3 rounded-full text-sm font-medium hover:bg-[#b55a3b] hover:text-white transition-colors shadow-lg">
                                Quick View
                            </span>
                        </button>

                        <!-- Discount Badge (from original product) -->
                        @if($originalProduct->sales_price)
                            <div class="absolute top-4 left-4 bg-[#b55a3b] text-white text-xs font-bold px-4 py-2 rounded-full shadow-md">
                                -{{ round((($originalProduct->price - $originalProduct->sales_price) / $originalProduct->price) * 100) }}%
                            </div>
                        @endif

                        <!-- Store Badge -->
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-[#2c2420] text-xs px-3 py-1.5 rounded-full shadow-md flex items-center gap-1">
                            <i class="fa-regular fa-store text-[#b55a3b]"></i>
                            <span>{{ $store->store_name }}</span>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-5">
                        <div class="text-xs uppercase tracking-wider text-[#b55a3b] mb-2">{{ $originalProduct->section->name ?? 'Uncategorized' }}</div>
                        <h3 class="text-lg font-medium text-[#1e1b1b] mb-2 line-clamp-1">{{ $originalProduct->name }}</h3>

                        <!-- Price -->
                        <div class="flex items-center gap-2 mb-4">
                            @if($originalProduct->sales_price)
                                <span class="text-2xl font-light text-[#2e251f]">₦{{ number_format($originalProduct->sales_price) }}</span>
                                <span class="text-sm text-[#94897f] line-through">₦{{ number_format($originalProduct->price) }}</span>
                            @else
                                <span class="text-2xl font-light text-[#2e251f]">₦{{ number_format($product->effective_price) }}</span>
                            @endif
                        </div>

                        <!-- Add to Cart Button -->
                        <button
                            wire:click="addToCart({{ $product->id }})"
                            wire:loading.attr="disabled"
                            wire:target="addToCart({{ $product->id }})"
                            class="w-full bg-[#f8f3ef] border border-[#e5dbd2] text-[#2c2420] py-3 rounded-full hover:bg-[#b55a3b] hover:text-white hover:border-[#b55a3b] transition-all duration-300 flex items-center justify-center gap-2 group"
                        >
                            <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                Add to Cart
                            </span>
                            <span wire:loading wire:target="addToCart({{ $product->id }})" class="flex items-center gap-2">
                                <i class="fa-regular fa-spinner-third animate-spin"></i>
                                Adding...
                            </span>
                            <i class="fa-regular fa-bag-shopping group-hover:translate-x-1 transition-transform"></i>
                        </button>

                        <!-- Success Indicator -->
                        @if($addedToCart === $product->id)
                            <div class="absolute bottom-5 right-5 bg-green-500 text-white p-3 rounded-full shadow-lg">
                                <i class="fa-regular fa-check"></i>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="bg-white rounded-[32px] p-16 max-w-md mx-auto border border-[#f0e8e0]">
                        <i class="fa-regular fa-face-frown text-6xl text-[#d4c9c0] mb-4"></i>
                        <h3 class="text-2xl font-light text-[#1e1b1b] mb-2">No products found</h3>
                        <p class="text-[#94897f]">Try adjusting your search or filters</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Feature Strip -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 bg-[#eae1d7] rounded-[40px] p-8 md:p-12 border border-[#dfcfc0]">
            <div class="text-center">
                <i class="fa-regular fa-truck text-3xl text-[#b55a3b] mb-3"></i>
                <h4 class="font-medium text-[#241f1b]">fast shipping</h4>
                <p class="text-sm text-[#4c3f37] opacity-80">dispatched within 24h</p>
            </div>
            <div class="text-center">
                <i class="fa-regular fa-shield-check text-3xl text-[#b55a3b] mb-3"></i>
                <h4 class="font-medium text-[#241f1b]">secure checkout</h4>
                <p class="text-sm text-[#4c3f37] opacity-80">100% protected</p>
            </div>
            <div class="text-center">
                <i class="fa-regular fa-rotate-left text-3xl text-[#b55a3b] mb-3"></i>
                <h4 class="font-medium text-[#241f1b]">easy returns</h4>
                <p class="text-sm text-[#4c3f37] opacity-80">30 day guarantee</p>
            </div>
            <div class="text-center">
                <i class="fa-regular fa-headset text-3xl text-[#b55a3b] mb-3"></i>
                <h4 class="font-medium text-[#241f1b]">support</h4>
                <p class="text-sm text-[#4c3f37] opacity-80">24/7 customer care</p>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    @if($showQuickView && $quickViewProduct)
        @php
            $original = $quickViewProduct->originalProduct;
        @endphp
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            x-data
            x-show="$wire.showQuickView"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="$wire.closeQuickView()"
        >
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="$wire.closeQuickView()"></div>

            <!-- Modal Content -->
            <div class="relative bg-white rounded-[32px] max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="grid md:grid-cols-2 gap-8 p-8">
                    <!-- Image -->
                    <div class="aspect-square bg-[#f8f3ef] rounded-2xl overflow-hidden p-8 flex items-center justify-center">
                        @if($original->cover_image)
                            <img src="{{ $original->thumbnail }}" alt="{{ $original->name }}" class="w-full h-full object-contain">
                        @endif
                    </div>

                    <!-- Details -->
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-sm uppercase tracking-wider text-[#b55a3b]">{{ $original->section->name ?? 'Uncategorized' }}</span>
                            <span class="text-xs text-[#94897f]">•</span>
                            <span class="text-xs text-[#94897f]">Sold by {{ $store->store_name }}</span>
                        </div>

                        <h2 class="text-3xl font-light text-[#1e1b1b] mb-4">{{ $original->name }}</h2>

                        <!-- Price -->
                        <div class="flex items-center gap-3 mb-6">
                            @if($original->sales_price)
                                <span class="text-3xl font-light text-[#1e1b1b]">₦{{ number_format($original->sales_price) }}</span>
                                <span class="text-lg text-[#94897f] line-through">₦{{ number_format($original->price) }}</span>
                                <span class="bg-[#b55a3b] text-white text-xs px-3 py-1.5 rounded-full">
                                    -{{ round((($original->price - $original->sales_price) / $original->price) * 100) }}%
                                </span>
                            @else
                                <span class="text-3xl font-light text-[#1e1b1b]">₦{{ number_format($quickViewProduct->effective_price) }}</span>
                            @endif
                        </div>

                        <!-- Description -->
                        <p class="text-[#4c3f37] leading-relaxed mb-8">{{ $original->description }}</p>

                        <!-- Stock Status -->
                        <div class="mb-6">
                            @if($quickViewProduct->in_stock)
                                <span class="text-green-600 text-sm flex items-center gap-2">
                                    <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                                    In Stock
                                </span>
                            @else
                                <span class="text-red-500 text-sm flex items-center gap-2">
                                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        <!-- Add to Cart -->
                        <button
                            wire:click="addToCart({{ $quickViewProduct->id }})"
                            wire:loading.attr="disabled"
                            class="w-full bg-[#b55a3b] text-white py-4 rounded-full hover:bg-[#9e4e33] transition-colors font-medium mt-6 flex items-center justify-center gap-2 shadow-lg"
                        >
                            <span wire:loading.remove wire:target="addToCart({{ $quickViewProduct->id }})">Add to Cart</span>
                            <span wire:loading wire:target="addToCart({{ $quickViewProduct->id }})">Adding...</span>
                            <i class="fa-regular fa-bag-shopping"></i>
                        </button>

                        <!-- Original Brand Info -->
                        <div class="mt-6 pt-6 border-t border-[#e5dbd2]">
                            <p class="text-xs text-[#94897f] flex items-center gap-1">
                                <i class="fa-regular fa-circle-info"></i>
                                Product sourced from <span class="text-[#b55a3b] font-medium">{{ $store->brand->brand_name }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Close Button -->
                <button
                    wire:click="closeQuickView"
                    class="absolute top-4 right-4 text-[#94897f] hover:text-[#b55a3b] transition-colors bg-white/80 backdrop-blur-sm w-10 h-10 rounded-full flex items-center justify-center shadow-md"
                >
                    <i class="fa-regular fa-xmark text-xl"></i>
                </button>
            </div>
        </div>
    @endif
</div>
