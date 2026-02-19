<?php

namespace App\Livewire\Dropshipper;

use Livewire\Component;

class DropshipperDashboard extends Component
{
    public function render()
    {
        return view('livewire.dropshipper.dropshipper-dashboard')
            ->layout('layouts.app')
            ->title('Dropshipper Dashboard');
    }
}
