<?php

namespace App\Livewire\Dropshipper;

use App\Models\DropshipperEarning;
use Illuminate\View\View;
use Livewire\Component;

class RevenueGenerated extends Component
{
    public function render():View
    {
        return view('livewire.dropshipper.revenue-generated');
    }
}
