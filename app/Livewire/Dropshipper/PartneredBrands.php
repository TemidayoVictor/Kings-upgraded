<?php

namespace App\Livewire\Dropshipper;

use App\Enums\Status;
use App\Models\Brand;
use App\Models\DropshipperApplication;
use App\Traits\Toastable;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PartneredBrands extends Component
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
        $dropshipper = auth()->user()->dropshipper;

        DB::beginTransaction();
        try {
            DropshipperApplication::create([
                'dropshipper_id' => $dropshipper->id,
                'brand_id' => $this->selectedBrand->id,
                'notes' => $this->applicationNotes,
                'status' => 'pending',
            ]);

            $this->toast('success', 'Application submitted successfully!');

            $this->closeModal();
            $this->loadApplicationStatuses();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->toast('error', "Failed to submit application {$e->getMessage()}");
        }
    }

    public function closeModal(): void
    {
        $this->showApplicationModal = false;
        $this->selectedBrand = null;
        $this->applicationNotes = '';
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
            ->whereIn('id', $appliedBrandIds)
            ->where('status', Status::APPROVED)
            ->paginate(20);

        return view('livewire.dropshipper.partnered-brands', [
            'brands' => $brands,
        ])->layout('layouts.auth')->title('Browse Brands');
    }
}
