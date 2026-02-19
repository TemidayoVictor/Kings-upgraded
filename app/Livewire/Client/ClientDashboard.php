<?php

namespace App\Livewire\Client;

use Livewire\Component;

class ClientDashboard extends Component
{
    public function render()
    {
        return view('livewire.client.client-dashboard')
            ->layout('layouts.app')
            ->title('Client Dashboard');
    }
}
