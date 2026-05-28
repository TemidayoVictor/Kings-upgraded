@php
    $hour = now()->hour;

    if ($hour < 12) {
    $greeting = 'Good Morning';
    $emoji = '☀️';
    } elseif ($hour < 17) {
    $greeting = 'Good Afternoon';
    $emoji = '🌤️';
    } else {
    $greeting = 'Good Evening';
    $emoji = '🌙';
    }
@endphp

<div class="relative mb-6 w-full">
    <div class="flex items-center gap-2 mb-1">
        <span class="text-2xl">{{ $emoji }}</span>

        <flux:heading size="xl" level="1">
            {{ $greeting }}, {{ Str::before(auth()->user()->name, ' ') }}
        </flux:heading>
    </div>

    <flux:subheading size="lg" class="mb-6 text-gray-400">
        Manage your partnerships
    </flux:subheading>

    <flux:separator variant="subtle" />
</div>
<?php
