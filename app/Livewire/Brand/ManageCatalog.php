<?php

namespace App\Livewire\Brand;

use App\Actions\Brand\AddProductAction;
use App\DTOs\Brand\CatalogDTO;
use App\Models\CatalogItem;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManageCatalog extends Component
{
    use Toastable;
    use WithFileUploads, WithPagination;

    public array $photos = [];

    public string $search = '';

    public int $skippedFiles = 0;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Track files skipped by the frontend.
     */
    public function addSkippedFiles(int $count): void
    {
        $this->skippedFiles += min(max($count, 0), 1000);
    }

    /**
     * Save all valid images in the current upload batch.
     */
    public function save(): void
    {
        $brand = auth()->user()?->brand;

        if (empty($this->photos)) {
            if ($this->skippedFiles > 0) {
                $this->toast('error', "{$this->skippedFiles} unsupported file(s) were skipped. No images were uploaded.");
                $this->skippedFiles = 0;

                return;
            }

            $this->addError('photos', 'Please select at least one image.');

            return;
        }

        $buildDTO = [
            'brandId' => $brand->id,
            'photos' => $this->photos,
            'skippedFiles' => $this->skippedFiles,
        ];

        $dto = CatalogDTO::fromArray($buildDTO);

        $result = AddProductAction::addCatalog($dto);

        $this->reset('photos');
        $this->dispatch('catalog-uploaded');

        $message = "{$result['uploaded']} image(s) uploaded successfully.";
        if ($result['skipped'] > 0) {
            $message .= " {$result['skipped']} file(s) were skipped.";
        }
        $this->toast('success', $message);
        $this->skippedFiles = 0;

        $this->resetPage();
    }

    /**
     * Delete an image belonging to the authenticated brand.
     */
    public function delete(int $id): void
    {
        $brand = auth()->user()?->brand;
        $buildDTO = [
            'brandId' => $brand->id,
            'catalogId' => $id,
        ];

        $dto = CatalogDTO::fromArray($buildDTO);
        AddProductAction::deleteCatalog($dto);

        $this->toast('success', 'Catalog image deleted successfully');
        $this->resetPage();
    }

    public function render(): View
    {
        $brand = auth()->user()?->brand;

        abort_unless($brand, 403);

        $items = CatalogItem::query()
            ->where('brand_id', $brand->id)
            ->when($this->search !== '', function ($query) {
                $query->where(
                    'original_name',
                    'LIKE',
                    '%'.$this->search.'%'
                );
            })
            ->latest()
            ->paginate(24);

        return view('livewire.brand.manage-catalog', [
            'items' => $items,
            'brand' => $brand,
        ])->layout('layouts.auth')
            ->title('Manage Catalog');
    }
}
