<?php

namespace App\Livewire\Brand;

use App\Actions\Brand\AddProductAction;
use App\Actions\Brand\SubscriptionStatusAction;
use App\DTOs\GeneralDTO;
use App\Models\Brand;
use App\Traits\Toastable;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class SubscriptionStatus extends Component
{
    use Toastable;

    public bool $showModal = false;

    public string $type = '';

    public ?string $plan = null;

    public ?int $month = 0;

    public ?int $additionalProductNumber;

    public int $resolvedPrice = 0;

    public int $total = 0;

    public bool $showTotal = false;

    public function getRemainingDaysAttribute(): array
    {
        $expiryDate = Carbon::parse($this->exp_date);
        $now = Carbon::now();

        if ($now->greaterThan($expiryDate)) {
            return [
                'days' => 0,
                'text' => 'Expired',
                'color' => 'red',
                'class' => 'text-red-600 bg-red-50 dark:bg-red-900/20 dark:text-red-400',
            ];
        }

        $daysRemaining = (int) $now->diffInDays($expiryDate);

        if ($daysRemaining >= 10) {
            return [
                'days' => $daysRemaining,
                'text' => $daysRemaining.' days remaining',
                'color' => 'green',
                'class' => 'text-green-600 bg-green-50 dark:bg-green-900/20 dark:text-green-400',
            ];
        } elseif ($daysRemaining >= 5) {
            return [
                'days' => $daysRemaining,
                'text' => $daysRemaining.' days remaining',
                'color' => 'yellow',
                'class' => 'text-yellow-600 bg-yellow-50 dark:bg-yellow-900/20 dark:text-yellow-400',
            ];
        } else {
            return [
                'days' => $daysRemaining,
                'text' => $daysRemaining.' days remaining',
                'color' => 'red',
                'class' => 'text-red-600 bg-red-50 dark:bg-red-900/20 dark:text-red-400',
            ];
        }
    }

    public function displayModal($type, $plan = null): void
    {
        $this->showModal = true;
        $this->type = $type;
        $this->plan = $plan;

        if ($plan) {
            $this->resolvedPrice = resolvePricing(auth()->user()->brand->subscription_status, $plan);
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->type = '';
    }

    public function renewSubscription(): void
    {
        $this->validate([
            'month' => 'required',
        ]);

        try {
            SubscriptionStatusAction::renew($this->month);
            $this->toast('success', 'Subscription renewed successfully');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }

    }

    public function upgradePlan(): void
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

    public function increaseProducts(): mixed
    {
        $this->validate([
            'additionalProductNumber' => 'integer|required',
        ]);

        try {
            AddProductAction::increaseProduct($this->additionalProductNumber);

            $this->toast('success', 'Products capacity increased successfully');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }

        return back();
    }

    public function getTotal(): void
    {
        if (! $this->validateAmount()) {
            return;
        }

        $brand = auth()->user()->brand;

        if (expiryDate($brand->exp_date)['daysRemaining'] < 1) {
            $this->total = planDetails($this->plan)['fee'] * $this->month;
        } else {
            $this->total = resolvePricing($brand->subscription_status, $this->plan, $this->month);
        }
        $this->showTotal = true;
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
        $brand = Brand::where('id', auth()->user()->brand->id)->with('products')->first();

        return view('livewire.brand.subscription-status', [
            'brand' => $brand,
        ])
            ->layout('layouts.auth')
            ->title('Subscription Status');
    }
}
