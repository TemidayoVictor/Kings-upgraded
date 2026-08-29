<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Contracts\User as GoogleUser;
use Throwable;

class GoogleLoginAction
{
    /**
     * @throws Throwable
     */
    public static function execute(GoogleUser $googleUser): User
    {
        DB::beginTransaction();

        try {
            $user = User::where('google_id', $googleUser->getId())->first();

            if (! $user) {
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'email_verified_at' => $user->email_verified_at ?? now(),
                    ]);
                } else {
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password' => Hash::make($googleUser->getId()),
                        'onboarding_step' => 'role_selection',
                    ]);
                }
            }

            Auth::login($user, true);

            DB::commit();

            return $user;
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Google login failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new \Exception('Google login failed '.$e->getMessage());
        }
    }
}
