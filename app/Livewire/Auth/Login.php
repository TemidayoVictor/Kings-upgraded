<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.app')
            ->title('Log in');
    }
}
