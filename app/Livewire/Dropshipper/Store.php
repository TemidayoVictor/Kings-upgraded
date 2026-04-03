<?php

namespace App\Livewire\Dropshipper;

use App\Actions\CartAction;
use App\DTOs\CartDTO;
use App\Enums\UserType;
use App\Models\DropshipperProduct;
use App\Models\DropshipperStore;
use App\Models\Section;
use App\Traits\Toastable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Store extends Component
{
    use Toastable;
    use WithPagination;

    public DropshipperStore $store;

    public int $brandId;

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

    public bool $stockAlert = false;

    protected $queryString = [
        'selectedSection' => ['except' => 'all'],
        'sortBy' => ['except' => 'newest'],
        'search' => ['except' => ''],
        'priceRange' => ['except' => [0, 100000]],
    ];

    public function mount(DropshipperStore $store): void
    {
        $this->store = $store->load(['brand', 'dropshipper.user']);
        $this->brandId = $store->brand_id;

        // Get min and max prices for this store only (from dropshipper products)
        $this->minPrice = DropshipperProduct::where('dropshipper_store_id', $store->id)
            ->whereHas('originalProduct', function ($q) {
                $q->where('is_active', true)
                    ->where('publish', true);
            })
            ->min('custom_price') ?? 0;

        $this->maxPrice = DropshipperProduct::where('dropshipper_store_id', $store->id)
            ->whereHas('originalProduct', function ($q) {
                $q->where('is_active', true)
                    ->where('publish', true);
            })
            ->max('custom_price') ?? 100000;

        $this->priceRange = [$this->minPrice, $this->maxPrice];
        $this->stockAlert = $this->store->brand->stock_alert;
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
        $buildDto = [
            'productId' => $productId,
            'storeId' => $this->store->id,
            'quantity' => $quantity,
            'stockAlert' => $this->store->brand->stock_alert,
            'type' => UserType::DROPSHIPPER,
        ];

        $dto = CartDTO::fromArray($buildDto);
        try {
            $cartBag = CartAction::execute($dto);
            $this->addedToCart = $productId;
            // Get updated cart count
            $cart = $cartBag['cartBag']->getCart();
            $this->toast('success', $cartBag['productName'].' added to cart!');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function quickView($productId): void
    {
        $this->quickViewProduct = DropshipperProduct::with(['originalProduct.section'])
            ->where('dropshipper_store_id', $this->store->id)
            ->whereHas('originalProduct', function ($q) {
                $q->where('is_active', true)
                    ->where('publish', true);
            })
            ->findOrFail($productId);

        $this->showQuickView = true;
    }

    public function closeQuickView(): void
    {
        $this->showQuickView = false;
        $this->quickViewProduct = null;
    }

    public function getProductsProperty(): LengthAwarePaginator
    {
        $query = DropshipperProduct::with(['originalProduct.section'])
            ->where('dropshipper_store_id', $this->store->id)
            ->whereHas('originalProduct', function ($q) {
                $q->where('is_active', true);
            });

        // Apply section filter
        if ($this->selectedSection !== 'all') {
            $query->whereHas('originalProduct', function ($q) {
                $q->where('section_id', $this->selectedSection);
            });
        }

        // Apply search
        if ($this->search) {
            $query->whereHas('originalProduct', function ($q) {
                $q->where(function ($subQ) {
                    $subQ->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            });
        }

        // Apply price range - using effective price logic
        if ($this->priceRange[0] > 0 || $this->priceRange[1] < 100000) {
            $query->where(function ($q) {
                $q->whereRaw('COALESCE(dropshipper_products.custom_price,
                                   (SELECT dropship_price FROM products WHERE id = dropshipper_products.original_product_id),
                                   (SELECT price FROM products WHERE id = dropshipper_products.original_product_id)) BETWEEN ? AND ?',
                    [$this->priceRange[0], $this->priceRange[1]]);
            });
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'price_low':
                $query->orderByRaw('COALESCE(dropshipper_products.custom_price,
                                   (SELECT dropship_price FROM products WHERE id = dropshipper_products.original_product_id),
                                   (SELECT price FROM products WHERE id = dropshipper_products.original_product_id)) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(dropshipper_products.custom_price,
                                   (SELECT dropship_price FROM products WHERE id = dropshipper_products.original_product_id),
                                   (SELECT price FROM products WHERE id = dropshipper_products.original_product_id)) DESC');
                break;
            case 'newest':
            default:
                $query->whereHas('originalProduct', function ($q) {
                    $q->orderBy('created_at', 'desc');
                });
                break;
        }

        return $query->paginate($this->perPage);
    }

    public function getSectionsProperty(): Collection
    {
        return Section::where('brand_id', $this->brandId)
            ->whereHas('products', function ($query) {
                $query->where('is_active', true);
            })
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name')
            ->get();
    }

    public function getFeaturedProductsProperty(): Collection
    {
        return DropshipperProduct::with('originalProduct')
            ->where('dropshipper_store_id', $this->store->id)
            ->whereHas('originalProduct', function ($q) {
                $q->where('is_active', true)
                    ->where('publish', true)
                    ->where('is_featured', true);
            })
            ->get();
    }

    /**
     * Check if a product is available (active and in stock)
     */
    public function isProductAvailable($product): bool
    {
        return $product->originalProduct &&
            $product->originalProduct->is_active &&
            $product->originalProduct->publish &&
            $product->in_stock;
    }

    public function render()
    {
        return view('livewire.dropshipper.store', [
            'products' => $this->products,
            'sections' => $this->sections,
            'featuredProducts' => $this->featuredProducts,
            'store' => $this->store,
        ])->layout('layouts.store', [
            'store' => $this->store,
        ])->title('Store');
    }
}
