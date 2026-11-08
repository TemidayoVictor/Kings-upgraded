<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Additional Brand Details') }}</flux:heading>

    <x-settings.layout :heading="__('Additional Brand Details')" :subheading="__('Update your brand information')">
        <form wire:submit="submit">
            <flux:fieldset>
                <div class="space-y-6">
                    <div
                        x-data="{
                            preview: null,

                            init() {
                                this.$watch('$wire.logo', () => {
                                    if (!this.$wire.logo) return;

                                    // Livewire handles the actual upload.
                                });
                            },

                            showPreview(event) {
                                const file = event.target.files[0];

                                if (!file) return;

                                if (this.preview) {
                                    URL.revokeObjectURL(this.preview);
                                }

                                this.preview = URL.createObjectURL(file);

                                // Trigger Livewire upload normally.
                                $wire.upload('logo', file);
                            },

                            clearPreview() {
                                if (this.preview) {
                                    URL.revokeObjectURL(this.preview);
                                    this.preview = null;
                                }
                            }
                        }"
                        class="flex items-center gap-3"
                    >
                        <div class="w-40 h-40 mt-4 shrink-0">
                            <template x-if="preview">
                                <img
                                    :src="preview"
                                    class="w-full h-full object-cover rounded-xl border border-[#eae8e4] bg-[#fcfcf9]"
                                />
                            </template>

                            @if ($currentLogo)
                                <img
                                    x-show="!preview"
                                    src="{{ $user->brand->image ? asset('storage/'.$currentLogo) : asset($currentLogo) }}"
                                    class="w-full h-full object-cover rounded-xl border border-[#eae8e4] bg-[#fcfcf9]"
                                />
                            @endif
                        </div>

                        <div>
                            <flux:label>Brand Logo</flux:label>

                            <input
                                type="file"
                                accept="image/*"
                                @change="showPreview($event)"
                                class="mt-2 block w-full text-sm text-[#2c2b28]
                                file:py-1 file:px-3 file:rounded-sm file:border-0
                                file:text-sm file:font-[440] file:bg-[#f1efec]
                                file:text-[#2e2b28] hover:file:bg-[#e9e6e1]
                                file:transition-colors file:cursor-pointer"
                            />

                            <flux:error name="logo"/>
                        </div>
                    </div>
                    <div
                        x-data="{
                            editor: null,
                            init() {
                                this.editor = new window.TiptapEditor(
                                    this.$refs.editor,
                                    this.$wire,
                                    'about'
                                )
                            }
                        }"
                    >
                        <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            About Brand
                        </label>

                        <div
                            wire:ignore
                            class="outline-none overflow-hidden rounded-lg border border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900"
                        >
                            <div
                                x-ref="editor"
                                class="prose prose-sm max-w-none min-h-[8rem] p-5 [&_.ProseMirror]:outline-none bg-[#3d3d40]"
                            ></div>
                        </div>
                        <p class="mt-1 text-sm text-zinc-500">
                            Tell us more about your brand. Your dream, vision, drive, and what makes your brand stand out.
                        </p>
                    </div>
                    <flux:input label="Brand Motto" wire:model="motto" placeholder="Brand Motto" class="max-full" />
                    {{-- Social Links Information --}}
                    <div class="flex items-start gap-3 rounded-lg border border-amber-200/70 bg-amber-50/60 p-3.5 dark:border-amber-900/40 dark:bg-amber-950/20">
                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">
                            <flux:icon.information-circle class="size-4" />
                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                Social media and website links
                            </p>
                            <p class="mt-1 text-xs leading-relaxed text-zinc-600 dark:text-zinc-400">
                                Please ensure every link starts with
                                <span class="font-semibold text-zinc-800 dark:text-zinc-200">https://</span>
                                or
                                <span class="font-semibold text-zinc-800 dark:text-zinc-200">http://</span>
                                to ensure visitors can access your profiles correctly.
                            </p>
                        </div>
                    </div>
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
