<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\SendVerificationCodeDTO;
use App\DTOs\Auth\SignupDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SignupAction
{
    public static function execute(SignupDTO $dto): User
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'email' => $dto->email,
                'password' => Hash::make($dto->password),
                'name' => $dto->name,
                'onboarding_step' => 'email_verification',
            ]);

            // Log user in
            Auth::login($user);

            $buildDto = [
                'id' => $user->id,
                'email' => $dto->email,
                'name' => $user->name,
            ];

            $dto = SendVerificationCodeDTO::fromArray($buildDto);
            SendVerificationCodeAction::execute($dto);

            DB::commit();

            return $user;

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Signup failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new \Exception('Signup failed '.$e->getMessage());
        }
    }
}
