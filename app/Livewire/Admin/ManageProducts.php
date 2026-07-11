<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ManageProducts extends Component
{
    use Toastable;
    use WithPagination;

    public string $search = '';

    public string $filter = 'all';

    public int $totalProducts = 0;

    public int $activeProducts = 0;

    public int $featuredProducts = 0;

    public int $inactiveProducts = 0;

    public int $outOfStockProducts = 0;

    public bool $showModal = false;

    public string $type = '';

    public ?Product $selectedProduct = null;

    public bool $featured = false;

    public function mount(): void
    {
        $this->loadProductStats();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function loadProductStats(): void
    {
        $this->totalProducts = Product::count();
        $this->activeProducts = Product::where('is_active', true)->count();
        $this->featuredProducts = Product::where('is_featured', true)->count();
        $this->inactiveProducts = Product::where('is_active', false)->count();
        $this->outOfStockProducts = Product::where('stock', '<=', 0)->count();
    }

    public function openModal(int $id, string $type): void
    {
        $this->showModal = true;
        $this->type = $type;
        $this->selectedProduct = Product::with('brand')->findOrFail($id);

        if ($type === 'feature') {
            $this->featured = $this->selectedProduct->is_featured ?? false;
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->type = '';
        $this->selectedProduct = null;
        $this->featured = false;
    }

    public function toggleFeature(): void
    {
        if (! $this->selectedProduct) {
            $this->toast('error', 'No product selected.');

            return;
        }

        try {
            $this->selectedProduct->update([
                'is_featured' => ! $this->selectedProduct->is_featured,
            ]);

            $status = $this->selectedProduct->is_featured ? 'featured' : 'unfeatured';
            $this->toast('success', "Product {$status} successfully.");
            $this->closeModal();
            $this->loadProductStats();
        } catch (\Exception $e) {
            $this->toast('error', 'Failed to update product status: '.$e->getMessage());
            $this->closeModal();
        }
    }

    public function toggleActive(int $productId): void
    {
        try {
            $product = Product::findOrFail($productId);
            $product->update([
                'is_active' => ! $product->is_active,
            ]);

            $status = $product->is_active ? 'activated' : 'deactivated';
            $this->toast('success', "Product {$status} successfully.");
            $this->loadProductStats();
        } catch (\Exception $e) {
            $this->toast('error', 'Failed to update product status: '.$e->getMessage());
        }
    }

    public function render(): View
    {
        $products = Product::query()
            ->with('brand')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhereHas('brand', function ($brandQuery) {
                            $brandQuery->where('brand_name', 'like', '%'.$this->search.'%');
                        });
                });
            });

        // Apply filters
        match ($this->filter) {
            'active' => $products->where('is_active', true),
            'featured' => $products->where('is_featured', true),
            'inactive' => $products->where('is_active', false),
            'out_of_stock' => $products->where('stock', '<=', 0),
            default => null,
        };

        $products = $products
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manage-products', [
            'products' => $products,
        ])->layout('layouts.auth')
            ->title('Manage Products');
    }
}
