<?php

namespace App\Livewire\Shop;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Section;
use App\Services\CartService;
use App\Traits\Toastable;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    use Toastable;

    public Brand $brand;

    // Filters
    public $selectedSection = 'all';

    public $sortBy = 'newest';

    public $priceRange = [0, 100000];

    public $minPrice = 0;

    public $maxPrice = 100000;

    public $search = '';

    // UI State
    public $quickViewProduct = null;

    public $showQuickView = false;

    public $addedToCart = false;

    public $perPage = 12;

    protected $queryString = [
        'selectedSection' => ['except' => 'all'],
        'sortBy' => ['except' => 'newest'],
        'search' => ['except' => ''],
        'priceRange' => ['except' => [0, 100000]],
    ];

    public function mount(Brand $brand)
    {
        $this->brand = $brand;

        // Set brand in session for CartService
        session(['current_brand_id' => $brand->id]);
        session(['current_brand_slug' => $brand->slug]);

        // Get min and max prices for this brand only
        $this->minPrice = Product::where('brand_id', $brand->id)
            ->where('is_active', true)
            ->min('price') ?? 0;

        $this->maxPrice = Product::where('brand_id', $brand->id)
            ->where('is_active', true)
            ->max('price') ?? 100000;

        $this->priceRange = [$this->minPrice, $this->maxPrice];
    }

    public function updatedSelectedSection(): void
    {
        $this->resetPage();
    }

    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPriceRange(): void
    {
        $this->resetPage();
    }

    public function addToCart($productId, $quantity = 1): void
    {
        try {
            // Verify product belongs to this brand
            $product = Product::where('id', $productId)
                ->where('brand_id', $this->brand->id)
                ->firstOrFail();

            $cartBag = new CartService($this->brand->id);
            $cartBag->addItem($productId, $quantity);

            $this->addedToCart = $productId;

            // Get updated cart count
            $cart = $cartBag->getCart();

            // Dispatch events
            $this->dispatch('cartUpdated', count: $cart->item_count);
            $this->dispatch('added-to-cart', productId: $productId);

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => $product->name.' added to cart!',
            ]);

        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function quickView($productId): void
    {
        $this->quickViewProduct = Product::with('section')
            ->where('brand_id', $this->brand->id)
            ->findOrFail($productId);

        $this->showQuickView = true;
    }

    public function closeQuickView(): void
    {
        $this->showQuickView = false;
        $this->quickViewProduct = null;
    }

    public function getProductsProperty()
    {
        $query = Product::query()
            ->where('brand_id', $this->brand->id)
            ->where('is_active', true);

        // Apply section filter
        if ($this->selectedSection !== 'all') {
            $query->where('section_id', $this->selectedSection);
        }

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            });
        }

        // Apply price range
        $query->whereBetween('price', [
            $this->priceRange[0],
            $this->priceRange[1],
        ]);

        // Apply sorting
        switch ($this->sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                // You'll need a 'views' or 'sales_count' column
                $query->orderBy('views', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->paginate($this->perPage);
    }

    public function getSectionsProperty()
    {
        return Section::where('brand_id', $this->brand->id)
            ->whereHas('products', function ($query) {
                $query->where('is_active', true);
            })
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name')
            ->get();
    }

    public function getFeaturedProductsProperty()
    {
        return Product::where('brand_id', $this->brand->id)
            ->where('is_active', true)
            ->where('is_featured', true)
            ->limit(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.shop.products', [
            'products' => $this->products,
            'sections' => $this->sections,
            'featuredProducts' => $this->featuredProducts,
            'brand' => $this->brand,
        ])->layout('layouts.shop', [
            'brand' => $this->brand,
        ]);
    }
}
