<?php

namespace App\Livewire\Brand\Product;

use Illuminate\View\View;
use Livewire\WithPagination;
use App\Traits\Toastable;

use Livewire\Component;
use App\Models\Product;
use App\DTOs\GeneralDTO;
use App\Actions\Brand\DeleteProductAction;

class ProductList extends Component
{
    use WithPagination;
    use Toastable;

    public Product $selectedProduct;
    public string $search = '';
    public int $perPage = 2;
    public bool $showDeleteModal = false;
    public int $productId;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(Product $product): void
    {
        $this->selectedProduct = $product;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        $buildDTO = [
            'id' => $this->selectedProduct->id,
        ];
        $dto = GeneralDTO::fromArray($buildDTO);
        try {
            DeleteProductAction::execute($dto);
            $this->closeModal();
            $this->toast('success','Product deleted successfully.');
        } catch(\Exception $e) {
            $this->closeModal();
            $this->toast('error',$e->getMessage());
        }
    }

    public function closeModal(): void
    {
        $this->reset(['showDeleteModal', 'selectedProduct']);
    }

    public function render(): View
    {
        $products = Product::query()
            ->with('images')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.brand.product.product-list', [
            'products' => $products
        ])
        ->layout('layouts.auth')
        ->title('Products');
    }
}
