<?php

namespace App\Livewire\Brand;

use App\Actions\SelectRoleAction;
use App\DTOs\GeneralDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;

class AddBrand extends Component
{
    use Toastable;

    public ?int $month;

    public bool $showModal = false;

    public bool $isFree = false;

    public ?string $plan = null;

    public function selectPlan($plan): void
    {
        $this->plan = $plan;
        $this->showModal = true;
    }

    public function freePlan(): void
    {
        $this->plan = Status::PREMIUM;
        $this->isFree = true;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function addBrand(): mixed
    {
        $this->validate([
            'month' => 'required',
        ]);

        $buildDto = [
            'id' => 1,
            'value' => [
                'plan' => $this->plan,
                'month' => $this->month,
            ],
        ];

        return $this->extracted($buildDto);
    }

    public function addBrandFree(): mixed
    {
        if (auth()->user()->role !== UserType::CLIENT) {
            $this->toast('error', 'You are not allowed to add a new free brand.');

            return back();
        }
        $buildDto = [
            'id' => 1,
            'value' => [
                'plan' => $this->plan,
                'month' => 1,
            ],
        ];

        return $this->extracted($buildDto);
    }

    public function extracted(array $buildDto): mixed
    {
        $dto = GeneralDTO::fromArray($buildDto);
        try {
            SelectRoleAction::addBrand($dto);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Brand added successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            return redirect()->route('brand-details');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();

            return back();
        }
    }

    public function render(): View
    {
        return view('livewire.brand.add-brand')
            ->layout('layouts.auth')
            ->title('Add Brand');
    }
}
