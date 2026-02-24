<?php

namespace App\Livewire\Settings;

use App\Enums\Status;
use App\Models\User;
use Livewire\Component;
use App\DTOs\ProfileSettingsDTO;
use App\Actions\ProfileSettingsAction;
use App\Traits\Toastable;
use App\Enums\UserType;
use App\Models\Preference;

class ProfileSettings extends Component
{
    use Toastable;

    public string $name;
    public string $email;
    public string $phone = '';
    public $selectedPreferences = [];
    public $allPreferences;
    public $search = '';
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
        if($user->phone) $this->phone = $user->phone;

        // Load user's existing preferences
        $this->selectedPreferences = auth()->user()
            ->preferences()
            ->pluck('preferences.id')
            ->map(fn($id) => (string) $id) // convert to strings for wire:key
            ->toArray();

        $this->loadPreferences();
    }

    public function loadPreferences(): void {
        $query = Preference::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $this->allPreferences = $query->orderBy('name')->get();
    }

    public function updatedSearch() {
        $this->loadPreferences();
    }

    public function togglePreference($preferenceId)
    {
        $user = auth()->user();

        if (in_array($preferenceId, $this->selectedPreferences)) {
            // Remove
            $user->preferences()->detach($preferenceId);
            $this->selectedPreferences = array_diff($this->selectedPreferences, [$preferenceId]);
        } else {
            // Add
            $user->preferences()->attach($preferenceId);
            $this->selectedPreferences[] = $preferenceId;
        }

        // Keep array values unique and clean
        $this->selectedPreferences = array_values($this->selectedPreferences);
    }

    public function submit()
    {
        $validated = $this->validate();
        $dto = ProfileSettingsDTO::fromArray($validated);
        try {
            ProfileSettingsAction::execute($dto);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Profile updated successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);
            $this->toast('success', 'Profile updated successfully');
            $user = User::where('id', auth()->user()->id)->first();

            if($user->role === UserType::BRAND) {
                $brand = $user->brand;
                if($brand->status != Status::COMPLETED) {
                    return redirect()->route('brand-details');
                }
            } elseif ($user->role === UserType::DROPSHIPPER) {
                $dropshipper = $user->dropshipper;
                if($dropshipper->status != Status::COMPLETED) {
                    return redirect()->route('dropshipper-details');
                }
            }
            return back();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            return back();
        }
    }

    public function render()
    {
        return view('livewire.settings.profile-settings')
            ->layout('layouts.auth')
            ->title('Profile Settings');
    }
}
