<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your personal information')">
        @if(auth()->user()->onboarding_step != App\Enums\Status::COMPLETED)
            <flux:callout icon="bell" variant="warning">
                <flux:callout.heading>
                    Complete Profile
                </flux:callout.heading>

                <flux:callout.text>
                    Kindly complete your profile below to proceed
                </flux:callout.text>
            </flux:callout>
        @endif
        <form wire:submit="submit"  class="my-6 w-full space-y-6">
            <div>
                <flux:input wire:model="phone" :label="__('Phone number (preferably whatsapp)')" type="text" required autocomplete="phone" />
                <small>This will be your primary source of contact</small>
            </div>
            <div>
                <flux:input wire:model="name" :label="__('Name')" type="text" required autocomplete="name" />
            </div>
            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" readonly />
                <small class="mt-1">To change email, kindly contact support</small>
            </div>

            <flux:separator />

            <div class="max-w-2xl mx-auto p-6 bg-[#27272a] border border-[#3d3d40] rounded-lg">
                <!-- Header -->
                <div class="md:flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-medium text-white">Your Preferences</h2>
                        <p class="text-sm text-white mt-1">Select activities and interests you enjoy</p>
                    </div>
                    <span class="inline-block ext-sm bg-gray-100 px-3 py-1 rounded-md text-gray-600 mt-3">
                        {{ count($selectedPreferences) }} selected
                    </span>
                </div>

                <!-- Search -->
                <div class="mb-6">
                    <flux:input type="text"
                           wire:model.live.debounce="search"
                           placeholder="Search preferences..."/>
                </div>

                <!-- Selected Preferences Summary (if any) -->
                @if(count($selectedPreferences) > 0)
                    <div class="mb-6 p-4 bg-[#3d3d40] rounded-xl">
                        <p class="text-sm font-medium text-white mb-2">Your selected preferences:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allPreferences->whereIn('id', $selectedPreferences) as $pref)
                                <span class="text-black inline-flex items-center gap-1 px-3 py-1 bg-white rounded-md text-sm border border-blue-200">
                                    {{ $pref->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Preferences Grid -->
                <div class="space-y-4">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @forelse($allPreferences as $preference)
                            <button wire:click="togglePreference({{ $preference->id }})"
                                type="button"
                                class="text-white hover:text-black relative flex items-center p-2 border border-[#3d3d40] rounded-lg transition-all duration-200 {{ in_array($preference->id, $selectedPreferences) ? 'border-white': 'border-[#3d3d40] hover:border-[#3d3d40] hover:bg-[#3d3d40] '}}">
                                @if($preference->icon)
                                    <span class="mr-2 text-lg">{{ $preference->icon }}</span>
                                @endif
                                <span class="text-sm  {{ in_array($preference->id, $selectedPreferences) ? 'font-medium text-white' : 'text-white' }}">
                                    {{ $preference->name }}
                                </span>
                                <!-- Checkmark for selected -->
                                @if(in_array($preference->id, $selectedPreferences))
                                    <span class="absolute top-1 right-1 text-white">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @endif
                            </button>
                        @empty
                            <p class="text-white text-center py-8 w-full">No preferences found</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <flux:separator />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">
                    <flux:icon.loading wire:loading wire:target="submit" />
                    <span wire:loading.remove wire:target="submit">{{ __('Update Profile') }}</span>
                </flux:button>
            </div>
        </form>
    </x-settings.layout>
</section>
