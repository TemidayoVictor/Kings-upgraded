<section class="w-full">
    @include('partials.admin-heading')

    <x-settings.layout :heading="__('Categories and Subcategories')" :subheading="__('Manage categories and subcategories')">
        <div class="max-w-5xl space-y-8">

            <!-- High-Visibility Form Section -->
            @if($showCategoryForm || $showSubcategoryForm)
                <div class="max-w-2xl mx-auto p-6 bg-[#27272a] border border-[#3d3d40] rounded-lg">
                    <h3 class="font-bold text-white mb-4 uppercase tracking-wider text-sm">
                        {{ $showCategoryForm ? ($isEditingCategory ? 'Edit Category' : 'Create Category') : ($isEditingSubcategory ? 'Edit Subcategory' : 'Create Subcategory') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Input 1 -->
                        <div>
                            <label class="block text-sm font-semibold text-white mb-1">Name</label>
{{--                            <input type="text" wire:model="{{ $showCategoryForm ? 'categoryName' : 'subcategoryName' }}"--}}
{{--                                   class="w-full px-4 py-2 border border-zinc-400 rounded-lg focus:border-blue-600 focus:ring-0 bg-white text-zinc-900 placeholder-zinc-400">--}}

                            <flux:input type="text" wire:model="{{ $showCategoryForm ? 'categoryName' : 'subcategoryName' }}"/>
                        </div>

                        <!-- Input 2 (Icon or Select) -->
                        <div>
                            @if($showCategoryForm)
                                <label class="block text-sm font-semibold text-white mb-1">FontAwesome Class</label>
                                <flux:input type="text" wire:model="categoryIcon"/>
                            @else
                                <label class="block text-sm font-semibold text-zinc-700 mb-1">Parent Category</label>
                                <select wire:model="selectedCategoryId" class="w-full px-4 py-2 border-2 border-zinc-400 rounded-lg focus:border-blue-600 bg-white text-zinc-900">
                                    <option value="">Select Category</option>
                                    @foreach(\App\Models\Category::all() as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                                </select>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <flux:button wire:click="{{ $showCategoryForm ? 'saveCategory' : 'saveSubcategory' }}" variant="primary" size="sm">
                            Save Changes
                        </flux:button>
                        <flux:button wire:click="{{ $showCategoryForm ? 'resetCategoryForm' : 'resetSubcategoryForm' }}" variant="primary" size="sm">
                            Cancel
                        </flux:button>
                    </div>
                </div>
            @endif

            <!-- List Section -->
            <div class="space-y-2">
                <div class="max-w-2xl mx-auto space-y-4">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-white">Categories</h2>
                        <flux:button wire:click="createCategory" variant="primary" size="sm" icon="plus">Add Category</flux:button>
                    </div>

                    @foreach($categories as $category)
                        <div class="bg-[#27272a] border border-[#3d3d40] rounded-lg overflow-hidden">
                            <!-- Category Header -->
                            <div class="flex items-center justify-between p-4 bg-[#323236]">
                                <div class="flex items-center gap-3">
                                    <button wire:click="toggleCategory({{ $category->id }})" class="text-zinc-400 hover:text-white transition">
                                        <flux:icon name="{{ in_array($category->id, $expandedCategories) ? 'chevron-down' : 'chevron-right' }}" size="sm" />
                                    </button>
                                    <span class="font-semibold text-white">
                        @if($category->icon)<i class="{{ $category->icon }} mr-2"></i>@endif
                                        {{ $category->name }}
                    </span>
                                </div>

                                <!-- Desktop: Row, Mobile: Compact -->
                                <div class="flex items-center gap-1">
                                    <flux:button wire:click="createSubcategory({{ $category->id }})" variant="ghost" size="xs">Add Sub</flux:button>
                                    <flux:button wire:click="editCategory({{ $category->id }})" variant="ghost" size="xs">Edit</flux:button>
                                    <flux:button wire:click="deleteCategory({{ $category->id }})" variant="danger" size="xs">Delete</flux:button>
                                </div>
                            </div>

                            <!-- Subcategories -->
                            @if(in_array($category->id, $expandedCategories))
                                <div class="p-2 bg-[#27272a] border-t border-[#3d3d40]">
                                    @forelse($category->subcategories as $sub)
                                        <div class="flex justify-between items-center px-4 py-3 hover:bg-[#323236] rounded-md transition">
                            <span class="text-zinc-300 text-sm flex items-center">
                                <span class="mr-3 text-zinc-500">—</span> {{ $sub->name }}
                            </span>
                                            <div class="flex gap-2">
                                                <flux:button wire:click="editSubcategory({{ $sub->id }})" variant="ghost" size="xs">Edit</flux:button>
                                                <flux:button wire:click="deleteSubcategory({{ $sub->id }})" variant="danger" size="xs">Delete</flux:button>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="px-4 py-3 text-zinc-500 text-sm italic">No subcategories</p>
                                    @endforelse
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-settings.layout>
</section>
