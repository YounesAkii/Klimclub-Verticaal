@php
    // De hoofdnavigatie staat hier als array, zodat de desktop- en de mobiele
    // versie dezelfde bron gebruiken.
    $navigation = [
        ['label' => 'Home', 'route' => 'home', 'active' => 'home'],
        ['label' => 'Nieuws', 'route' => 'news.index', 'active' => 'news.*'],
        ['label' => 'Trainingen', 'route' => 'trainings.index', 'active' => 'trainings.*'],
        ['label' => 'Leden', 'route' => 'users.index', 'active' => 'users.*'],
        ['label' => 'FAQ', 'route' => 'faq.index', 'active' => 'faq.*'],
        ['label' => 'Contact', 'route' => 'contact.create', 'active' => 'contact.*'],
    ];
@endphp

<nav x-data="{ open: false }" class="bg-slate-900 text-slate-100">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold tracking-tight text-white">
                    <x-application-logo class="h-8 w-8 text-amber-400" />
                    <span class="text-lg">Klimclub <span class="text-amber-400">Verticaal</span></span>
                </a>

                <div class="hidden items-center gap-1 md:flex">
                    @foreach ($navigation as $item)
                        <x-nav-link :href="route($item['route'])" :active="request()->routeIs($item['active'])">
                            {{ $item['label'] }}
                        </x-nav-link>
                    @endforeach
                </div>
            </div>

            <div class="hidden items-center gap-3 md:flex">
                @auth
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}"
                           class="rounded-md border border-amber-400/60 px-3 py-1.5 text-sm font-medium text-amber-300 transition hover:bg-amber-400 hover:text-slate-900">
                            Beheer
                        </a>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 rounded-md px-2 py-1.5 text-sm font-medium text-slate-200 transition hover:bg-slate-800">
                                <x-avatar :user="auth()->user()" size="sm" />
                                <span>{{ auth()->user()->username }}</span>
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')">Mijn klimclub</x-dropdown-link>
                            <x-dropdown-link :href="route('users.show', auth()->user())">Mijn publiek profiel</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">Profiel bewerken</x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Uitloggen
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-200 transition hover:text-white">
                        Inloggen
                    </a>
                    <a href="{{ route('register') }}"
                       class="rounded-md bg-amber-400 px-3 py-1.5 text-sm font-semibold text-slate-900 transition hover:bg-amber-300">
                        Word lid
                    </a>
                @endauth
            </div>

            <button @click="open = ! open" class="rounded-md p-2 text-slate-300 transition hover:bg-slate-800 md:hidden"
                    :aria-expanded="open.toString()" aria-label="Menu openen">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path x-show="! open" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobiele navigatie --}}
    <div x-show="open" x-cloak class="border-t border-slate-800 md:hidden">
        <div class="space-y-1 px-4 py-3">
            @foreach ($navigation as $item)
                <x-responsive-nav-link :href="route($item['route'])" :active="request()->routeIs($item['active'])">
                    {{ $item['label'] }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        <div class="border-t border-slate-800 px-4 py-3">
            @auth
                <div class="mb-3 flex items-center gap-3">
                    <x-avatar :user="auth()->user()" size="md" />
                    <div>
                        <div class="text-sm font-semibold text-white">{{ auth()->user()->username }}</div>
                        <div class="text-xs text-slate-400">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="space-y-1">
                    @if (auth()->user()->is_admin)
                        <x-responsive-nav-link :href="route('admin.dashboard')">Beheer</x-responsive-nav-link>
                    @endif
                    <x-responsive-nav-link :href="route('dashboard')">Mijn klimclub</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('users.show', auth()->user())">Mijn publiek profiel</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')">Profiel bewerken</x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Uitloggen
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login')">Inloggen</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">Word lid</x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
