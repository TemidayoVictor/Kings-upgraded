<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        {{-- Tailwind Css  --}}
        @vite('resources/css/app.css')
        @fluxAppearance
        @livewireStyles
        {{--    Using Inter Font Family    --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo-Crown.svg') }}">
        <title>KING'S | {{ $title ?? ''  }} </title>
    </head>
    <body x-data>
        <div>
            {{-- Toast from notify --}}
            <x-toast position="top-right" duration="5000" />
            {{ $slot }}
        </div>
    </body>
    {{--  Flux  --}}
    @fluxScripts
    @livewireScripts
</html>
