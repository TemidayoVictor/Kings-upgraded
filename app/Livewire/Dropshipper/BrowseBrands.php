<?php

namespace App\Livewire\Dropshipper;

use App\Actions\ApplicationAction;
use App\DTOs\ApplicationDTO;
use App\Models\Brand;
use App\Models\DropshipperApplication;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BrowseBrands extends Component
{
    use Toastable;
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $categoryFilter = '';

    #[Url(history: true)]
    public $sortBy = 'newest';

    public $showApplicationModal = false;

    public $selectedBrand = null;

    public $applicationNotes = '';

    public $applicationStatuses = [];

    public function mount(): void
    {
        $this->loadApplicationStatuses();
    }

    public function loadApplicationStatuses(): void
    {
        $dropshipper = auth()->user()->dropshipper;

        if ($dropshipper) {
            $applications = DropshipperApplication::where('dropshipper_id', $dropshipper->id)
                ->get()
                ->keyBy('brand_id');

            foreach ($applications as $brandId => $application) {
                $this->applicationStatuses[$brandId] = $application->status;
            }
        }
    }

    public function apply($brandId): void
    {
        $this->selectedBrand = Brand::find($brandId);
        $this->showApplicationModal = true;
        $this->applicationNotes = '';
    }

    public function submitApplication(): void
    {
        $buildDto = [
            'brandId' => $this->selectedBrand->id,
            'notes' => $this->applicationNotes,
        ];
        $dto = ApplicationDTO::fromArray($buildDto);
        try {
            ApplicationAction::execute($dto);
            $this->loadApplicationStatuses();
            $this->toast('success', 'Application submitted successfully!');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }
    }

    public function closeModal(): void
    {
        $this->showApplicationModal = false;
        $this->selectedBrand = null;
        $this->applicationNotes = '';
    }

    public function getCategoriesProperty(): array
    {
        return Brand::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->toArray();
    }

    public function render(): View
    {
        $dropshipper = auth()->user()->dropshipper;
        $appliedBrandIds = $dropshipper
            ? DropshipperApplication::where('dropshipper_id', $dropshipper->id)
                ->pluck('brand_id')
                ->toArray()
            : [];

        $brands = Brand::with('user')
            ->whereNotIn('id', $appliedBrandIds)
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('brand_name', 'like', '%'.$this->search.'%')
                        ->orWhere('category', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->categoryFilter, function ($query) {
                return $query->where('category', $this->categoryFilter);
            })
            ->when($this->sortBy, function ($query) {
                return match ($this->sortBy) {
                    'newest' => $query->latest(),
                    'oldest' => $query->oldest(),
                    'name_asc' => $query->orderBy('brand_name', 'asc'),
                    'name_desc' => $query->orderBy('brand_name', 'desc'),
                    'products_high' => $query->orderBy('no_of_products', 'desc'),
                    'products_low' => $query->orderBy('no_of_products', 'asc'),
                    default => $query->latest(),
                };
            })
            ->inRandomOrder()
            ->paginate(20);

        return view('livewire.dropshipper.browse-brands', [
            'brands' => $brands,
            'categories' => $this->categories,
        ])->layout('layouts.auth')->title('Browse Brands');
    }
}
