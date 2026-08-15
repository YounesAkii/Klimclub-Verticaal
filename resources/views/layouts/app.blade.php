<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ? $title . ' — ' . config('app.name') : config('app.name') }}</title>
        <meta name="description" content="{{ $description ?? 'Klimclub Verticaal in Anderlecht: klimzaal, boulderzaal, trainingen en een club waar iedereen welkom is.' }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <main class="flex-1">
                {{-- Flash messages verschijnen op elke pagina op dezelfde plek. --}}
                @if (session('status') || session('error'))
                    <div class="mx-auto w-full max-w-6xl px-4 pt-6 sm:px-6 lg:px-8">
                        @if (session('status'))
                            <x-alert type="success">{{ session('status') }}</x-alert>
                        @endif

                        @if (session('error'))
                            <x-alert type="error">{{ session('error') }}</x-alert>
                        @endif
                    </div>
                @endif

                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>
    </body>
</html>
