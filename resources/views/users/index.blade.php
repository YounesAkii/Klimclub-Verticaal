<x-app-layout title="Leden" description="De leden van Klimclub Verticaal.">
    <x-page-header title="Leden"
                   subtitle="Iedereen met een account op deze site. Klik door voor het publieke profiel." />

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('users.index') }}" class="mb-8 flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-64">
                <x-input-label for="zoek" value="Zoek op naam of gebruikersnaam" />
                <x-text-input id="zoek" name="zoek" type="search" class="mt-1" :value="$search"
                              maxlength="50" placeholder="bv. lotte" />
            </div>

            <x-primary-button>Zoeken</x-primary-button>

            @if ($search !== '')
                <a href="{{ route('users.index') }}" class="pb-2 text-sm text-slate-500 hover:underline">Wissen</a>
            @endif
        </form>

        @if ($users->isEmpty())
            <x-empty-state title="Geen leden gevonden"
                           description="Probeer een andere zoekterm." />
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($users as $user)
                    <a href="{{ route('users.show', $user) }}"
                       class="flex items-start gap-4 rounded-lg border border-slate-200 bg-white p-4 transition hover:border-amber-300 hover:shadow-sm">
                        <x-avatar :user="$user" size="lg" />

                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-semibold text-slate-900">{{ $user->username }}</span>

                                @if ($user->is_admin)
                                    <x-badge color="amber">Beheerder</x-badge>
                                @endif
                            </div>

                            <p class="mt-1 truncate text-sm text-slate-500">{{ $user->name }}</p>

                            @if ($user->bio)
                                <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ Str::limit($user->bio, 90) }}</p>
                            @endif

                            <p class="mt-2 text-xs text-slate-400">
                                {{ $user->trainings_count }}
                                {{ $user->trainings_count === 1 ? 'inschrijving' : 'inschrijvingen' }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
