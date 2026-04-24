<?php

// app/Livewire/Dropshipper/CreateStore.php

namespace App\Livewire\Dropshipper;

use App\Actions\Dropshipper\CloneStoreAction;
use App\DTOs\Dropshipper\CloneStoreDTO;
use App\Models\Brand;
use App\Models\DropshipperApplication;
use App\Models\DropshipperStore;
use App\Traits\Toastable;
use App\Enums\Status;
use Illuminate\View\View;
use Livewire\Component;

class CreateStore extends Component
{
    use Toastable;

    public Brand $brand;

    public string $storeName;

    public string $storeSlug;

    public bool $isCheckingSlug = false;

    public bool $slugAvailable = false;

    public bool $agreedToTerms = false;

    protected $rules = [
        'storeName' => 'required|string|min:3|max:100',
        'storeSlug' => 'required|string|alpha_dash|unique:dropshipper_stores,slug',
        'agreedToTerms' => 'required|accepted',
    ];

    public function mount(Brand $brand): void
    {
        $this->brand = $brand;

        // Check if dropshipper has approved application
        $dropshipper = auth()->user()->dropshipper;
        $hasApproved = DropshipperApplication::where('dropshipper_id', $dropshipper->id)
            ->where('brand_id', $brand->id)
            ->where('status', Status::APPROVED)
            ->orWhere('status', Status::CLONED)
            ->exists();

        if (! $hasApproved) {
            abort(403, 'You do not have an approved application for this brand.');
        }

        // Check if store already exists
        $existingStore = DropshipperStore::where('dropshipper_id', $dropshipper->id)
            ->where('brand_id', $brand->id)
            ->first();

        if ($existingStore) {
            redirect()->route('dropshipper-store', $existingStore);

            return;
        }
    }

    public function updatedStoreName(): void
    {
        $this->resetErrorBag();
        $this->isCheckingSlug = true;
        $check = generateStoreSlug($this->storeName);
        $this->storeSlug = $check['storeSlug'];
        if ($check['exists']) {
            $this->slugAvailable = false;
        } else {
            $this->slugAvailable = true;
        }
        $this->isCheckingSlug = false;
    }

    public function createStore()
    {
        $this->validate();
        $buildDto = [
            'storeName' => $this->storeName,
            'storeSlug' => $this->storeSlug,
            'brandId' => $this->brand->id,
            'brandName' => $this->brand->brand_name,
            'settings' => [
                'theme' => 'default',
                'layout' => 'standard',
            ],
        ];

        $dto = CloneStoreDTO::fromArray($buildDto);
        try {
            $store = CloneStoreAction::execute($dto);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Store created successfully! Cloning has started.',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            return redirect()->route('dropshipper-clone-progress', $store);
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());

            return back();
        }
    }

    public function render(): View
    {
        return view('livewire.dropshipper.create-store')
            ->layout('layouts.auth')
            ->title('Create Store');
    }
}
