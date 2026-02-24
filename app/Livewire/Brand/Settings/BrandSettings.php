<?php

namespace App\Livewire\Brand\Settings;

use Livewire\Component;
use App\DTOs\Brand\BrandSettingsDTO;
use App\Actions\Brand\BrandSettingsAction;
Use App\Traits\Toastable;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\State;
use App\Models\LocalGovernment;

class BrandSettings extends Component
{
    use Toastable;

    public User $user;
    public array $categories = [];
    public array $subcategories = [];
    public array $states = [];
    public array $localGovernments = [];
    public string|null $brandName;
    public string|null $selectedCategory = '';
    public string|null $selectedSubcategory = '';
    public string|null $type = '';
    public string|null $description = '';
    public string|null $position = '';
    public string|null $selectedState = '';
    public string|null $selectedLocalGovernment = '';
    public string|null $address = '';
    public string|null $bankName = '';
    public string|null $accountNumber = '';
    public string|null $accountName = '';

    protected array $rules = [
        'brandName' => 'required',
        'selectedCategory' => 'required',
        'selectedSubcategory' => 'required',
        'type' => 'required',
        'description' => 'required|max:50',
        'position' => 'required',
        'selectedState' => 'required',
        'selectedLocalGovernment' => 'required',
        'address' => 'nullable',
        'bankName' => 'required',
        'accountNumber' => 'required',
        'accountName' => 'required',
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
//            Trigger success toast if successful. Using session to retain toast when redirect happens
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Account updated successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

//          redirect to additional details page
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
