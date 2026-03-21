<?php

namespace App\Livewire\Brand\Product;

use App\Actions\Brand\DeliveryLocationAction;
use App\DTOs\Brand\DeliveryLocationDTO;
use App\Models\DeliveryLocation;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;

class ManageDeliveryLocations extends Component
{
    use Toastable;

    // Form properties
    public string $name = '';

    public int $delivery_price = 0;

    public ?int $parent_id = null;

    public ?int $editing_id = null;

    public ?int $brandId = null;

    // UI state
    public bool $showCreateModal = false;

    public bool $showEditModal = false;

    public bool $showDeleteModal = false;

    public bool $showSubLocationModal = false;

    public ?DeliveryLocation $selectedParent = null;

    public array $expandedLocations = [];

    protected function rules(): array
    {
        return [
            'name' => 'required|min:2|max:255',
            'delivery_price' => 'required|numeric|min:0',
            'parent_id' => 'nullable|exists:delivery_locations,id',
        ];
    }

    public function mount(): void
    {
        $this->brandId = auth()->user()->brand->id;
    }

    // Get root locations (states/regions)
    public function getRootLocationsProperty()
    {
        return DeliveryLocation::forBrand($this->brandId)
            ->root()
            ->with(['children' => function ($query) {
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get();
    }

    // Create new location
    public function create(): void
    {
        $this->validate();

        $buildDto = [
            'brandId' => $this->brandId,
            'name' => $this->name,
            'deliveryPrice' => $this->delivery_price,
            'parentId' => $this->parent_id,
            'level' => $this->parent_id ? DeliveryLocation::find($this->parent_id)->level + 1 : 0,
        ];

        $dto = DeliveryLocationDTO::fromArray($buildDto);
        try {
            DeliveryLocationAction::execute($dto);
            $this->reset(['name', 'delivery_price', 'parent_id']);
            $this->showCreateModal = false;
            $this->toast('success', 'Location added sucessfully.');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }
    }

    // Open create modal (optionally with parent)
    public function openCreateModal(?int $parentId = null): void
    {
        $this->resetValidation();
        $this->reset(['name', 'delivery_price', 'parent_id']);

        if ($parentId) {
            $this->parent_id = $parentId;
            $this->selectedParent = DeliveryLocation::find($parentId);
            $this->showSubLocationModal = true;
        } else {
            $this->showCreateModal = true;
        }
    }

    // Edit location
    public function edit(int $id): void
    {
        $location = DeliveryLocation::findOrFail($id);
        $this->editing_id = $id;
        $this->name = $location->name;
        $this->delivery_price = $location->delivery_price;
        $this->parent_id = $location->parent_id;

        $this->showEditModal = true;
    }

    public function update(): void
    {
        $this->validate();
        $buildDto = [
            'id' => $this->editing_id,
            'name' => $this->name,
            'deliveryPrice' => $this->delivery_price,
            'parentId' => $this->parent_id,
        ];
        $dto = DeliveryLocationDTO::fromArray($buildDto);
        try {
            DeliveryLocationAction::update($dto);
            $this->closeModal();
            $this->toast('success', 'Location updated successfully!');
        } catch (\Exception $e) {
            $this->closeModal();
            $this->toast('error', $e->getMessage());
        }
    }

    // Delete location
    public function confirmDelete(int $id): void
    {
        $location = DeliveryLocation::findOrFail($id);
        $this->editing_id = $id;
        $this->name = $location->name;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        $buildDto = [
            'id' => $this->editing_id,
        ];
        $dto = DeliveryLocationDTO::fromArray($buildDto);
        try {
            DeliveryLocationAction::delete($dto);
            $this->toast('success', 'Location deleted successfully!');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
            $this->closeModal();
        }
    }

    // Toggle location expansion
    public function toggleExpand(int $locationId): void
    {
        if (in_array($locationId, $this->expandedLocations)) {
            $this->expandedLocations = array_diff($this->expandedLocations, [$locationId]);
        } else {
            $this->expandedLocations[] = $locationId;
        }
    }

    // Close modals
    public function closeModal(): void
    {
        $this->reset(['name', 'delivery_price', 'parent_id', 'editing_id', 'selectedParent']);
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showSubLocationModal = false;
    }

    public function render(): View
    {
        return view('livewire.brand.product.manage-delivery-locations', [
            'rootLocations' => $this->rootLocations,
        ])
            ->layout('layouts.auth')
            ->title('Manage Delivery Locations');
    }
}
