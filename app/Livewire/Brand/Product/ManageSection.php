<?php

namespace App\Livewire\Brand\Product;

use App\Actions\Brand\SectionAction;
use App\DTOs\Brand\SectionDTO;
use App\Models\Section;
use App\Traits\Toastable;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSection extends Component
{
    use Toastable;
    use WithPagination;

    public string $name;

    public int $sectionId;

    public bool $showEditModal = false;

    public bool $showDeleteModal = false;

    public bool $showCreateModal = false;

    public int $perPage = 4;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'sectionId' => 'nullable|integer|exists:sections,id',
    ];

    public function openCreateModal(): void
    {
        $this->resetValidation();
        $this->reset(['name', 'sectionId']);
        $this->showCreateModal = true;
    }

    public function submit(): void
    {
        $validated = $this->validate();
        $dto = SectionDTO::fromArray($validated);
        try {
            SectionAction::execute($dto);
            $this->reset(['name', 'sectionId']);
            $this->showCreateModal = false;
            $this->toast('success', 'Section added successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function popup($type, $id): void
    {
        $section = Section::findOrFail($id);

        $this->sectionId = $section->id;
        $this->name = $section->name;

        $type == 'edit' ? $this->showEditModal = true : $this->showDeleteModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate();
        $dto = SectionDTO::fromArray($validated);
        try {
            SectionAction::edit($dto);
            $this->name = '';
            $this->closeModal();
            $this->toast('success', 'Section updated successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function delete(): void
    {
        $validated = $this->validate();
        $dto = SectionDTO::fromArray($validated);
        try {
            SectionAction::delete($dto);
            $this->name = '';
            $this->closeModal();
            $this->toast('success', 'Section deleted successfully.');
        } catch (\Exception $e) {
            $this->toast('error', $e->getMessage());
        }
    }

    public function closeModal(): void
    {
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showCreateModal = false;
    }

    public function render()
    {
        $sections = Section::with('products')->where('brand_id', auth()->user()->brand->id)
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.brand.product.manage-section', [
            'sections' => $sections,
        ])
            ->layout('layouts.auth')
            ->title('Sections');
    }
}
