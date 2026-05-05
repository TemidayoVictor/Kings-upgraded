<?php

namespace App\Livewire\Brand;

use App\Models\Brand;
use App\Models\Dropshipper;
use App\Models\DropshipperApplication;
use App\DTOs\ApplicationDTO;
use App\Actions\ApplicationAction;
use App\Models\DropshipperStore;
use App\Traits\Toastable;
use App\Enums\Status;
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
        $applications = DropshipperApplication::with(['dropshipper.user'])
            ->where('brand_id', $this->brand->id)
            ->where('status', Status::APPROVED)
            ->orWhere('status', Status::CLONED)
            ->when($this->search, function ($query) {
                return $query->whereHas('dropshipper.user', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%');
                });
            })
            ->get();

        return view('livewire.brand.approved-dropshippers', [
            'approvedDropshippers' => $applications,
        ])->layout('layouts.auth')
            ->title('Dropshippers');
    }
}
