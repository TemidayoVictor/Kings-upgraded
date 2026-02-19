<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Livewire\Component;
use App\DTOs\ProfileSettingsDTO;
use App\Actions\ProfileSettingsAction;
use App\Traits\Toastable;

class ProfileSettings extends Component
{
    use Toastable;
    public string $name;
    public string $email;
    public string $phone;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string'
        ];
    }

    public function mount(): void
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function submit()
    {
        $validated = $this->validate();
        $dto = ProfileSettingsDTO::fromArray($validated);
        try {
            ProfileSettingsAction::execute($dto);
            $this->toast('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.settings.profile-settings')
            ->layout('layouts.auth')
            ->title('Profile Settings');
    }
}
