<?php
namespace App\Services;

class FlutterwavePaymentService
{
    public function checkoutData(
        float $amount,
        string $txRef,
        array $customer,
        string $description,
        array $meta = []
    ): array {
        return [
            'public_key' => config('services.flutterwave.public_key'),
            'tx_ref' => $txRef,
            'amount' => $amount,
            'currency' => 'NGN',
            'redirect_url' => route('flutterwave.callback'),

            'email' => $customer['email'],
            'phone' => $customer['phone'],
            'name' => $customer['name'],

            'title' => "KING'S",
            'description' => $description,
            'logo' => asset('images/Logo-Crown.svg'),

            'meta' => $meta,
        ];
    }
}
