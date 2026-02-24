<?php

namespace App\Livewire\Brand\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\User;
use App\DTOs\Brand\AdditionalDetailsDTO;
use App\Actions\Brand\AdditionalDetailsActions;

use App\Traits\Toastable;

class AdditionalDetails extends Component
{
    use WithFileUploads;
    use Toastable;

    public $logo;
    public User $user;
    public string $currentLogo = '';
    public string|null $about = '';
    public string|null $motto = '';
    public string|null $instagram = '';
    public string|null $tiktok = '';
    public string|null $linkedin = '';
    public string|null $twitter = '';
    public string|null $facebook = '';
    public string|null $youtube = '';
    public string|null $website = '';

    protected $rules = [
        'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB max
        'about' => 'string|nullable',
        'motto' => 'string|nullable',
        'instagram' => 'string|nullable',
        'tiktok' => 'string|nullable',
        'linkedin' => 'string|nullable',
        'twitter' => 'string|nullable',
        'facebook' => 'string|nullable',
        'youtube' => 'string|nullable',
        'website' => 'string|nullable',
    ];

    public function mount(): void {
        $user = User::with('brand')->where('id', auth()->id())->first();
        $this->user = $user;
        $this->currentLogo = $user->brand->image ?? 'images/profile_pic.svg';
        $this->about = $user->brand->about;
        $this->motto = $user->brand->motto;
        $this->instagram = $user->brand->instagram;
        $this->tiktok = $user->brand->tiktok;
        $this->linkedin = $user->brand->linkedin;
        $this->twitter = $user->brand->twitter;
        $this->facebook = $user->brand->facebook;
        $this->youtube = $user->brand->youtube;
        $this->website = $user->brand->website;
    }
    public function updatedLogo($logo): void {
        $this->logo = $logo;
        $this->currentLogo = '';
    }

    public function submit()
    {
        $validated = $this->validate();
        $dto = AdditionalDetailsDTO::fromArray($validated);

        try {
            AdditionalDetailsActions::execute($dto);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Brand details updated successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);
//          redirect to dashboard
            return redirect()->route('brand-dashboard');
        } catch (\Exception $e) {
            session()->flash('toast', [
                'type' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Success',
                'duration' => 5000,
            ]);
            return back();
        }
    }

    public function render()
    {
        return view('livewire.brand.settings.additional-details')
            ->layout('layouts.auth')
            ->title('Additional Details');
    }
}
