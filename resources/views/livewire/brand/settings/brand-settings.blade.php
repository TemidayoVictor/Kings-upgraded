<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Brand Details') }}</flux:heading>

    <x-settings.layout :heading="__('Brand Details')" :subheading="__('Update your brand information')">
        <form wire:submit="submit">
            <flux:fieldset>
                <div class="space-y-6">
                    @if($user->brand->status != App\Enums\Status::COMPLETED)
                        <flux:callout icon="bell" variant="warning">
                            <flux:callout.heading>
                                Update Brand Information
                            </flux:callout.heading>

                            <flux:callout.text>
                                Kindly update details about your brand, to get listed and immediately accessible to clients
                            </flux:callout.text>
                        </flux:callout>
                    @endif
                    <flux:input label="Brand Name" wire:model="brandName" placeholder="Brand Name" class="max-full" />

                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <flux:select label="Category" wire:model.live="selectedCategory">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </flux:select>
                        <div>
                            <flux:select label="Subcategory" wire:model="selectedSubcategory">
                                <option>Select Subcategory</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory }}">{{ $subcategory }}</option>
                                @endforeach
                            </flux:select>
                            <small wire:target="selectedCategory" wire:loading> <i>Loading...</i> </small>
                        </div>
                    </div>

                    <flux:select label="Brand Type" wire:model="type">
                        <option value="">Select Brand Type</option>
                        <option value="product">Product Seller [e.g clothes vendor, hair vendor . . .]</option>
                        <option value="service">Service Provider [e.g graphics designer, digital marketer . . .]</option>
                        <!-- ... -->
                    </flux:select>

                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <flux:input label="Description" wire:model="description" placeholder="E.g Clothes Vendor. . ." />
                        <flux:select label="Position" wire:model="position">
                            <option value="">Select Position</option>
                            <option value="C.E.O">C.E.O</option>
                            <option value="Manager">Manager</option>
                            <!-- ... -->
                        </flux:select>
                        <flux:select label="State" wire:model.live="selectedState">
                            <option>Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </flux:select>
                        <div>
                            <flux:select label="City" wire:model="selectedLocalGovernment">
                                <option>Select City</option>
                                @foreach($localGovernments as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </flux:select>
                            <small wire:loading wire:target="selectedState"> <i>Loading...</i> </small>
                        </div>
                    </div>

                    <flux:input label="Address" wire:model="address" placeholder="123 Main St Lagos, 456 Sub St Ibadan" class="max-full" />
                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <flux:input label="Account Number" wire:model="accountNumber" placeholder="E.g 01233456789" />
                        <flux:input label="Bank Name" wire:model="bankName" placeholder="E.g GT Bank. . ." />
                    </div>
                    <flux:input label="Account Name" wire:model="accountName" placeholder="Adekunle Haruna Ciroma" class="max-full" />

                    <flux:separator />

                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary">
                            <flux:icon.loading wire:loading wire:target="submit" />
                            <span wire:loading.remove wire:target="submit">{{ __('Update Profile') }}</span>
                        </flux:button>
                    </div>
                </div>
            </flux:fieldset>
        </form>
    </x-settings.layout>
</section>
