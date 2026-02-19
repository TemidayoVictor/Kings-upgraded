<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        <x-toast position="top-right" duration="5000" />
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
