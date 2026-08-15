<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-900 text-slate-800">
        <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-white">
                <x-application-logo class="h-9 w-9 text-amber-400" />
                <span>Klimclub <span class="text-amber-400">Verticaal</span></span>
            </a>

            <div class="mt-8 w-full max-w-md rounded-lg bg-white p-8 shadow-xl">
                {{ $slot }}
            </div>

            <a href="{{ route('home') }}" class="mt-6 text-sm text-slate-400 transition hover:text-slate-200">
                &larr; Terug naar de website
            </a>
        </div>
    </body>
</html>
