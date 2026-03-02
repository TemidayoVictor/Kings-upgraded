<?php

namespace App\Livewire\Brand\Product;

use App\Traits\Toastable;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Actions\Brand\AddProductAction;
use App\DTOs\Brand\AddProductDTO;
use App\Models\Section;
use Illuminate\Support\Collection;

class AddProduct extends Component
{
    use WithFileUploads;
    use Toastable;

    public array $images = [];
    public Collection $sections;
    public string|null $name;
    public string|null $description;
    public int|null $price;
    public int|null $salesPrice;
    public int|null $dropshippingPrice;
    public int|null $sectionId;
    public string|null $link;
    public int|null $stock;

    protected $rules = [
        'images' => 'required|array|min:1|max:5',
        'images.*' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        'name' => 'string|required',
        'description' => 'nullable|string|required',
        'price' => 'integer|required',
        'salesPrice' => 'integer|nullable',
        'dropshippingPrice' => 'integer|nullable',
        'sectionId' => 'integer|nullable',
        'link' => 'string|nullable',
        'stock' => 'integer|nullable',
    ];

    public function mount(): void
    {
        $this->sections = Section::where('brand_id', auth()->user()->brand->id)->get();
    }
    public function removePhoto($index): void
    {
        // Remove photo from the array
        unset($this->images[$index]);

        // Re-index the array to maintain proper indexing
        $this->images = array_values($this->images);

        // Show a message
        $this->toast('success', 'Image removed');
    }

    public function submit() {
        $validated = $this->validate();
        $dto = AddProductDTO::fromArray($validated);
        try {
            AddProductAction::execute($dto);
            // CLEAR FORM
            $this->reset(['name', 'description', 'price', 'images', 'salesPrice', 'dropshippingPrice', 'sectionId', 'link', 'stock']);
            $this->resetValidation();

            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Product added successfully',
                'title' => 'Success',
                'duration' => 5000,
            ]);

            return redirect()->route('brand-add-product');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    private function resetForm(): void
    {
        $this->images = [];
        $this->name = null;
        $this->description = null;
        $this->price = null;
        $this->salesPrice = null;
        $this->dropshippingPrice = null;
        $this->sectionId = null;
        $this->link = null;
        $this->stock = null;
    }

    public function render()
    {
        return view('livewire.brand.product.add-product')
            ->layout('layouts.auth')
            ->title('Add Product');
    }
}
