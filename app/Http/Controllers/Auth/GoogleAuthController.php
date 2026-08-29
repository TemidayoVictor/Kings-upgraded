<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\GoogleLoginAction;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        // for testing locally, use localhost,
        // spin up the local host server like this: php artisan serve --host=localhost --port=8000
        // then try and access the page from localhost:8000/login. Not valet's kings.test
        $googleUser = Socialite::driver('google')->user();
        $user = GoogleLoginAction::execute($googleUser);

        $user->last_login_at = now();
        if ($user->role == UserType::BRAND && ! $user->current_brand_id) {
            $brand = Brand::where('user_id', $user->id)->first();
            $user->current_brand_id = $brand->id;
        }
        $user->save();

        return redirect()->intended('/dashboard');
    }
}
