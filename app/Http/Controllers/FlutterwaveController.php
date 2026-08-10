<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentProcessorService;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlutterwaveController extends Controller
{
    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function callback(Request $request): mixed
    {
        $transactionId = $request['transaction_id'];

        $response = Http::withToken(config('services.flutterwave.secret_key'))
            ->get("https://api.flutterwave.com/v3/transactions/{$transactionId}/verify");

        if (! $response->successful()) {
            throw new Exception('Unable to verify payment with Flutterwave.');
        }

        $response = $response->json();
        Log::info($response);

        // Payment must be successful
        if ($response['status'] !== 'success') {
            throw new Exception($response['message'] ?? 'Payment was not successful.');
        }

        $data = $response['data'];

        // Find the pending payment we created before checkout
        $payment = Payment::where('transaction_ref', $data['tx_ref'])
            ->where('status', 'pending')
            ->firstOrFail();

        // Verify amount
        if ((int) $payment->amount !== (int) $data['amount']) {
            throw new Exception('Payment amount mismatch.');
        }

        // Verify currency
        if ($payment->currency !== $data['currency']) {
            throw new Exception('Payment currency mismatch.');
        }

        // Mark as successful
        $payment->update([
            'status' => 'successful',
            'transaction_id' => $data['id'],
        ]);

        $processor = new PaymentProcessorService;
        $result = $processor->handle($payment);

        return redirect()
            ->route($result['route'], $result['params'] ?? [])
            ->with($result['status'], $result['message']);
    }
}
