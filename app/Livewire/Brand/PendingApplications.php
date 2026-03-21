<?php

namespace App\Livewire\Brand;

use App\Actions\ApplicationAction;
use App\DTOs\ApplicationDTO;
use App\Models\Brand;
use App\Models\DropshipperApplication;
use App\Traits\Toastable;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class PendingApplications extends Component
{
    use Toastable;
    use WithPagination;

    #[Url(history: true)]
    public $selectedBrand = 'all';

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $sortField = 'applied_date';

    #[Url(history: true)]
    public $sortDirection = 'desc';

    public Brand $brand;

    public $showReviewModal = false;

    public $showQuickRejectModal = false;

    public $selectedApplication = null;

    public $reviewNotes = '';

    public $rejectReason = '';

    protected $listeners = ['refreshApplications' => '$refresh'];

    public function getBrandsProperty()
    {
        return auth()->user()->brands;
    }

    public function setBrand($brandId): void
    {
        $this->selectedBrand = $brandId;
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function viewApplication($applicationId): void
    {
        $this->selectedApplication = DropshipperApplication::with(['dropshipper.user', 'brand'])
            ->findOrFail($applicationId);
        $this->reviewNotes = '';
        $this->showReviewModal = true;
    }

    public function quickReject($applicationId): void
    {
        $this->selectedApplication = DropshipperApplication::findOrFail($applicationId);
        $this->rejectReason = '';
        $this->showQuickRejectModal = true;
    }

    /**
     * @throws Throwable
     */
    public function approveApplication(): void
    {
        if (! $this->selectedApplication) {
            return;
        }

        $this->validate([
            'reviewNotes' => 'nullable|string|max:500',
        ]);

        $buildDto = [
            'id' => $this->selectedApplication->id,
            'notes' => $this->reviewNotes ?: $this->selectedApplication->notes,
        ];

        $dto = ApplicationDTO::fromArray($buildDto);

        try {
            ApplicationAction::approve($dto);
            $this->toast('success', 'Application approved successfully');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }
    }

    /**
     * @throws Throwable
     */
    public function rejectApplication(): void
    {
        if (! $this->selectedApplication) {
            return;
        }

        $this->validate([
            'reviewNotes' => 'required|string|max:500',
        ]);

        $buildDto = [
            'id' => $this->selectedApplication->id,
            'notes' => $this->reviewNotes,
        ];

        $dto = ApplicationDTO::fromArray($buildDto);

        try {
            ApplicationAction::reject($dto);
            $this->toast('success', 'Application rejected successfully');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }
    }

    public function submitQuickReject(): void
    {
        $this->validate([
            'rejectReason' => 'required|string|max:500',
        ]);

        $buildDto = [
            'id' => $this->selectedApplication->id,
            'notes' => $this->rejectReason,
        ];

        $dto = ApplicationDTO::fromArray($buildDto);

        try {
            ApplicationAction::reject($dto);
            $this->toast('success', 'Application rejected successfully');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }
    }

    public function closeModal(): void
    {
        $this->showReviewModal = false;
        $this->showQuickRejectModal = false;
        $this->selectedApplication = null;
        $this->reviewNotes = '';
        $this->rejectReason = '';
    }

    public function render(): View
    {
        $this->brand = auth()->user()->brand;

        $applications = DropshipperApplication::with(['dropshipper.user', 'brand'])
            ->where('brand_id', $this->brand->id)
            ->where('status', 'pending')
            ->when($this->search, function ($query) {
                return $query->whereHas('dropshipper.user', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                })->orWhereHas('brand', function ($q) {
                    $q->where('brand_name', 'like', '%'.$this->search.'%');
                });
            })
            ->paginate(10);

        return view('livewire.brand.pending-applications', [
            'applications' => $applications,
            'brands' => $this->brands,
        ])->layout('layouts.auth')
            ->title('Pending Applications');
    }
}
