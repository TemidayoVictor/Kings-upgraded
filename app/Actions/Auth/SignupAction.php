<?php
namespace App\Actions\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\DTOs\Auth\SignupDTO;
use App\Models\User;
use App\DTOs\Auth\SendVerificationCodeDTO;
use Illuminate\Support\Facades\Auth;

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

            $buildDto = [
                'id' => $user->id,
                'email' => $dto->email,
                'name' => $user->name,
            ];

            $dto = SendVerificationCodeDTO::fromArray($buildDto);
            SendVerificationCodeAction::execute($dto);

            DB::commit();

//            Log user in
            Auth::login($user);

            return $user;

        } catch(\Throwable $e) {
            DB::rollBack();
            Log::error('Signup failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
