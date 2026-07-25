<?php

namespace App\Livewire\Dropshipper;

use App\Actions\Dropshipper\SubscriptionsAction;
use App\Enums\Status;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;

class Subscriptions extends Component
{
    use Toastable;

    public int $duration = 1;
    public int $total = 0;

    public function mount(): void
    {
        $this->total = generalSetting()->dropshipper_fee;
    }

    public function submit(string $type): void
    {
        if ($type) {
            try {
                SubscriptionsAction::execute($type);
                $this->toast('success', 'Subscription type updated successfully.!');
            } catch (\Exception $e) {
                $this->toast('error', $e->getMessage());
            }
        } else {
            $this->toast('error', 'Kindly select a valid subscription type.');
        }
    }

    public function renewSubscription(): void
    {
        if ($this->duration) {
            try {
                SubscriptionsAction::renew($this->duration);
                $this->toast('success', 'Subscription renewed successfully.!');
            } catch (\Exception $e) {
                $this->toast('error', $e->getMessage());
            }
        } else {
            $this->toast('error', 'Kindly select a duration.');
        }
    }

    public function updatedDuration($value): void
    {
        $this->total = generalSetting()->dropshipper_fee * $value;
    }

    public function render(): View
    {
        $dropshipper = auth()->user()->dropshipper;
        $isMonthly = $dropshipper->subscription_type === Status::MONTHLY;
        $isCommission = $dropshipper->subscription_type === Status::COMMISSION;
        $isActive = $dropshipper->exp_date && $dropshipper->exp_date->isFuture();

        return view('livewire.dropshipper.subscriptions',
            [
                'dropshipper' => $dropshipper,
                'isMonthly' => $isMonthly,
                'isCommission' => $isCommission,
                'isActive' => $isActive,
            ])->layout('layouts.auth')->title('Revenue Generated');
    }
}
