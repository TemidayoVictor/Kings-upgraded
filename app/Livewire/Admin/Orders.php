<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Illuminate\View\View;
use Livewire\Component;

class Orders extends Component
{
    public function render(): View
    {
        return view('livewire.admin.orders');
    }
}
