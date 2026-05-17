<?php

namespace App\Livewire\Brand;

use App\Models\Brand;
use App\Actions\SelectRoleAction;
use App\Traits\Toastable;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class SwitchAccounts extends Component
{
    use Toastable;

    public Collection $brands;

    public function mount(): void
    {
        $this->brands = Brand::where('user_id', auth()->user()->id)->get();
    }

    public function switch($brandId): mixed
    {
        if ($brandId) {
            try {
                SelectRoleAction::switchAccounts($brandId);
                session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Account switched successfully',
                    'title' => 'Success',
                    'duration' => 5000,
                ]);

                return redirect()->route('brand-dashboard');
            } catch (\Exception $e) {
                $this->toast('error', $e->getMessage());

                return back();
            }
        }

        return back();
    }

    public function render(): View
    {
        return view('livewire.brand.switch-accounts')
            ->layout('layouts.auth')
            ->title('Switch Accounts');
    }
}
