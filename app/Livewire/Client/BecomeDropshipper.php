<?php

namespace App\Livewire\Client;

use App\Actions\SelectRoleAction;
use App\DTOs\SelectRoleDTO;
use App\Enums\UserType;
use Illuminate\View\View;
use Livewire\Component;

class BecomeDropshipper extends Component
{
    public function render(): View
    {
        return view('livewire.client.become-dropshipper')
            ->layout('layouts.auth')
            ->title('Become a Dropshipper');
    }

    public function submit(): mixed
    {
        $dto = SelectRoleDTO::fromArray(['role' => UserType::DROPSHIPPER]);
        try {
            SelectRoleAction::execute($dto);

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Account updated successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            return redirect()->route('settings.profile');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            return back();
        }
    }
}
