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
            $this->toast('success', 'Location added sucessfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }

        $this->dispatch('location-created');
    }

    public function edit(int $id): void
    {
        $location = DeliveryLocation::findOrFail($id);

        $this->editing_id = $location->id;
        $this->name = $location->name;
        $this->delivery_price = $location->delivery_price;
        $this->parent_id = $location->parent_id;

        $this->resetValidation();
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
            $this->toast('success', 'Location updated successfully!');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }

        $this->dispatch('location-updated');
    }

    // Delete location
    public function delete($location): void
    {
        $buildDto = [
            'id' => $location,
        ];
        $dto = DeliveryLocationDTO::fromArray($buildDto);
        try {
            DeliveryLocationAction::delete($dto);
            $this->toast('success', 'Location deleted successfully!');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }

        $this->dispatch('location-deleted');
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
    public function render(): View
    {
        return view('livewire.brand.product.manage-delivery-locations', [
            'rootLocations' => $this->rootLocations,
        ])
            ->layout('layouts.auth')
            ->title('Manage Delivery Locations');
    }
}
