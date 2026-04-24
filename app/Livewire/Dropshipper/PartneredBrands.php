<?php

namespace App\Livewire\Dropshipper;

use App\Enums\Status;
use App\Models\Brand;
use App\Models\DropshipperApplication;
use App\Models\DropshipperStore;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PartneredBrands extends Component
{
    use Toastable;
    use WithPagination;

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $categoryFilter = '';

    #[Url(history: true)]
    public string $sortBy = 'newest';

    public bool $showApplicationModal = false;

    public ?Brand $selectedBrand = null;

    public string $applicationNotes = '';

    public function render(): View
    {
        $dropshipper = auth()->user()->dropshipper;

        $stores = DropshipperStore::with('brand')
            ->where('dropshipper_id', $dropshipper->id)
            ->where('status', Status::CLONED)
            ->when($this->search, function ($query) {
                return $query->whereHas('brand', function ($q) {
                    $q->where('brand_name', 'like', '%'.$this->search.'%');
                });
            })
            ->paginate(10);

        return view('livewire.dropshipper.partnered-brands', [
            'stores' => $stores,
        ])->layout('layouts.auth')->title('Partnered Brands');
    }
}
