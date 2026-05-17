<?php

namespace App\Livewire\Admin;

use App\Models\GeneralSetting;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;

class GeneralSettings extends Component
{
    use Toastable;

    public int $basic_fee = 0;

    public int $basic_products_number = 0;

    public int $basic_images_number = 0;

    public int $basic_additional_products_fee = 0;

    public int $basic_additional_products_number = 0;

    public int $premium_fee = 0;

    public int $premium_products_number = 0;

    public int $premium_images_number = 0;

    public int $premium_additional_products_fee = 0;

    public int $premium_additional_products_number = 0;

    public int $platinum_fee = 0;

    public int $platinum_products_number = 0;

    public int $platinum_images_number = 0;

    public int $platinum_additional_products_fee = 0;

    public int $platinum_additional_products_number = 0;

    public int $dropshipper_fee = 0;

    public int $dropshipper_percent = 0;

    public int $collector_percent = 0;

    protected $rules = [
        'basic_fee' => 'required|numeric|min:0',
        'basic_products_number' => 'required|integer|min:0',
        'basic_images_number' => 'required|integer|min:0',
        'basic_additional_products_fee' => 'required|integer|min:0',
        'basic_additional_products_number' => 'required|integer|min:0',
        'premium_fee' => 'required|numeric|min:0',
        'premium_products_number' => 'required|integer|min:0',
        'premium_images_number' => 'required|integer|min:0',
        'premium_additional_products_fee' => 'required|integer|min:0',
        'premium_additional_products_number' => 'required|integer|min:0',
        'platinum_fee' => 'required|numeric|min:0',
        'platinum_products_number' => 'required|integer|min:0',
        'platinum_images_number' => 'required|integer|min:0',
        'platinum_additional_products_fee' => 'required|integer|min:0',
        'platinum_additional_products_number' => 'required|integer|min:0',
        'dropshipper_fee' => 'required|numeric|min:0',
        'dropshipper_percent' => 'required|numeric|min:0|max:100',
        'collector_percent' => 'required|numeric|min:0|max:100',
    ];

    //Custom validation messages
    protected $messages = [
        'basic_fee.required' => 'Basic fee is required',
        'basic_fee.numeric' => 'Basic fee must be a number',
        'basic_fee.min' => 'Basic fee cannot be negative',

        'basic_products_number.required' => 'Number of products for Basic plan is required',
        'basic_products_number.integer' => 'Products number must be a whole number',
        'basic_products_number.min' => 'Products number cannot be negative',

        'dropshipper_percent.max' => 'Dropshipper commission cannot exceed 100%',
        'dropshipper_percent.min' => 'Dropshipper commission cannot be negative',

        'collector_percent.max' => 'Collector commission cannot exceed 100%',
        'collector_percent.min' => 'Collector commission cannot be negative',
    ];

    public function mount(): void
    {
        $settings = generalSetting();

        if ($settings) {
            $this->basic_fee = $settings->basic_fee;
            $this->basic_products_number = $settings->basic_products_number;
            $this->basic_images_number = $settings->basic_images_number;
            $this->basic_additional_products_fee = $settings->basic_additional_products_fee;
            $this->basic_additional_products_number = $settings->basic_additional_products_number;
            $this->premium_fee = $settings->premium_fee;
            $this->premium_products_number = $settings->premium_products_number;
            $this->premium_images_number = $settings->premium_images_number;
            $this->premium_additional_products_fee = $settings->premium_additional_products_fee;
            $this->premium_additional_products_number = $settings->premium_additional_products_number;
            $this->platinum_fee = $settings->platinum_fee;
            $this->platinum_products_number = $settings->platinum_products_number;
            $this->platinum_images_number = $settings->platinum_images_number;
            $this->platinum_additional_products_fee = $settings->platinum_additional_products_fee;
            $this->platinum_additional_products_number = $settings->platinum_additional_products_number;
            $this->dropshipper_fee = $settings->dropshipper_fee;
            $this->dropshipper_percent = $settings->dropshipper_percent;
            $this->collector_percent = $settings->collector_percent;
        }
    }

    // Optional: Real-time validation for specific fields
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function save(): void
    {
        $this->validate();

        $settings = generalSetting();

        if (! $settings) {
            $settings = new GeneralSetting;
        }

        $settings->basic_fee = $this->basic_fee;
        $settings->basic_products_number = $this->basic_products_number;
        $settings->basic_images_number = $this->basic_images_number;
        $settings->basic_additional_products_fee = $this->basic_additional_products_fee;
        $settings->basic_additional_products_number = $this->basic_additional_products_number;
        $settings->premium_fee = $this->premium_fee;
        $settings->premium_products_number = $this->premium_products_number;
        $settings->premium_images_number = $this->premium_images_number;
        $settings->premium_additional_products_fee = $this->premium_additional_products_fee;
        $settings->premium_additional_products_number = $this->premium_additional_products_number;
        $settings->platinum_fee = $this->platinum_fee;
        $settings->platinum_products_number = $this->platinum_products_number;
        $settings->platinum_images_number = $this->platinum_images_number;
        $settings->platinum_additional_products_fee = $this->platinum_additional_products_fee;
        $settings->platinum_additional_products_number = $this->platinum_additional_products_number;
        $settings->dropshipper_fee = $this->dropshipper_fee;
        $settings->dropshipper_percent = $this->dropshipper_percent;
        $settings->collector_percent = $this->collector_percent;

        $settings->save();

        $this->toast('success', 'Settings updated successfully!');
    }

    public function render(): View
    {
        return view('livewire.admin.general-settings')
            ->layout('layouts.auth')
            ->title('General Settings');
    }
}
