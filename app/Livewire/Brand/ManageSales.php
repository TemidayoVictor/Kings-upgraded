<?php

namespace App\Livewire\Brand;

use App\Actions\Brand\SalesAction;
use App\DTOs\GeneralDTO;
use App\Models\Sale;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSales extends Component
{
    use Toastable, WithPagination;

    public $search = '';

    public $status_filter = '';

    public $sort_by = 'created_at';

    public $sort_direction = 'desc';

    public $per_page = 10;

    public ?Sale $selectedSale = null;

    public string $type = '';

    public int $totalRevenue = 0;

    public function mount(): void
    {
        $this->totalRevenue = Sale::where('brand_id', auth()->user()->brand->id)->sum('total_amount');
    }

    public function refreshSales(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->status_filter = '';
        $this->sort_by = 'created_at';
        $this->sort_direction = 'desc';
        $this->per_page = 10;
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sort_by === $field) {
            $this->sort_direction = $this->sort_direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort_by = $field;
            $this->sort_direction = 'asc';
        }
    }

    public function selectSale(Sale $sale, string $type): void
    {
        $this->selectedSale = $sale;
        $this->type = $type;
    }

    public function closeModal(): void
    {
        $this->selectedSale = null;
        $this->type = '';
    }

    public function startSales(): void
    {
        $buildDto = [
            'id' => $this->selectedSale->id,
        ];

        $dto = GeneralDTO::fromArray($buildDto);

        try {
            SalesAction::startSale($dto);
            $this->toast('success', 'Sale started successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
        $this->closeModal();
    }

    public function endSales(): void
    {
        $buildDto = [
            'id' => $this->selectedSale->id,
        ];

        $dto = GeneralDTO::fromArray($buildDto);

        try {
            SalesAction::endSale($dto);
            $this->toast('success', 'Sale ended successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
        $this->closeModal();
    }

    public function getSalesProperty()
    {
        return Sale::where('brand_id', auth()->user()->brand->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->status_filter, function ($query) {
                switch ($this->status_filter) {
                    case 'active':
                        $query->where('is_active', true)
                            ->where('starts_at', '<=', now())
                            ->where('ends_at', '>=', now());
                        break;
                    case 'scheduled':
                        $query->where('is_active', true)
                            ->where('starts_at', '>', now());
                        break;
                    case 'ended':
                        $query->where('ends_at', '<', now());
                        break;
                    case 'inactive':
                        $query->where('is_active', false)
                            ->where('ends_at', '>=', now());
                        break;
                }
            })
            ->orderBy($this->sort_by, $this->sort_direction)
            ->paginate($this->per_page);
    }

    public function getStatusCountsProperty(): array
    {
        $brandId = auth()->user()->brand->id;

        return [
            'all' => Sale::where('brand_id', $brandId)->count(),
            'active' => Sale::where('brand_id', $brandId)
                ->where('is_active', true)
                ->where('ongoing', true)
                ->count(),
            'scheduled' => Sale::where('brand_id', $brandId)
                ->where('is_active', true)
                ->where('starts_at', '>', now())
                ->count(),
            'ended' => Sale::where('brand_id', $brandId)
                ->where('ends_at', '<', now())
                ->count(),
            'inactive' => Sale::where('brand_id', $brandId)
                ->where('is_active', false)
                ->where('ends_at', '>=', now())
                ->count(),
        ];
    }

    public function render(): View
    {
        return view('livewire.brand.manage-sales')->layout('layouts.auth')
            ->title('Manage Sales');
    }
}
