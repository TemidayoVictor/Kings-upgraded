<section class="w-full">
    @include('partials.products-heading')

    <flux:heading class="sr-only">{{ __('Add Product') }}</flux:heading>
    <x-products.layout :heading="__('Add Product')" :subheading="__('Add a new product to your store')">
        <form wire:submit="submit" enctype="multipart/form-data">
            <flux:fieldset>
                <div class="space-y-6">
                    <div>
                        <div class="mb-4">
                            <flux:label>Upload Images (max 5)</flux:label>

                            <!-- Multiple file input -->
                            <div class="flex items-center justify-center w-full mt-2">
                                <label for="images" class="flex flex-col items-center justify-center w-full h-35 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-[#3d3d40]]">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-white">
                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-white">
                                            PNG, JPG or GIF (Max 5MB per file, up to 5 files)
                                        </p>
                                    </div>
                                    <input
                                        id="images"
                                        type="file"
                                        wire:model="images"
                                        multiple
                                        accept="image/jpeg,image/png,image/jpg,image/gif"
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
                                    <span> <i> Processing selected images... </i></span>
                                </div>
                            </div>
                            <!-- Validation errors -->
                            <flux:error name="images"/>
                            <flux:error name="images.*"/>
                        </div>

                        <!-- Preview Section -->
                        @if($images && count($images) > 0)
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-3">
                                    <flux:subheading>Selected Photos ({{ count($images) }})</flux:subheading>
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
                                        <div class="relative group" wire:key="preview-{{ $index }}-{{ now() }}">
                                            <!-- Image Preview -->
                                            <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border-2 border-gray-200 group-hover:border-blue-500 transition-all">
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
                                                wire:click="removePhoto({{ $index }})"
                                                class="absolute -top-2 -right-2 bg-orange-700 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 shadow-lg transform transition-transform hover:scale-110"
                                                title="Remove this photo"
                                            >
                                                ×
                                            </button>

                                            <!-- Index badge -->
                                            <span class="absolute -top-2 -left-2 bg-white text-black text-xs rounded-full w-6 h-6 flex items-center justify-center shadow-lg">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                    <flux:input label="Name of Product" wire:model="name" placeholder="Name of Product" class="max-full" />
                    <flux:textarea label="Brief Description" resize="none" wire:model="description" placeholder="A short description of the product"/>
                    <flux:input label="Original Price" type="number" wire:model="price" placeholder="Original Price" class="max-full"/>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <flux:input label="Sales Price" type="number" wire:model="salesPrice" placeholder="Sales Price" />
                        <flux:input label="Dropshipping Price" type="number" wire:model="dropshippingPrice" placeholder="Dropshipping Price" />
                    </div>

                    <flux:select label="Section" wire:model="sectionId">
                        <option value="">Select Section</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}"> {{$section->name}} </option>
                        @endforeach
                    </flux:select>

                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <flux:input label="Add Link / URL" wire:model="link" placeholder="Link / URL" />
                        <flux:input label="Available Stock" type="number" wire:model="stock" placeholder="Stock" />
                    </div>

                    <flux:separator />

                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary">
                            <flux:icon.loading wire:loading wire:target="submit" />
                            <span wire:loading.remove wire:target="submit">{{ __('Add Product') }}</span>
                        </flux:button>
                    </div>
                </div>
            </flux:fieldset>
        </form>
    </x-products.layout>
</section>
