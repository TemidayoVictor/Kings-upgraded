@php
    $hour = now()->hour;
    $brandName = auth()->user()->brand->brand_name;

    if ($hour < 12) {
    $greeting = 'Good Morning';
    $emoji = '☀️';
    $subMessage = $brandName
        ? 'Here’s a quick overview of how ' . $brandName . ' is doing this morning.'
        : 'Here’s a quick overview of your store performance this morning.';
} elseif ($hour < 17) {
    $greeting = 'Good Afternoon';
    $emoji = '🌤️';
    $subMessage = $brandName
        ? 'Here’s a quick overview of how ' . $brandName . ' is performing this afternoon.'
        : 'Here’s a quick overview of your store performance this afternoon.';
} else {
    $greeting = 'Good Evening';
    $emoji = '🌙';
    $subMessage = $brandName
        ? 'Here’s a quick overview of how ' . $brandName . ' performed today.'
        : 'Here’s a quick overview of your store performance today.';
}
@endphp

<div class="relative mb-6 w-full">
    <div class="flex items-center gap-2 mb-1">
        <span class="text-2xl">{{ $emoji }}</span>

        <flux:heading size="xl" level="1">
            {{ $greeting }}, {{ Str::before(auth()->user()->name, ' ') }}
        </flux:heading>

        <flux:button size="sm" variant="primary" href="{{route('shop', auth()->user()->brand)}}">
            View Store
        </flux:button>
    </div>

    <flux:subheading size="lg" class="mb-6 text-gray-400">
        {{ $subMessage }}
    </flux:subheading>

    <flux:separator variant="subtle" />
</div>
