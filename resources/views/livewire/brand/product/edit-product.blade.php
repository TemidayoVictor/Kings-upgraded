<section class="w-full">
    @include('partials.products-heading')

    <flux:heading class="sr-only">{{ __('Edit Product') }}</flux:heading>
    <x-products.layout :heading="__('Edit Product')" :subheading="__('Update your product information')">
        <form wire:submit="submit" enctype="multipart/form-data">
            <flux:fieldset>
                <div class="space-y-6">

                    <!-- Images Section -->
                    <div>
                        <div class="mb-4">
                            <flux:label>Product Images (max 5 total)</flux:label>

                            <!-- Existing Images -->
                            @if(count($existingImages) > 0)
                                <div class="mb-6">
                                    <div class="flex justify-between items-center my-3">
                                        <flux:subheading>Current Images ({{ count($existingImages) }})</flux:subheading>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-3">
                                        @foreach($existingImages as $index => $image)
                                            <div class="relative group" wire:key="existing-{{ $image['id'] }}">
                                                <!-- Image Preview -->
                                                <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border-2 border-gray-200 group-hover:border-blue-500 transition-all">
                                                    <img
                                                        src="{{ asset('storage/'.$image['image_path']) }}"
                                                        alt="Product image {{ $index + 1 }}"
                                                        class="w-full h-25 object-cover rounded-xl border border-[#eae8e4] bg-[#fcfcf9]"
                                                        loading="lazy"
                                                    >
                                                </div>

                                                <button
                                                    type="button"
                                                    wire:click="confirmImageDelete({{ $image['id'] }})"
                                                    class="absolute -top-2 -right-2 bg-orange-700 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 shadow-lg transform transition-transform hover:scale-110 group"
                                                    title="Remove this photo"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>

                                                <!-- Index badge -->
                                                <span class="absolute -top-2 -left-2 bg-blue-600 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center shadow-lg">
                                                    {{ $index + 1 }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- New Images Upload -->
                            <div class="mt-4">
                                <flux:subheading class="mb-2">Add New Images</flux:subheading>

                                <!-- Multiple file input -->
                                <div class="flex items-center justify-center w-full mt-2">
                                    <label for="images" class="flex flex-col items-center justify-center w-full h-35 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-[#3d3d40]">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-white">
                                                <span class="font-semibold">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs text-white">
                                                PNG, JPG or JPEG (Max 5MB per file)
                                            </p>
                                        </div>
                                        <input
                                            id="images"
                                            type="file"
                                            wire:model="images"
                                            multiple
                                            accept="image/jpeg,image/png,image/jpg"
                                            class="hidden"
                                        />
                                    </label>
                                </div>

                                <!-- Loading indicator -->
                                <div wire:loading wire:target="images" class="mt-4 p-4">
                                    <div class="flex items-center space-x-3">
                                        <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span><i>Processing selected images...</i></span>
                                    </div>
                                </div>

                                <!-- Validation errors -->
                                <flux:error name="images"/>
                                <flux:error name="images.*"/>
                            </div>

                            <!-- New Images Preview -->
                            @if($images && count($images) > 0)
                                <div class="mb-6 mt-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <flux:subheading>New Images to Add ({{ count($images) }})</flux:subheading>
                                        <button
                                            type="button"
                                            wire:click="$set('images', [])"
                                            class="text-sm text-orange-700 hover:text-red-800"
                                        >
                                            Clear all
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @foreach($images as $index => $image)
                                            <div class="relative group" wire:key="new-{{ $index }}-{{ now() }}">
                                                <!-- Image Preview -->
                                                <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border-2 border-gray-200 group-hover:border-green-500 transition-all">
                                                    <img
                                                        src="{{ $image->temporaryUrl() }}"
                                                        alt="Preview {{ $index + 1 }}"
                                                        class="w-full h-25 object-cover rounded-xl border border-[#eae8e4] bg-[#fcfcf9]"
                                                        loading="lazy"
                                                    >

                                                    <!-- File info overlay on hover -->
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                                                        <div class="text-white text-xs text-center px-2">
                                                            <div>{{ $image->getClientOriginalName() }}</div>
                                                            <div>{{ round($image->getSize() / 1024) }} KB</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Remove button -->
                                                <button
                                                    type="button"
                                                    wire:click="removeNewPhoto({{ $index }})"
                                                    class="absolute -top-2 -right-2 bg-orange-700 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 shadow-lg transform transition-transform hover:scale-110"
                                                    title="Remove this photo"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>

                                                <!-- New badge -->
                                                <span class="absolute -top-2 -left-2 bg-green-600 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center shadow-lg">
                                                    NEW
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Image count summary -->
                            <div class="mt-2 text-sm text-gray-600">
                                Total images: {{ count($existingImages) + count($images) }} / 5
                                @if(count($existingImages) + count($images) > 5)
                                    <span class="text-red-600 ml-2">Maximum 5 images allowed</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <flux:input
                        label="Name of Product"
                        wire:model="name"
                        placeholder="Name of Product"
                        class="max-full"
                    />

                    <flux:textarea
                        label="Brief Description"
                        resize="none"
                        wire:model="description"
                        placeholder="A short description of the product"
                    />

                    <flux:input
                        label="Original Price"
                        type="number"
                        wire:model="price"
                        placeholder="Original Price"
                        class="max-full"
                    />

                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <flux:input
                            label="Sales Price"
                            type="number"
                            wire:model="salesPrice"
                            placeholder="Sales Price"
                        />
                        <flux:input
                            label="Dropshipping Price"
                            type="number"
                            wire:model="dropshippingPrice"
                            placeholder="Dropshipping Price"
                        />
                    </div>

                    <flux:select label="Section" wire:model="sectionId">
                        <option value="">Select Section</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </flux:select>

                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <flux:input
                            label="Add Link / URL"
                            wire:model="link"
                            placeholder="Link / URL"
                        />
                        <flux:input
                            label="Available Stock"
                            type="number"
                            wire:model="stock"
                            placeholder="Stock"
                        />
                    </div>

                    <flux:separator />

                    <div class="flex justify-end space-x-4">
                        <flux:button type="submit" variant="primary">
                            <flux:icon.loading wire:loading wire:target="submit" />
                            <span wire:loading.remove wire:target="submit">{{ __('Update Product') }}</span>
                        </flux:button>
                    </div>
                </div>
            </flux:fieldset>
        </form>
        @if($showDeleteModal)
            <div class="fixed inset-0 bg-black/70 bg-opacity-20 flex items-center justify-center p-4" style="z-index: 50;">
                <div class="bg-[#27272a] rounded-lg shadow-xl max-w-md w-full p-6">
                    <form wire:submit="deleteImage">
                        <flux:fieldset>
                            <div class="space-y-4">
                                <p class="text-white mb-4"> Are you sure you want to delete this image? </p>
                                <div class="flex justify-end items-center">
                                    <flux:button
                                        type="button"
                                        variant="ghost"
                                        wire:click="closeModal"
                                        size="sm"
                                    >
                                        Cancel
                                    </flux:button>
                                    <flux:button type="submit" size="sm" variant="danger" class="ml-2">
                                        <flux:icon.loading wire:loading wire:target="deleteImage" />
                                        <span wire:loading.remove wire:target="deleteImage">{{ __('Delete') }}</span>
                                    </flux:button>
                                </div>
                            </div>
                        </flux:fieldset>
                    </form>
                </div>
            </div>
        @endif
    </x-products.layout>
</section>
