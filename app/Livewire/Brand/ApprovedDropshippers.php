<?php

namespace App\Livewire\Brand;

use App\Models\Brand;
use App\Models\Dropshipper;
use App\Models\DropshipperApplication;
use App\DTOs\ApplicationDTO;
use App\Actions\ApplicationAction;
use App\Models\DropshipperStore;
use App\Traits\Toastable;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ApprovedDropshippers extends Component
{
    use Toastable;
    use WithPagination;

    #[Url(history: true)]
    public $brandFilter = 'all';

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $sortBy = 'recent';

    public Brand $brand;

    public $showDetailsModal = false;

    public $showRevokeModal = false;

    public $selectedDropshipper = null;

    public $selectedBrandId = null;

    public $dropshipperStores = [];

    public $dropshipperStats = [];

    public $revokeReason = '';

    protected $listeners = ['refreshList' => '$refresh'];

    public function viewDetails($dropshipperId): void
    {
        $this->selectedDropshipper = Dropshipper::with('user')->findOrFail($dropshipperId);

        // Get stores for this dropshipper across all brands
        $this->dropshipperStores = DropshipperStore::where('dropshipper_id', $dropshipperId)
            ->where('brand_id', $this->brand->id)
            ->withCount('dropshipperProducts')
            ->get();

        $this->dropshipperStats = [
            'total_stores' => $this->dropshipperStores->count(),
            'active_stores' => $this->dropshipperStores->where('status', 'active')->count(),
            'total_products' => $this->dropshipperStores->sum('dropshipper_products_count'),
        ];

        $this->showDetailsModal = true;
    }

    public function revokeAccess($dropshipperId, $brandId): void
    {
        $this->selectedDropshipper = Dropshipper::findOrFail($dropshipperId);
        $this->selectedBrandId = $brandId;
        $this->revokeReason = '';
        $this->showRevokeModal = true;
    }

    public function confirmRevoke(): void
    {
        $this->validate([
            'revokeReason' => 'required|string|max:500',
        ]);

        $notes = $this->revokeReason.' Revoked on '.now();

        $buildDto = [
            'notes' => $notes,
            'dropshipperId' => $this->selectedDropshipper->id,
            'brandId' => $this->selectedBrandId,
        ];

        $dto = ApplicationDTO::fromArray($buildDto);

        try {
            ApplicationAction::revoke($dto);
            $this->toast('success', 'Access revoked successfully');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }
    }

    public function closeModal(): void
    {
        $this->showDetailsModal = false;
        $this->showRevokeModal = false;
        $this->selectedDropshipper = null;
        $this->selectedBrandId = null;
        $this->dropshipperStores = [];
        $this->dropshipperStats = [];
        $this->revokeReason = '';
    }

    public function render(): View
    {
        $this->brand = auth()->user()->brand;

        // Get all approved applications
        $applications = DropshipperApplication::with(['dropshipper.user', 'brand'])
            ->where('brand_id', $this->brand->id)
            ->where('status', 'approved')
            ->when($this->brandFilter !== 'all', function ($query) {
                return $query->where('brand_id', $this->brandFilter);
            })
            ->when($this->search, function ($query) {
                return $query->whereHas('dropshipper.user', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%');
                });
            })
            ->get();

        // Group by dropshipper
        $grouped = $applications->groupBy('dropshipper_id');

        $approvedDropshippers = $grouped->map(function ($apps, $dropshipperId) {
            $firstApp = $apps->first();
            $brands = $apps->pluck('brand');

            // Get stores for this dropshipper across all approved brands
            $stores = DropshipperStore::where('dropshipper_id', $dropshipperId)
                ->whereIn('brand_id', $apps->pluck('brand_id'))
                ->get();

            return [
                'dropshipper' => $firstApp->dropshipper,
                'brands' => $brands,
                'brand' => $firstApp->brand, // For backward compatibility
                'stores' => $stores,
                'stores_count' => $stores->count(),
                'total_products' => $stores->sum(function ($store) {
                    return $store->dropshipperProducts()->count();
                }),
                'approved_at' => $apps->min('reviewed_at'),
            ];
        })->sortByDesc('approved_at');

        // Apply sorting
        $approvedDropshippers = match ($this->sortBy) {
            'name_asc' => $approvedDropshippers->sortBy('dropshipper.user.name'),
            'name_desc' => $approvedDropshippers->sortByDesc('dropshipper.user.name'),
            'stores' => $approvedDropshippers->sortByDesc('stores_count'),
            default => $approvedDropshippers, // 'recent' is default
        };

        return view('livewire.brand.approved-dropshippers', [
            'approvedDropshippers' => $approvedDropshippers,
        ])->layout('layouts.auth')
            ->title('Dropshippers');
    }
}
