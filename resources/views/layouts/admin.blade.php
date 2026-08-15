@php
    use App\Models\ContactMessage;

    $sections = [
        ['label' => 'Overzicht', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'Nieuws', 'route' => 'admin.news.index', 'active' => 'admin.news.*'],
        ['label' => 'FAQ-categorieën', 'route' => 'admin.faq-categories.index', 'active' => 'admin.faq-categories.*'],
        ['label' => 'FAQ-vragen', 'route' => 'admin.faqs.index', 'active' => 'admin.faqs.*'],
        ['label' => 'Trainingen', 'route' => 'admin.trainings.index', 'active' => 'admin.trainings.*'],
        ['label' => 'Gebruikers', 'route' => 'admin.users.index', 'active' => 'admin.users.*'],
        ['label' => 'Berichten', 'route' => 'admin.contact-messages.index', 'active' => 'admin.contact-messages.*'],
    ];

    $openMessages = ContactMessage::unanswered()->count();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex">

        <title>{{ $title }} — Beheer {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-100 text-slate-800">
        <div x-data="{ open: false }" class="min-h-screen lg:flex">
            {{-- Zijbalk --}}
            <aside class="bg-slate-900 text-slate-300 lg:w-64 lg:shrink-0">
                <div class="flex items-center justify-between px-4 py-4 lg:block">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold text-white">
                        <x-application-logo class="h-7 w-7 text-amber-400" />
                        <span>Beheer</span>
                    </a>

                    <button @click="open = ! open" class="rounded-md p-2 text-slate-300 hover:bg-slate-800 lg:hidden"
                            aria-label="Menu openen">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <nav class="px-3 pb-4 lg:block" :class="open ? 'block' : 'hidden lg:block'">
                    <ul class="space-y-1">
                        @foreach ($sections as $section)
                            <li>
                                <x-admin.nav-link :href="route($section['route'])" :active="request()->routeIs($section['active'])">
                                    {{ $section['label'] }}

                                    @if ($section['route'] === 'admin.contact-messages.index' && $openMessages > 0)
                                        <span class="ml-auto rounded-full bg-amber-400 px-2 py-0.5 text-xs font-semibold text-slate-900">
                                            {{ $openMessages }}
                                        </span>
                                    @endif
                                </x-admin.nav-link>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-6 space-y-1 border-t border-slate-800 pt-4">
                        <x-admin.nav-link :href="route('home')">Terug naar de site</x-admin.nav-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                                Uitloggen
                            </button>
                        </form>
                    </div>
                </nav>
            </aside>

            {{-- Inhoud --}}
            <div class="flex-1">
                <header class="border-b border-slate-200 bg-white">
                    <div class="mx-auto flex max-w-5xl flex-col gap-3 px-4 py-6 sm:px-6 sm:flex-row sm:items-center sm:justify-between lg:px-8">
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>

                        @isset($actions)
                            <div class="flex flex-wrap gap-2">{{ $actions }}</div>
                        @endisset
                    </div>
                </header>

                <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
                    @if (session('status'))
                        <x-alert type="success">{{ session('status') }}</x-alert>
                    @endif

                    @if (session('error'))
                        <x-alert type="error">{{ session('error') }}</x-alert>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
