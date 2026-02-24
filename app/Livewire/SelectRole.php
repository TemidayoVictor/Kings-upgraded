<?php

namespace App\Livewire;

use Livewire\Component;
use App\DTOs\SelectRoleDTO;
use App\Actions\SelectRoleAction;
use App\Traits\Toastable;

class SelectRole extends Component
{
    use Toastable;
    public function submit($role) {
        $dto = SelectRoleDTO::fromArray(['role' => $role]);
        try {
            SelectRoleAction::execute($dto);

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Account updated successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            return redirect()->route("settings.profile");
        } catch(\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.select-role')
            ->layout('layouts.app')
            ->title('Select Role');
    }
}
