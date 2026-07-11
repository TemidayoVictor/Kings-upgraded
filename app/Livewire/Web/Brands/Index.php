<?php

namespace App\Livewire\Web\Brands;

use App\Enums\Status;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public ?string $selectedCategory = null;

    public ?string $selectedSubcategory = null;

    public bool $sidebarOpen = false;

    protected array $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => null],
        'selectedSubcategory' => ['except' => null],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function filterBySubcategory($subcategoryId): void
    {
        $this->selectedSubcategory = $subcategoryId;
        $this->selectedCategory = null;
        $this->search = '';
        $this->resetPage();
        $this->sidebarOpen = false; // Close sidebar on mobile
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->selectedCategory = null;
        $this->selectedSubcategory = null;
        $this->resetPage();
    }

    public function getCategoriesProperty(): Collection
    {
        $categoryIds = Brand::where('status', Status::COMPLETED)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        $subCategoryIds = Brand::where('status', Status::COMPLETED)
            ->whereNotNull('sub_category')
            ->distinct()
            ->pluck('sub_category');

        return Category::whereIn('id', $categoryIds)
            ->with([
                'subcategories' => fn ($query) => $query->whereIn('id', $subCategoryIds),
            ])
            ->get()
            ->filter(fn ($category) => $category->subcategories->isNotEmpty());
    }

    public function getBrandsProperty(): LengthAwarePaginator
    {
        return Brand::query()
            ->where('status', Status::COMPLETED) // Only show active brands
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('brand_name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhere('about', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->selectedSubcategory, function ($query) {
                $query->where('sub_category', $this->selectedSubcategory);
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('category', $this->selectedCategory);
            })
            ->paginate(12);
    }

    public function render(): View
    {
        return view('livewire.web.brands.index', [
            'categories' => $this->categories,
            'brands' => $this->brands,
        ]);
    }
}
