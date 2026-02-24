<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Dropshipper Details') }}</flux:heading>

    <x-settings.layout :heading="__('Dropshipper Details')" :subheading="__('Update your dropshipper information')">
        <form wire:submit="submit">
            <flux:fieldset>
                <div class="space-y-6">
                    @if($user->dropshipper->status != App\Enums\Status::COMPLETED)
                        <flux:callout icon="bell" variant="warning">
                            <flux:callout.heading>
                                Update Dropshipper Information
                            </flux:callout.heading>

                            <flux:callout.text>
                                Kindly update your details, to complete your signup
                            </flux:callout.text>
                        </flux:callout>
                    @endif

                    <div class="flex gap-3 items-center">
                        @if ($logo || $currentLogo)
                            <div class="w-40 h-40 mt-4">
                                @if($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-cover rounded-xl border border-[#eae8e4] bg-[#fcfcf9]" />
                                @else
                                    <img src="{{ $user->dropshipper->image ? asset('storage/'.$currentLogo) : asset($currentLogo) }}" class="w-full h-full object-cover rounded-xl border border-[#eae8e4] bg-[#fcfcf9]" />
                                @endif
                            </div>
                        @endif
                        <div>
                            <flux:label>Display Picture</flux:label>
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

                    <div>
                        <flux:input label="Username" wire:model.live="username" placeholder="Username" class="max-full" />
                        <small>This will be the name seen by users who visit your stores</small>
                    </div>

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
