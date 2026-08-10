<?php

namespace App\Livewire\Dropshipper;

use App\Actions\Dropshipper\SubscriptionsAction;
use App\Enums\Status;
use App\Models\Payment;
use App\Services\FlutterwavePaymentService;
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

        // notification once payment is successful or fails
        if (session('success')) {
            $this->toast('success', session('success'));
        }

        if (session('error')) {
            $this->toast('error', session('error'));
        }
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
                $payment = SubscriptionsAction::renew($this->duration);
                $this->triggerPayment($payment);
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

    public function triggerPayment(Payment $payment): void
    {
        $this->toast('success', 'Loading Payment Gateway. . .');
        $flutterwavePaymentService = new FlutterwavePaymentService;
        $this->makePayment($flutterwavePaymentService, $payment);
    }

    public function makePayment(FlutterwavePaymentService $flutterwave, Payment $payment): void
    {
        $this->dispatch(
            'flutterwave-payment',
            $flutterwave->checkoutData(
                amount: $payment->amount,
                txRef: $payment->transaction_ref,
                customer: [
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->phone,
                    'name' => auth()->user()->name,
                ],
                description: $payment->payload['description'],
            )
        );
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
