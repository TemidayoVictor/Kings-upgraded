<?php

namespace App\Livewire\Auth;

use App\Enums\UserType;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function login()
    {
        $this->validate();

        if (! Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials.',
            ]);
        }

        request()->session()->regenerate();

        $user = auth()->user();
        $user->last_login_at = now();

        if ($user->role == UserType::BRAND && ! $user->current_brand_id) {
            $brand = Brand::where('user_id', $user->id)->first();
            $user->current_brand_id = $brand->id;
        }

        $user->save();

        return redirect()->intended('/dashboard');
    }

    public function render(): View
    {
        return view('livewire.auth.login')
            ->layout('layouts.app')
            ->title('Log in');
    }
}
