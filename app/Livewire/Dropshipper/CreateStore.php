<?php

// app/Livewire/Dropshipper/CreateStore.php

namespace App\Livewire\Dropshipper;

use App\Jobs\CloneBrandJob;
use App\Models\Brand;
use App\Models\DropshipperApplication;
use App\Models\DropshipperStore;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class CreateStore extends Component
{
    public Brand $brand;

    public $storeName;

    public $storeSlug;

    public $isCheckingSlug = false;

    public $slugAvailable = false;

    public $agreedToTerms = false;

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
            ->where('status', 'approved')
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
        $this->generateSlug();
    }

    public function generateSlug(): void
    {
        $this->resetErrorBag();
        $this->isCheckingSlug = true;
        $this->storeSlug = Str::slug($this->storeName);

        // Check if slug exists
        $exists = DropshipperStore::where('slug', $this->storeSlug)->exists();
        if ($exists) {
            $this->slugAvailable = false;
            $this->isCheckingSlug = false;
        } else {
            $this->slugAvailable = true;
            $this->isCheckingSlug = false;
        }

    }

    public function createStore()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            // Get total products for initial stats
            $totalProducts = Product::where('brand_id', $this->brand->id)->count();

            $store = DropshipperStore::create([
                'dropshipper_id' => auth()->user()->dropshipper->id,
                'brand_id' => $this->brand->id,
                'store_name' => $this->storeName,
                'slug' => $this->storeSlug,
                'settings' => [
                    'theme' => 'default',
                    'layout' => 'standard',
                    'created_from_brand' => $this->brand->brand_name,
                    'created_at' => now()->toDateTimeString(),
                    'clone_stats' => [
                        'total_products' => $totalProducts,
                        'cloned_products' => 0,
                        'percentage' => 0,
                        'status' => 'pending',
                        'updated_at' => now()->toDateTimeString(),
                    ],
                ],
                'status' => 'active',
            ]);

            DB::commit();

            // Dispatch cloning job
            CloneBrandJob::dispatch($store);

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Store created successfully! Cloning has started.',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            return redirect()->route('dropshipper-clone-progress', $store->id);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Failed to create store: '.$e->getMessage(),
                'title' => 'Failed',
                'duration' => 5000,
            ]);

            return redirect()->back();
        }
    }

    public function render(): View
    {
        return view('livewire.dropshipper.create-store')
            ->layout('layouts.auth')
            ->title('Create Store');
    }
}
