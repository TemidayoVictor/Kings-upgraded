<?php

namespace App\Livewire\Brand;

use App\Actions\SelectRoleAction;
use App\DTOs\GeneralDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Payment;
use App\Services\FlutterwavePaymentService;
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
        $this->isFree = false;
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
                'isFree' => false,
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
                'isFree' => true,
            ],
        ];

        return $this->extracted($buildDto);
    }

    public function extracted(array $buildDto): mixed
    {
        $dto = GeneralDTO::fromArray($buildDto);
        try {
            $payment = SelectRoleAction::addBrand($dto);
            if (isset($payment['status']) && $payment['status'] === 'success') {
                // this means that it was a free addition
                session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Brand added successfully',
                    'title' => 'Success',
                    'duration' => 5000,
                ]);

                return redirect()->route('settings.profile');
            } else {
                $this->triggerPayment($payment);
            }
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();

            return back();
        }

        return back();
    }

    public function triggerPayment(Payment $payment): void
    {
        $this->toast('success', 'Loading Payment Gateway. . .');
        $flutterwavePaymentService = new FlutterwavePaymentService;
        $this->makePayment($flutterwavePaymentService, $payment);
        $this->closeModal();
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
        return view('livewire.brand.add-brand')
            ->layout('layouts.auth')
            ->title('Add Brand');
    }
}
