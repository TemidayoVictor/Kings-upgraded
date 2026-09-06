<?php

namespace App\Livewire\Dropshipper;

use App\Actions\Brand\EditProductAction;
use App\Actions\Dropshipper\CloneStoreAction;
use App\DTOs\GeneralDTO;
use App\Enums\Status;
use App\Models\DropshipperProduct;
use App\Models\DropshipperStore;
use App\Models\Product;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ManageStore extends Component
{
    use Toastable;
    use WithPagination;

    public ?DropshipperProduct $selectedProduct = null;

    public ?DropshipperStore $store = null;

    public string $search = '';

    public string $price = '';

    public string $storeName = '';

    public string $storeSlug = '';

    public bool $isCheckingSlug = false;

    public bool $slugAvailable = true;

    public int $perPage = 15;

    public function mount($store): void
    {
        $this->store = $store;
        $this->storeName = $store->store_name;
        $this->storeSlug = $store->slug;
    }

    public function editProduct(DropshipperProduct $product): void
    {
        $this->selectedProduct = $product;
        $this->price = $product->custom_price;
        $this->dispatch('loaded-product');
    }

    public function updateProduct(): void
    {
        $this->validate([
            'price' => 'required',
        ]);

        if ($this->price - $this->selectedProduct->originalProduct->dropship_price < 0) {
            $this->toast('error', 'Selling price cannot be less than Dropship price');
            $this->dispatch('close-modal');
            return;
        }

        $buildDto = [
            'id' => $this->selectedProduct->id,
            'value' => [
                'custom_price' => $this->price,
                'profit' => $this->price - $this->selectedProduct->originalProduct->dropship_price,
            ],
        ];

        $dto = GeneralDTO::fromArray($buildDto);
        try {
            EditProductAction::editPrice($dto);
            $this->toast('success', 'Price updated successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }

        $this->dispatch('close-modal');
    }

    public function updatedStoreName(): void
    {
        $this->resetErrorBag();
        $this->isCheckingSlug = true;
        $check = generateStoreSlug($this->storeName);
        if ($check['exists'] && ($check['storeSlug'] == $this->storeSlug)) {
            $this->slugAvailable = false;
        } else {
            $this->storeSlug = $check['storeSlug'];
            $this->slugAvailable = true;
        }
        $this->isCheckingSlug = false;
    }

    public function updateStore(): void
    {
        $this->validate([
            'storeName' => 'required',
            'storeSlug' => 'required',
        ]);

        $buildDto = [
            'id' => $this->store->id,
            'value' => [
                'store_name' => $this->storeName,
                'slug' => $this->storeSlug,
            ],
        ];

        $dto = GeneralDTO::fromArray($buildDto);
        try {
            $store = CloneStoreAction::editStore($dto);
            // update the new store with the new value
            $this->store = $store;
            $this->toast('success', 'Store updated successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }

        $this->dispatch('close-modal');
    }

    public function updateNewProducts(): void
    {
        try {
            CloneStoreAction::updateNewProducts($this->store->id);
            $this->toast('success', 'Products added successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
        $this->dispatch('close-modal');
    }

    public function closeModal(): void
    {
        $this->reset(['showEditModal', 'selectedProduct', 'showEditStoreModal', 'showNewProducts']);
    }

    public function render(): View
    {
        $products = DropshipperProduct::query()
            ->with('originalProduct.images')
            ->where('dropshipper_store_id', $this->store->id)
            ->whereHas('originalProduct', function ($q) {
                $q->where('is_active', true);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('originalProduct', function ($q) {
                    $q->where(function ($subQ) {
                        $subQ->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('description', 'like', '%'.$this->search.'%');
                    });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $newProducts = Product::query()
            ->where('brand_id', $this->store->brand_id)
            ->where('status', Status::ACTIVE)
            ->whereDoesntHave('dropshipperProducts', function ($query) {
                $query->where('dropshipper_store_id', $this->store->id);
            })
            ->get();

        return view('livewire.dropshipper.manage-store', [
            'products' => $products,
            'newProducts' => $newProducts,
        ])->layout('layouts.auth')
            ->title('Manage Store');
    }
}
