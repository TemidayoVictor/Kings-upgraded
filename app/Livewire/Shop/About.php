<?php

namespace App\Livewire\Shop;

use App\Models\Brand;
use Illuminate\View\View;
use Livewire\Component;

class About extends Component
{
    public Brand $brand;

    public function mount(Brand $brand): void
    {
        $this->brand = $brand;
    }

    public function render(): View
    {
        return view('livewire.shop.about')->layout('layouts.shop', [
            'brand' => $this->brand,
        ]);
    }
}
