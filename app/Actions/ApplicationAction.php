<?php

namespace App\Actions;

use App\DTOs\ApplicationDTO;
use App\Enums\Status;
use App\Mail\DropshipperApplicationMail;
use App\Mail\NotifyDropshipperMail;
use App\Models\Brand;
use App\Models\DropshipperApplication;
use App\Models\DropshipperStore;
use App\Models\Payment;
use App\Services\PaymentProcessorService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class ApplicationAction
{
    /**
     * @throws Exception|Throwable
     */
    public static function execute(ApplicationDTO $dto): DropshipperApplication
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $dropshipper = auth()->user()->dropshipper;
        if (! $dropshipper) {
            throw new Exception('Dropshipper not found.');
        }

        DB::beginTransaction();
        try {
            $application = DropshipperApplication::create([
                'dropshipper_id' => $dropshipper->id,
                'brand_id' => $dto->brandId,
                'notes' => $dto->notes,
                'status' => Status::PENDING,
            ]);

            $brand = Brand::findOrFail($application->brand_id);

            // send email to business owner
            $emailData = [
                'name' => $brand->user->name,
                'subject' => "KING'S Dropshipper Application",
                'dropshipper' => $dropshipper->username,
                'url' => route('brand-pending-applications'),
            ];
            Mail::to($brand->user->email)->send(new DropshipperApplicationMail($emailData));

            DB::commit();

            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to submit application {$e->getMessage()}");
        }

    }

    /**
     * @throws Throwable
     */
    public static function approve(ApplicationDTO $dto): Payment|array
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = auth()->user()->brand;
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        $application = DropshipperApplication::with(['dropshipper.user', 'brand'])->findOrFail($dto->id);
        if (! $application) {
            throw new Exception('Application not found.');
        }

        // check if the addition of this dropshipper should be free or paid
        $check = checkFreeDropshippers($brand->id);
        $amount = $check['freeDropshippersExceeded'] ? generalSetting()->dropshipper_fee : 0;

        $payload = [
            'brand_id' => $brand->id,
            'dropshipper_id' => $application->dropshipper_id,
            'application_id' => $application->id,
            'status' => Status::APPROVED,
            'notes' => $dto->notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'description' => 'add-dropshipper',
        ];

        DB::beginTransaction();
        try {
            // prepare payment
            $txRef = Str::uuid();
            $userId = auth()->user()->id;

            $payment = Payment::where('user_id', $userId)
                ->where('status', Status::PENDING)->first();

            if ($payment) {
                $payment->update([
                    'transaction_ref' => $txRef,
                    'amount' => $amount,
                    'currency' => 'NGN',
                    'action' => 'add_dropshipper',
                    'payload' => $payload,
                ]);
            } else {
                $payment = Payment::create([
                    'user_id' => $userId,
                    'transaction_ref' => $txRef,
                    'amount' => $amount,
                    'currency' => 'NGN',
                    'status' => Status::PENDING,
                    'action' => 'add_dropshipper',
                    'payload' => $payload,
                ]);
            }

            DB::commit();

            // If dropshipper addition should not be free, proceed to payment
            if ($check['freeDropshippersExceeded']) {
                return $payment;
            }

            // else call the processPaymentService
            $paymentProcessor = new PaymentProcessorService;
            $addDropshipper = $paymentProcessor->addDropshipper($payment);
            if ($addDropshipper['status'] === 'success') {
                $payment->update([
                    'status' => 'successful',
                    'transaction_id' => 'FREE',
                    'paid_at' => now(),
                ]);
            }

            return $addDropshipper;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to approve application {$e->getMessage()}");
        }
    }

    /**
     * @throws Throwable
     */
    public static function reject(ApplicationDTO $dto): DropshipperApplication
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = auth()->user()->brand;
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        $application = DropshipperApplication::with(['dropshipper.user', 'brand'])->findOrFail($dto->id);
        if (! $application) {
            throw new Exception('Application not found.');
        }

        DB::beginTransaction();
        try {
            $application->update([
                'status' => Status::REJECTED,
                'notes' => $dto->notes,
                'reviewed_at' => now(),
                'reviewed_by' => auth()->id(),
            ]);

            // send mail to dropshipper
            $emailData = [
                'name' => $application->dropshipper->user->name,
                'subject' => "KING'S Dropshipper Application Notification",
                'type' => 'rejected',
                'brandName' => $brand->brand_name,
                'url' => route('dropshipper-applications'),
            ];
            Mail::to($application->dropshipper->user->email)->send(new NotifyDropshipperMail($emailData));

            DB::commit();

            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to submit application {$e->getMessage()}");
        }
    }

    /**
     * @throws Throwable
     */
    public static function reapply(ApplicationDTO $dto): DropshipperApplication
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $dropshipper = auth()->user()->dropshipper;
        if (! $dropshipper) {
            throw new Exception('Dropshipper not found.');
        }

        $application = DropshipperApplication::with(['dropshipper.user', 'brand'])->findOrFail($dto->id);
        if (! $application) {
            throw new Exception('Application not found.');
        }

        DB::beginTransaction();
        try {
            $application->update([
                'status' => Status::PENDING,
                'notes' => $dto->notes,
            ]);
            DB::commit();

            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to submit application {$e->getMessage()}");
        }
    }

    /**
     * @throws Throwable
     */
    public static function revoke(ApplicationDTO $dto): void
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = auth()->user()->brand;
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        $application = DropshipperApplication::where('dropshipper_id', $dto->dropshipperId)
            ->where('brand_id', $dto->brandId)
            ->with('dropshipper', 'brand')
            ->first();

        if (! $application) {
            throw new Exception('Application not found.');
        }

        DB::beginTransaction();
        try {
            $application->update([
                'status' => Status::REJECTED,
                'notes' => $dto->notes,
            ]);

            $store = DropshipperStore::where('dropshipper_id', $dto->dropshipperId)
                ->where('brand_id', $dto->brandId);
            if ($store) {
                $store->update([
                    'status' => Status::SUSPENDED,
                ]);
            }

            // send mail to dropshipper
            $emailData = [
                'name' => $application->dropshipper->user->name,
                'subject' => "KING'S Dropshipper Application Notification",
                'type' => 'revoked',
                'brandName' => $brand->brand_name,
                'url' => route('dropshipper-applications'),
            ];
            Mail::to($application->dropshipper->user->email)->send(new NotifyDropshipperMail($emailData));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to submit application {$e->getMessage()}");
        }
    }
}
