<?php

namespace App\Livewire\Dropshipper;

use App\Actions\ApplicationAction;
use App\DTOs\ApplicationDTO;
use App\Models\DropshipperApplication;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Applications extends Component
{
    use Toastable;
    use WithPagination;

    #[Url(as: 'status', history: true)]
    public string $statusFilter = 'all';

    #[Url(as: 'search', history: true)]
    public string $search = '';

    #[Url(as: 'sort', history: true)]
    public string $sortField = 'applied_date';

    #[Url(as: 'direction', history: true)]
    public string $sortDirection = 'desc';

    public bool $showNotesModal = false;

    public bool $showFeedbackModal = false;

    public ?string $selectedNotes;

    public ?string $selectedFeedback;

    public $selectedReviewedAt;

    public int $selectedId;

    public ?string $selectedStatus;

    public ?string $note;

    protected $queryString = [
        'statusFilter' => ['except' => 'all'],
        'search' => ['except' => ''],
        'sortField' => ['except' => 'applied_date'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function viewNotes($applicationId): void
    {
        $application = DropshipperApplication::find($applicationId);
        $this->selectedId = $applicationId;
        $this->selectedNotes = $application->notes;
        $this->selectedStatus = $application->status;
        $this->showNotesModal = true;
    }

    public function viewFeedback($applicationId): void
    {
        $application = DropshipperApplication::find($applicationId);
        $this->selectedFeedback = $application->notes;
        $this->selectedReviewedAt = $application->reviewed_at;
        $this->selectedId = $applicationId;
        $this->selectedStatus = $application->status;
        $this->showFeedbackModal = true;
    }

    public function reapply(): void
    {
        if (empty($this->note)) {
            $this->toast('error', 'Kindly add an application note.');
            $this->closeModal();

            return;
        }

        $buildDto = [
            'notes' => $this->note,
            'id' => $this->selectedId,
        ];

        $dto = ApplicationDTO::fromArray($buildDto);
        try {
            ApplicationAction::reapply($dto);
            $this->toast('success', 'Application submitted successfully!');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }
    }

    public function closeModal(): void
    {
        $this->showNotesModal = false;
        $this->showFeedbackModal = false;
        $this->selectedNotes = null;
        $this->selectedFeedback = null;
        $this->selectedReviewedAt = null;
    }

    public function render(): View
    {
        $dropshipper = auth()->user()->dropshipper;

        $applications = DropshipperApplication::with(['brand', 'brand.user'])
            ->where('dropshipper_id', $dropshipper->id)
            ->when($this->statusFilter !== 'all', function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->when($this->search, function ($query) {
                return $query->whereHas('brand', function ($q) {
                    $q->where('brand_name', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->sortField === 'brand_name', function ($query) {
                return $query->join('brands', 'dropshipper_applications.brand_id', '=', 'brands.id')
                    ->orderBy('brands.brand_name', $this->sortDirection)
                    ->select('dropshipper_applications.*');
            }, function ($query) {
                return $query->orderBy('created_at', $this->sortDirection);
            })
            ->paginate(10);

        return view('livewire.dropshipper.applications', [
            'applications' => $applications,
        ])->layout('layouts.auth')->title('Dropshipper Applications');
    }
}
