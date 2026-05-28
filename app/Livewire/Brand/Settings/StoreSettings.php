<?php

namespace App\Livewire\Brand\Settings;

use App\Actions\Brand\AdditionalDetailsActions;
use App\DTOs\Brand\StoreSettingsDTO;
use App\Models\User;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;

class StoreSettings extends Component
{
    use Toastable;

    public User $user;

    public ?string $hero_tagline = '';

    public ?string $hero_title_line_1 = '';

    public ?string $hero_title_line_2_italic = '';

    public ?string $hero_description = '';

    public ?string $hero_button_text = '';

    public string $primary_color = '#000000';

    public string $secondary_color = '#f7f6f2';

    protected $rules = [
        'hero_tagline' => 'string|nullable|max:100',
        'hero_title_line_1' => 'string|nullable|max:150',
        'hero_title_line_2_italic' => 'string|nullable|max:150',
        'hero_description' => 'string|nullable|max:500',
        'hero_button_text' => 'string|nullable|max:60',
        'primary_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
        'secondary_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
    ];

    public function mount(): void
    {
        $this->user = User::with('brand.brandSetting')->where('id', auth()->id())->firstOrFail();

        $settings = $this->user->brand->brandSetting ?? null;

        if ($settings) {
            $this->hero_tagline = $settings->hero_tagline;
            $this->hero_title_line_1 = $settings->hero_title_line_1;
            $this->hero_title_line_2_italic = $settings->hero_title_line_2_italic;
            $this->hero_description = $settings->hero_description;
            $this->hero_button_text = $settings->hero_button_text;
            $this->primary_color = $settings->primary_color ?? '#000000';
            $this->secondary_color = $settings->secondary_color ?? '#f7f6f2';
        }
    }

    /**
     * Direct update pipeline method helper targeting local dynamic wire models properties values.
     */
    public function setColors(string $primary, string $secondary): void
    {
        $this->primary_color = $primary;
        $this->secondary_color = $secondary;
    }

    /**
     * Returns a static array containing premium layout colors optimized specifically for lifestyle,
     * skincare, fashion retail aesthetics.
     */
    public function colorPresets(): array
    {
        return [
            [
                'name' => 'Terracotta Minimal',
                'style' => 'Earthy & Modern',
                'primary' => '#b55a3b',
                'secondary' => '#e7dfd7',
            ],
            [
                'name' => 'Noir Luxe',
                'style' => 'High-End Editorial',
                'primary' => '#111111',
                'secondary' => '#f3f3ee',
            ],
            [
                'name' => 'Botanical Fresh',
                'style' => 'Organic & Raw',
                'primary' => '#2e4a3f',
                'secondary' => '#f2f5f1',
            ],
            [
                'name' => 'Petal Blush',
                'style' => 'Soft Skincare',
                'primary' => '#c58b7d',
                'secondary' => '#faf5f2',
            ],
            [
                'name' => 'Mediterranean Dusk',
                'style' => 'Warm Vintage',
                'primary' => '#bc7c4c',
                'secondary' => '#fcf6ed',
            ],
            [
                'name' => 'Midnight Indigo',
                'style' => 'Deep Premium Accent',
                'primary' => '#1b2d42',
                'secondary' => '#f4f6f9',
            ],
        ];
    }

    public function submit()
    {
        $validated = $this->validate();
        $dto = StoreSettingsDTO::fromArray($validated);

        try {
            AdditionalDetailsActions::storeSettings($dto);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Store settings updated successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            // redirect to dashboard
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

    public function render(): View
    {
        return view('livewire.brand.settings.store-settings')->layout('layouts.auth')
            ->title('Store Settings');
    }
}
