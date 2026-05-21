<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Add Brand') }}</flux:heading>
    @if(auth()->user()->role == \App\Enums\UserType::CLIENT)
        <flux:subheading size="lg" class="mb-6">{{ __('Add and manage a new brand') }}</flux:subheading>
    @else
        <flux:subheading size="lg" class="mb-6">{{ __('Add and manage another brand') }}</flux:subheading>
    @endif
    <flux:separator variant="subtle" />
</div>
