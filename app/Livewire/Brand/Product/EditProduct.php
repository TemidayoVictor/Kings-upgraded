<?php

namespace App\Livewire\Brand\Product;

use Illuminate\View\View;
use Livewire\Component;
use App\Traits\Toastable;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Support\Collection;
use App\DTOs\Brand\DeleteImageDTO;
use App\Actions\Brand\DeleteImageAction;
use App\DTOs\Brand\ProductDTO;
use App\Actions\Brand\EditProductAction;

class EditProduct extends Component
{
    use WithFileUploads;
    use Toastable;

    // Product
    public Product $product;
    public array $images = [];
    public array $existingImages = [];
    public Collection $sections;
    public string|null $name;
    public string|null $description;
    public int|null $price;
    public int|null $salesPrice;
    public int|null $dropshippingPrice;
    public int|null $sectionId;
    public string|null $link;
    public int|null $stock;
    public bool $showDeleteModal = false;
    public ?int $imageId = null;
    public ?string $imageName = null;

    protected $rules = [
        'images' => 'array|max:5',
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

    public function mount(Product $product): void
    {
        $this->product = $product;
        // Load sections
        $this->sections = Section::where('brand_id', auth()->user()->brand->id)->get();
    }

    private function loadProductData(): void
    {
        $this->name = $this->product->name;
        $this->description = $this->product->description;
        $this->price = $this->product->price;
        $this->salesPrice = $this->product->sales_price;
        $this->dropshippingPrice = $this->product->dropship_price;
        $this->sectionId = $this->product->section_id;
        $this->link = $this->product->link;
        $this->stock = $this->product->stock;

        // Load existing images
        $this->existingImages = $this->product->images->toArray();
    }

    public function removeNewPhoto($index): void
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
        $this->toast('success', 'Image removed');
    }

    public function confirmImageDelete($imageId): void
    {
        $this->imageId = $imageId;
        $this->showDeleteModal = true;
    }

    public function deleteImage(): void {
        $buildDto = [
            'productId' => $this->product->id,
            'imageId' => $this->imageId,
        ];
        $dto = DeleteImageDTO::fromArray($buildDto);
        try {
            DeleteImageAction::execute($dto);
            $this->closeModal();
            $this->toast('success','Image deleted successfully.');
        } catch(\Exception $e) {
            $this->closeModal();
            $this->toast('error',$e->getMessage());
        }
    }

    public function closeModal(): void
    {
        $this->reset(['showDeleteModal', 'imageId', 'imageName']);
    }

    public function submit(): void
    {
        $validated = $this->validate();
        $validated['productId'] = $this->product->id;
        $dto = ProductDTO::fromArray($validated);
        try {
            EditProductAction::execute($dto);
            $this->images = [];
            $this->toast('success','Product updated successfully.');
        } catch(\Exception $e) {
            $this->toast('error',$e->getMessage());
        }
    }

    public function render(): View
    {
        $this->loadProductData();
        return view('livewire.brand.product.edit-product')
            ->layout('layouts.auth')
            ->title('Edit Product');
    }
}
