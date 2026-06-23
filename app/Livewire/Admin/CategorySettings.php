<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use App\Traits\Toastable;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class CategorySettings extends Component
{
    use Toastable;
    use WithPagination;

    // Category properties
    public $categoryId;

    public $categoryName;

    public $categoryIcon;

    public $isEditingCategory = false;

    // Subcategory properties
    public $subcategoryId;

    public $subcategoryName;

    public $selectedCategoryId;

    public $isEditingSubcategory = false;

    // UI state
    public $showCategoryForm = false;

    public $showSubcategoryForm = false;

    public $expandedCategories = [];

    protected $rules = [
        'categoryName' => 'required|string|max:255',
        'categoryIcon' => 'nullable|string|max:50',
        'subcategoryName' => 'required|string|max:255',
        'selectedCategoryId' => 'required|exists:categories,id',
    ];

    public function resetCategoryForm(): void
    {
        $this->categoryId = null;
        $this->categoryName = '';
        $this->categoryIcon = '';
        $this->isEditingCategory = false;
        $this->showCategoryForm = false;
    }

    public function resetSubcategoryForm(): void
    {
        $this->subcategoryId = null;
        $this->subcategoryName = '';
        $this->selectedCategoryId = null;
        $this->isEditingSubcategory = false;
        $this->showSubcategoryForm = false;
    }

    public function toggleCategory($categoryId): void
    {
        if (in_array($categoryId, $this->expandedCategories)) {
            $this->expandedCategories = array_diff($this->expandedCategories, [$categoryId]);
        } else {
            $this->expandedCategories[] = $categoryId;
        }
    }

    // Category CRUD Operations
    public function createCategory(): void
    {
        $this->resetCategoryForm();
        $this->showCategoryForm = true;
        $this->isEditingCategory = false;
    }

    public function editCategory($categoryId): void
    {
        $category = Category::findOrFail($categoryId);
        $this->categoryId = $category->id;
        $this->categoryName = $category->name;
        $this->categoryIcon = $category->icon;
        $this->isEditingCategory = true;
        $this->showCategoryForm = true;
    }

    public function saveCategory(): void
    {
        $this->validate([
            'categoryName' => 'required|string|max:255',
            'categoryIcon' => 'nullable|string|max:50',
        ]);

        if ($this->isEditingCategory) {
            $category = Category::findOrFail($this->categoryId);
            $category->update([
                'name' => $this->categoryName,
                'icon' => $this->categoryIcon,
            ]);
            $this->toast('success', ' Category updated successfully!');
        } else {
            Category::create([
                'name' => $this->categoryName,
                'icon' => $this->categoryIcon,
            ]);
            session()->flash('message', 'Category created successfully!');
            $this->toast('success', ' Category created successfully!');
        }

        $this->resetCategoryForm();
        $this->dispatch('category-saved');
    }

    public function deleteCategory($categoryId): void
    {
        $category = Category::findOrFail($categoryId);

        // Check if category has subcategories
        if ($category->subcategories()->count() > 0) {
            $this->toast('error', ' Cannot delete category with existing subcategories. Please delete subcategories first.');

            return;
        }

        $category->delete();
        $this->toast('success', ' Category deleted successfully!');

        // Remove from expanded categories if present
        if (in_array($categoryId, $this->expandedCategories)) {
            $this->expandedCategories = array_diff($this->expandedCategories, [$categoryId]);
        }
    }

    // Subcategory CRUD Operations
    public function createSubcategory($categoryId = null): void
    {
        $this->resetSubcategoryForm();
        $this->selectedCategoryId = $categoryId;
        $this->showSubcategoryForm = true;
        $this->isEditingSubcategory = false;
    }

    public function editSubcategory($subcategoryId): void
    {
        $subcategory = Subcategory::findOrFail($subcategoryId);
        $this->subcategoryId = $subcategory->id;
        $this->subcategoryName = $subcategory->name;
        $this->selectedCategoryId = $subcategory->category_id;
        $this->isEditingSubcategory = true;
        $this->showSubcategoryForm = true;
    }

    public function saveSubcategory(): void
    {
        $this->validate([
            'subcategoryName' => 'required|string|max:255',
            'selectedCategoryId' => 'required|exists:categories,id',
        ]);

        if ($this->isEditingSubcategory) {
            $subcategory = Subcategory::findOrFail($this->subcategoryId);
            $subcategory->update([
                'name' => $this->subcategoryName,
                'category_id' => $this->selectedCategoryId,
            ]);
            $this->toast('success', ' Subcategory updated successfully!');
        } else {
            Subcategory::create([
                'name' => $this->subcategoryName,
                'category_id' => $this->selectedCategoryId,
            ]);
            $this->toast('success', ' Subcategory created successfully!');
        }

        $this->resetSubcategoryForm();
        $this->dispatch('subcategory-saved');
    }

    public function deleteSubcategory($subcategoryId): void
    {
        Subcategory::findOrFail($subcategoryId)->delete();
        $this->toast('success', ' Subcategory deleted successfully!');
    }

    public function render(): View
    {
        $categories = Category::with('subcategories')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.category-settings', [
            'categories' => $categories,
        ])->layout('layouts.auth')
            ->title('Category Settings');
    }
}
