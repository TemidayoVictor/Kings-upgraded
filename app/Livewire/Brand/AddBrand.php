<?php

namespace App\Livewire\Brand;

use App\Actions\SelectRoleAction;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;

class AddBrand extends Component
{
    use Toastable;

    public function addBrand($plan): mixed
    {
        try {
            SelectRoleAction::addBrand($plan);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Brand added successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            return redirect()->route('brand-details');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());

            return back();
        }
    }

    public function render(): View
    {
        return view('livewire.brand.add-brand')
            ->layout('layouts.auth')
            ->title('Add Brand');
    }
}
