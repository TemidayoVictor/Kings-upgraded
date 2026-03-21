<?php

namespace App\Livewire\Brand\Settings;

use App\Actions\Brand\BrandSettingsAction;
use App\DTOs\Brand\BrandSettingsDTO;
use App\Models\Category;
use App\Models\LocalGovernment;
use App\Models\State;
use App\Models\Subcategory;
use App\Models\User;
use App\Traits\Toastable;
use Livewire\Component;

class BrandSettings extends Component
{
    use Toastable;

    public User $user;

    public array $categories = [];

    public array $subcategories = [];

    public array $states = [];

    public array $localGovernments = [];

    public ?string $brandName;

    public ?string $selectedCategory = '';

    public ?string $selectedSubcategory = '';

    public ?string $type = '';

    public ?string $slug = '';

    public ?string $description = '';

    public ?string $position = '';

    public ?string $selectedState = '';

    public ?string $selectedLocalGovernment = '';

    public ?string $address = '';

    public ?string $bankName = '';

    public ?string $accountNumber = '';

    public ?string $accountName = '';

    protected array $rules = [
        'brandName' => 'required',
        'selectedCategory' => 'required',
        'selectedSubcategory' => 'required',
        'type' => 'required',
        'slug' => [
            '',
            'max:255',
            'regex:/^[A-Za-z0-9_]+$/',
        ],
        'description' => 'required|max:50',
        'position' => 'required',
        'selectedState' => 'required',
        'selectedLocalGovernment' => 'required',
        'address' => 'nullable',
        'bankName' => 'required',
        'accountNumber' => 'required',
        'accountName' => 'required',
    ];

    protected array $messages = [
        'slug.regex' => 'Please, only use letters, numbers and underscores.',
    ];

    public function mount(): void
    {
        $user = User::with('brand')->where('id', auth()->id())->first();
        $this->user = $user;
        $this->categories = Category::pluck('category', 'id')->toArray();
        $this->states = State::pluck('name', 'id')->toArray();
        $this->brandName = $user->brand->brand_name;
        $this->selectedCategory = $user->brand->category;
        $this->selectedSubcategory = $user->brand->sub_category;
        // populate subcategory field if it exists
        if ($this->selectedCategory) {
            $this->subcategories = Subcategory::where('category', $this->selectedCategory)
                ->pluck('subcategory', 'id')
                ->toArray();
        }
        $this->selectedState = $user->brand->state;
        $this->selectedLocalGovernment = $user->brand->city;
        //        populate city field if it exists
        if ($this->selectedLocalGovernment) {
            $this->localGovernments = LocalGovernment::where('state_id', $this->selectedState)
                ->pluck('name', 'id')
                ->toArray();
        }
        $this->position = $user->brand->position;
        $this->description = $user->brand->description;
        $this->type = $user->brand->brand_type;
        $this->slug = $user->brand->slug;
        $this->address = $user->brand->address;
        $this->bankName = $user->brand->bank_name;
        $this->accountName = $user->brand->account_name;
        $this->accountNumber = $user->brand->account_number;
    }

    // Runs automatically when category changes
    public function updatedSelectedCategory($category): void
    {
        $this->subcategories = Subcategory::where('category', $category)
            ->pluck('subcategory', 'id')->toArray();

        $this->selectedSubcategory = '';
    }

    public function updatedSlug($value): void
    {
        $value = strtolower($value);          // convert to lowercase
        $value = str_replace(' ', '_', $value); // replace spaces with underscore
        $this->slug = $value;
    }

    // Runs automatically when state changes
    public function updatedSelectedState($state): void
    {
        $this->localGovernments = LocalGovernment::where('state_id', $state)
            ->pluck('name', 'id')->toArray();

        $this->selectedLocalGovernment = '';
    }

    public function submit()
    {
        $validated = $this->validate();
        $dto = BrandSettingsDTO::fromArray($validated);

        try {
            $update = BrandSettingsAction::execute($dto);
            // Trigger success toast if successful. Using session to retain toast when redirect happens
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Account updated successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            // redirect to additional details page
            return redirect()->route('brand-additional-details');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.brand.settings.brand-settings')
            ->layout('layouts.auth')
            ->title('Brand Details');
    }
}
