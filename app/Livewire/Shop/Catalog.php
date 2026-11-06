<?php

namespace App\Livewire\Shop;

use App\Models\Brand;
use App\Models\CatalogItem;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use WithPagination;

    public Brand $brand;

    public function mount(Brand $brand): void
    {
        $this->brand = $brand;
    }

    public function render(): View
    {
        $items = CatalogItem::query()
            ->where('brand_id', $this->brand->id)
            ->latest()
            ->paginate(24);

        return view('livewire.shop.catalog', [
            'items' => $items,
        ])->layout('layouts.shop', [
            'brand' => $this->brand,
        ]);
    }
}
