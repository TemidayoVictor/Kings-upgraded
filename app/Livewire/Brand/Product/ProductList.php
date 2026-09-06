<?php

namespace App\Livewire\Brand\Product;

use App\Actions\Brand\DeleteProductAction;
use App\DTOs\GeneralDTO;
use App\Models\Product;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use Toastable;
    use WithPagination;

    public Product $selectedProduct;

    public string $search = '';

    public int $perPage = 15;

    public int $productId;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete($productId): void
    {
        $buildDTO = [
            'id' => $productId,
        ];
        $dto = GeneralDTO::fromArray($buildDTO);
        try {
            DeleteProductAction::execute($dto);
            $this->toast('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }

        $this->dispatch('product-deleted');
    }

    public function render(): View
    {
        $brandId = auth()->user()->brand->id;
        $products = Product::query()
            ->with('images')
            ->where('brand_id', $brandId)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.brand.product.product-list', [
            'products' => $products,
        ])
            ->layout('layouts.auth')
            ->title('Products');
    }
}
