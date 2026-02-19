<?php

namespace App\Livewire\Brand;

use Livewire\Component;

class BrandDashboard extends Component
{
    public function render()
    {
        return view('livewire.brand.brand-dashboard')
            ->layout('layouts.auth')
            ->title('Brandowner Dashboard');
    }
}
