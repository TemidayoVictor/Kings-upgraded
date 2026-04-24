<?php

namespace App\Livewire\Dropshipper;

use App\Actions\Brand\EditProductAction;
use App\Actions\Dropshipper\CloneStoreAction;
use App\DTOs\GeneralDTO;
use App\Models\DropshipperProduct;
use App\Models\DropshipperStore;
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

    public bool $showEditModal = false;

    public string $price = '';

    public string $storeName = '';

    public string $storeSlug = '';

    public bool $isCheckingSlug = false;

    public bool $slugAvailable = true;

    public bool $showEditStoreModal = false;

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
        $this->showEditModal = true;
    }

    public function editStore(): void
    {
        $this->showEditStoreModal = true;
    }

    public function updateProduct(): void
    {
        $this->validate([
            'price' => 'required',
        ]);

        if ($this->price - $this->selectedProduct->originalProduct->dropship_price < 0) {
            $this->toast('error', 'Selling price cannot be less than Dropship price');
            $this->closeModal();

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
            $this->closeModal();
            $this->toast('success', 'Price updated successfully.');
        } catch (\Exception $e) {
            $this->closeModal();
            $this->toast('error', $e->getMessage());
        }

    }

    public function closeModal(): void
    {
        $this->reset(['showEditModal', 'selectedProduct', 'showEditStoreModal']);
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
            CloneStoreAction::editStore($dto);
            $this->closeModal();
            $this->toast('success', 'Store updated successfully.');
        } catch (\Exception $e) {
            $this->closeModal();
            $this->toast('error', $e->getMessage());
        }

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

        return view('livewire.dropshipper.manage-store', [
            'products' => $products,
        ])->layout('layouts.auth')
            ->title('Manage Store');
    }
}
