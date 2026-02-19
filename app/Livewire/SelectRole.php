<?php

namespace App\Livewire;

use Livewire\Component;

class SelectRole extends Component
{
    public $preferences;
    public string $role;

    public function submit($role) {
        auth()->user()->update([
            'role' => $role,
            'onboarding_step' => 'profile_setup'
        ]);

//        Create role table
        return redirect()->route("dashboard");
    }

    public function render()
    {
        return view('livewire.select-role')
            ->layout('layouts.app')
            ->title('Select Role');
    }
}
