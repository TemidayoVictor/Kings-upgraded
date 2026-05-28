<?php

namespace App\Livewire\Admin;

use App\Actions\Brand\AddProductAction;
use App\Actions\Brand\SubscriptionStatusAction;
use App\DTOs\GeneralDTO;
use App\Enums\Status;
use App\Models\Brand;
use App\Traits\Toastable;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class BrandManager extends Component
{
    use Toastable;
    use WithPagination;

    public string $search = '';

    public string $filter = 'all';

    public int $totalBrands = 0;

    public int $activeBrands = 0;

    public int $expiredBrands = 0;

    public int $inactiveBrands = 0;

    public int $newBrands = 0;

    public bool $showModal = false;

    public string $type = '';

    public string $plan = '';

    public int $month = 0;

    public int $additionalProductNumber = 0;

    public int $resolvedPrice = 0;

    public int $total = 0;

    public bool $showTotal = false;

    public ?Brand $selectedBrand = null;

    public function mount(): void
    {
        $this->loadBrandStats();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;

        $this->resetPage();
    }

    public function loadBrandStats(): void
    {
        $this->totalBrands = Brand::count();

        $this->activeBrands = Brand::active()->count();

        $this->expiredBrands = Brand::expired()->count();

        $this->inactiveBrands = Brand::inactive()->count();

        $this->newBrands = Brand::new()->count();
    }

    public function openModal(int $id, string $type): void
    {
        $this->showModal = true;
        $this->type = $type;
        $this->selectedBrand = Brand::findOrfail($id);
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->type = '';
        $this->selectedBrand = null;
        $this->showTotal = false;
        $this->resolvedPrice = 0;
        $this->total = 0;
        $this->month = 0;
        $this->plan = '';
    }

    public function downgrade($brandId): RedirectResponse
    {
        if (! $brandId) {
            $this->toast('error', 'Please select a brand.');
        }

        $buildDTO = [
            'id' => $brandId,
            'value' => [
                'plan' => Status::BASIC,
            ],
        ];

        $dto = GeneralDTO::fromArray($buildDTO);
        try {
            SubscriptionStatusAction::downgrade($dto);
            $this->toast('success', 'Brand downgraded successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }

        return back();
    }

    public function getTotal(): void
    {
        $this->validate([
            'plan' => 'required',
        ]);

        $brand = $this->selectedBrand;
        $this->resolvedPrice = resolvePricing($brand->subscription_status, $this->plan, $this->month, $this->selectedBrand->id);

        if (expiryDate($brand->exp_date)['daysRemaining'] < 1) {
            $this->total = planDetails($this->plan)['fee'] * $this->month;
        } else {
            $this->total = $this->resolvedPrice;
        }
        $this->showTotal = true;
    }

    public function upgrade(): void
    {

        $this->validate([
            'plan' => 'required',
        ]);

        if (! $this->validateAmount()) {
            return;
        }

        $buildDTO = [
            'id' => 1,
            'value' => [
                'plan' => $this->plan,
                'month' => $this->month,
                'brandId' => $this->selectedBrand->id,
            ],
        ];

        $dto = GeneralDTO::fromArray($buildDTO);

        try {
            SubscriptionStatusAction::execute($dto);
            $this->toast('success', 'Subscription upgraded successfully');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }
    }

    public function resubscribe(): void
    {
        $this->validate([
            'month' => 'required|numeric|min:1',
        ]);

        try {
            SubscriptionStatusAction::renew($this->month, $this->selectedBrand->id);
            $this->toast('success', 'Subscription renewed successfully');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }
    }

    public function increase(): RedirectResponse
    {
        $this->validate([
            'additionalProductNumber' => 'required|numeric|min:1',
        ]);

        try {
            AddProductAction::increaseProduct($this->additionalProductNumber, $this->selectedBrand->id);

            $this->toast('success', 'Products capacity increased successfully');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }

        return back();
    }

    public function validateAmount(): bool
    {
        if ($this->resolvedPrice == 0 && $this->month == 0) {
            $this->toast('error', 'Kindly select a subscription duration');
            $this->closeModal();

            return false;
        }

        return true;
    }

    public function render(): View
    {
        $brands = Brand::query()
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('brand_name', 'like', '%'.$this->search.'%')
                        ->orWhere('brand_email', 'like', '%'.$this->search.'%');
                });
            });

        // Apply filter using scopes
        match ($this->filter) {
            'active' => $brands->active(),
            'expired' => $brands->expired(),
            'inactive' => $brands->inactive(),
            'new' => $brands->new(),
            default => null,
        };

        $brands = $brands
            ->latest()
            ->paginate(10);

        return view('livewire.admin.brand-manager', [
            'brands' => $brands,
        ])
            ->layout('layouts.auth')
            ->title('Brands List');
    }
}
