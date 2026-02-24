<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Additional Brand Details') }}</flux:heading>

    <x-settings.layout :heading="__('Additional Brand Details')" :subheading="__('Update your brand information')">
        <form wire:submit="submit">
            <flux:fieldset>
                <div class="space-y-6">
                    <div class="flex gap-3 items-center">
                        @if ($logo || $currentLogo)
                            <div class="w-40 h-40 mt-4">
                                @if($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-cover rounded-xl border border-[#eae8e4] bg-[#fcfcf9]" />
                                @else
                                    <img src="{{ $user->brand->image ? asset('storage/'.$currentLogo) : asset($currentLogo) }}" class="w-full h-full object-cover rounded-xl border border-[#eae8e4] bg-[#fcfcf9]" />
                                @endif
                            </div>
                        @endif
                        <div>
                            <flux:label>Brand Logo</flux:label>
                            <input type="file" wire:model="logo" accept="image/*"
                                   class="mt-2 block w-full text-sm text-[#2c2b28]
                               file:py-1 file:px-3 file:rounded-sm file:border-0
                               file:text-sm file:font-[440] file:bg-[#f1efec]
                             file:text-[#2e2b28] hover:file:bg-[#e9e6e1] file:transition-colors
                                file:cursor-pointer"
                            />
                            <flux:error name="logo"/>
                        </div>
                    </div>
                    <flux:textarea label="About Brand" resize="none" wire:model="about" placeholder="Tell us more about your brand. Your dream, vision, drive, and what makes your brand stand out"/>
                    <flux:input label="Brand Motto" wire:model="motto" placeholder="Brand Motto" class="max-full" />
                    <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                        <flux:input label="Instagram" wire:model="instagram" placeholder="@username" />
                        <flux:input label="Tiktok" wire:model="tiktok" placeholder="@username" />
                        <flux:input label="LinkedIn" wire:model="linkedin" placeholder="https://linkedin.com" />
                        <flux:input label="X(Twitter)" wire:model="twitter" placeholder="@username" />
                        <flux:input label="Facebook" wire:model="facebook" placeholder="https://facebook.com" />
                        <flux:input label="Youtube" wire:model="youtube" placeholder="https://youtube.com" />
                    </div>
                    <flux:input label="Website" wire:model="website" placeholder="https://website.com" class="max-full"/>

                    <flux:separator />

                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary">
                            <flux:icon.loading wire:loading wire:target="submit" />
                            <span wire:loading.remove wire:target="submit">{{ __('Update Details') }}</span>
                        </flux:button>
                    </div>
                </div>
            </flux:fieldset>
        </form>
    </x-settings.layout>
</section>
