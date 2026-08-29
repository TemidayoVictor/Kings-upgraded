<?php

namespace App\Actions;

use App\DTOs\GeneralDTO;
use App\DTOs\SelectRoleDTO;
use App\Enums\Status;
use App\Enums\UserType;
use App\Mail\WelcomeMail;
use App\Models\Brand;
use App\Models\Payment;
use App\Models\User;
use App\Services\PaymentProcessorService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SelectRoleAction
{
    /**
     * @throws Exception
     */
    public static function execute(SelectRoleDTO $dto): User
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $role = $dto->role;

        if ($user->role && $user->role != UserType::CLIENT) {
            throw new Exception('You already have a role');
        }

        $user->update([
            'role' => $role,
            'onboarding_step' => 'profile_setup',
        ]);

        // Create role table
        if ($role === UserType::BRAND) {
            // Create brand
            $brand = Brand::create([
                'user_id' => $user->id,
                'uuid' => rand(100000, 999999),
                'status' => Status::UNLISTED,
                'subscription_status' => Status::PREMIUM,
                'no_of_products' => generalSetting()->premium_products_number,
                'subscription_amount' => generalSetting()->premium_fee,
                'exp_date' => Carbon::now()->addMonth(),
            ]);
            $user->update([
                'current_brand_id' => $brand->id,
            ]);
        } elseif ($role === UserType::DROPSHIPPER) {
            // Create a dropshipper table
            $user->dropshipper()->create([
                'status' => Status::UNLISTED,
                'subscription_type' => Status::COMMISSION,
            ]);
        }

        // Send welcome email
        $emailData = [
            'name' => firstName($user->name),
            'type' => $role,
            'subject' => "Welcome to KING'S!",
        ];

        Mail::to($user->email)->send(new WelcomeMail($emailData));

        return $user;
    }

    /**
     * @throws Exception
     */
    public static function addBrand(GeneralDTO $dto): Payment|array
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $role = $user->role;

        if ($role === UserType::BRAND && $dto->value['plan'] == Status::BASIC) {
            throw new Exception('You need to subscribe to a paid plan to add multiple brands.');
        }

        $planDetails = planDetails($dto->value['plan']);
        $no_of_products = $planDetails['number'];
        $amount = $planDetails['fee'] * $dto->value['month'];

        $payload = [
            'user_id' => $user->id,
            'subscription_status' => $dto->value['plan'],
            'no_of_products' => $no_of_products,
            'subscription_amount' => $planDetails['fee'],
            'month' => $dto->value['month'],
            'description' => 'New Brand Addition',
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
                    'action' => 'add_brand',
                    'payload' => $payload,
                ]);
            } else {
                $payment = Payment::create([
                    'user_id' => $userId,
                    'transaction_ref' => $txRef,
                    'amount' => $amount,
                    'currency' => 'NGN',
                    'status' => Status::PENDING,
                    'action' => 'add_brand',
                    'payload' => $payload,
                ]);
            }

            DB::commit();

            // check if this is a free brand addition
            $isFree = $dto->value['isFree'];

            // If it should not be free, proceed to payment
            if (! $isFree) {
                return $payment;
            }

            // else call the processPaymentService
            $paymentProcessor = new PaymentProcessorService;
            $addBrand = $paymentProcessor->addBrand($payment);
            if ($addBrand['status'] === 'success') {
                $payment->update([
                    'status' => 'successful',
                    'transaction_id' => 'FREE',
                    'paid_at' => now(),
                ]);
            }

            return $addBrand;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to approve application {$e->getMessage()}");
        }
    }

    /**
     * @throws Exception
     */
    public static function switchAccounts(int $brandId): User
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = Brand::findOrFail($brandId);

        if ($brand->user_id !== $user->id) {
            throw new Exception('You do not have access to this brand.');
        }

        $user->update([
            'current_brand_id' => $brand->id,
        ]);

        return $user;
    }
}
