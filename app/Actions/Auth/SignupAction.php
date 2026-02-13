<?php
namespace App\Actions\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\DTOs\Auth\SignupDTO;
use App\Models\User;
use App\Models\VerificationCode;
use App\Mail\VerificationMail;

class SignupAction
{
    public static function execute(SignupDTO $dto): User
    {
        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'email' => $dto->email,
                'password' => Hash::make($dto->password),
                'name' => $dto->name,
            ]);

            // Delete existing verification code if any
            VerificationCode::where('user_id', $user->id)->delete();

            // Create new verification code
            $verificationCode = VerificationCode::create([
                'user_id' => $user->id,
                'code' => rand(100000, 999999),
            ]);

            Log::info('Verification code generated', [
                'user_id' => $user->id,
            ]);

            // Send verification email
            $emailData = [
                'name' => firstName($user->name),
                'code' => $verificationCode->code,
            ];

            Mail::to($user->email)->send(new VerificationMail($emailData));

            DB::commit();

            return $user;

        } catch (Throwable $e) {

            DB::rollBack();

            Log::error('Signup failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e; // Let caller decide how to handle
        }
    }
}
