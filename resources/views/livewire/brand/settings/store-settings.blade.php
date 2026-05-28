{{-- resources/views/livewire/brand/settings/hero-settings.blade.php --}}
<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Hero Section & Theme Customization') }}</flux:heading>

    <x-settings.layout :heading="__('Hero Banner & Theme Settings')" :subheading="__('Customize the frontpage hero banner content and set up your application theme color space configurations.')">
        <form wire:submit="submit">
            <flux:fieldset>
                <div class="space-y-6">

                    <div class="space-y-2">
                        <flux:label>{{ __('Live Banner Context Preview') }}</flux:label>
                        <div class="rounded-2xl p-4 border border-neutral-200/60 bg-[#faf9f5] overflow-hidden">
                            <div class="rounded-xl overflow-hidden grid grid-cols-1 md:grid-cols-12 items-center p-6 border border-neutral-200/30 relative" style="background-color: {{ $secondary_color ?: '#f7f6f2' }};">
                                <div class="md:col-span-8 space-y-3">
                                    <span class="text-[9px] font-bold tracking-widest uppercase text-neutral-400 block">{{ $hero_tagline ?: 'Tagline Placeholder' }}</span>
                                    <h1 class="text-xl font-light text-neutral-900 leading-tight font-serif">
                                        {{ $hero_title_line_1 ?: 'Heading Part One' }} <br>
                                        <span class="font-normal italic" style="color: {{ $primary_color ?: '#000000' }};">{{ $hero_title_line_2_italic ?: 'Italicized Accent Text' }}</span>
                                    </h1>
                                    <p class="text-xs text-neutral-500 font-light max-w-sm leading-relaxed line-clamp-2">{{ $hero_description ?: 'No descriptive narrative configured.' }}</p>
                                    <div class="pt-1">
                                        <span class="inline-flex bg-neutral-950 text-white text-[10px] tracking-wider uppercase px-4 py-2 rounded-full items-center gap-2">
                                            {{ $hero_button_text ?: 'Call to action' }}
                                            <i class="fa-solid fa-arrow-right-long text-[9px]"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <flux:label class="font-semibold">{{ __('Or Select a Curated Color Palette Preset') }}</flux:label>
                        <flux:description>{{ __('Choose a professionally balanced color space instantly.') }}</flux:description>

                        <!-- Color Preset Matrix Grid Layout Container -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            @foreach($this->colorPresets() as $preset)
                                <button
                                    type="button"
                                    wire:click="setColors('{{ $preset['primary'] }}', '{{ $preset['secondary'] }}')"
                                    class="group text-left p-3 rounded-xl border transition-all duration-200 bg-white shadow-2xs flex flex-col justify-between min-h-[72px] relative focus:outline-hidden {{ $primary_color === $preset['primary'] && $secondary_color === $preset['secondary'] ? 'border-neutral-900 ring-1 ring-neutral-900' : 'border-neutral-200/70 hover:border-neutral-400' }}"
                                >
                                    <div>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-neutral-800 block">{{ $preset['name'] }}</span>
                                        <span class="text-[9px] text-neutral-400 font-light block mt-0.5">{{ $preset['style'] }}</span>
                                    </div>

                                    <!-- Visual Accent Preview Bubbles Layer -->
                                    <div class="flex items-center gap-1.5 mt-2">
                                        <div class="w-4 h-4 rounded-full border border-black/5 shadow-2xs shrink-0" style="background-color: {{ $preset['primary'] }};" title="Primary Accent"></div>
                                        <div class="w-4 h-4 rounded-full border border-black/5 shadow-2xs shrink-0" style="background-color: {{ $preset['secondary'] }};" title="Secondary Base"></div>
                                    </div>

                                    <!-- Selected Indicator Badge Token -->
                                    @if($primary_color === $preset['primary'] && $secondary_color === $preset['secondary'])
                                        <div class="absolute top-2 right-2 w-1.5 h-1.5 rounded-full bg-neutral-900"></div>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <flux:separator />

                    <!-- Keep your existing layout input colors configuration blocks straight underneath -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-neutral-50/60 p-4 rounded-xl border border-neutral-200/50 flex items-center justify-between gap-4">
                            <div>
                                <flux:label class="font-semibold">{{ __('Primary Theme Accent') }}</flux:label>
                                <flux:description>{{ __('Applies to buttons, links, highlights.') }}</flux:description>
                            </div>
                            <input type="color" wire:model.live="primary_color" class="w-12 h-12 rounded-lg border border-neutral-300 cursor-pointer p-0 bg-transparent shrink-0" />
                        </div>

                        <div class="bg-neutral-50/60 p-4 rounded-xl border border-neutral-200/50 flex items-center justify-between gap-4">
                            <div>
                                <flux:label class="font-semibold">{{ __('Secondary Card Surface Background') }}</flux:label>
                                <flux:description>{{ __('Applies to main background shapes.') }}</flux:description>
                            </div>
                            <input type="color" wire:model.live="secondary_color" class="w-12 h-12 rounded-lg border border-neutral-300 cursor-pointer p-0 bg-transparent shrink-0" />
                        </div>
                    </div>

                    <flux:separator />

                    <flux:input label="Hero Section Small Tagline Header" wire:model.live="hero_tagline" placeholder="e.g., curated lifestyle collections" />

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <flux:input label="Primary Heading Title Text (Line 1)" wire:model.live="hero_title_line_1" placeholder="e.g., Elixirs for the" />
                        <flux:input label="Accent Highlight Text (Line 2)" wire:model.live="hero_title_line_2_italic" placeholder="e.g., modern identity." />
                    </div>

                    <flux:textarea label="Hero Informational Sub-Description Description Text Copy Block" resize="none" rows="3" wire:model.live="hero_description" placeholder="Provide a premium descriptive summary anchor text line details here..." />

                    <flux:input label="Action Button Navigation String Context Text" wire:model.live="hero_button_text" placeholder="e.g., Discover Bestsellers" />

                    <flux:separator />

                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary">
                            <flux:icon.loading wire:loading wire:target="submit" />
                            <span wire:loading.remove wire:target="submit">{{ __('Save Changes Configuration') }}</span>
                        </flux:button>
                    </div>
                </div>
            </flux:fieldset>
        </form>
    </x-settings.layout>
</section>
