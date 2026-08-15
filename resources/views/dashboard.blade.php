<x-app-layout title="Mijn klimclub">
    <x-page-header title="Mijn klimclub"
                   :subtitle="'Welkom terug, ' . $user->username . '.'">
        <x-slot name="actions">
            <a href="{{ route('users.show', $user) }}"
               class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                Mijn publiek profiel
            </a>
            <a href="{{ route('profile.edit') }}"
               class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                Profiel bewerken
            </a>
        </x-slot>
    </x-page-header>

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <x-card title="Mijn komende trainingen"
                        subtitle="Uitschrijven kan tot de training start.">
                    @forelse ($upcomingTrainings as $training)
                        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 py-4 first:pt-0 last:border-b-0 last:pb-0">
                            <div class="min-w-0">
                                <a href="{{ route('trainings.show', $training) }}"
                                   class="font-medium text-slate-900 hover:text-amber-700 hover:underline">
                                    {{ $training->title }}
                                </a>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $training->starts_at->translatedFormat('l j F') }} om
                                    {{ $training->starts_at->format('H:i') }} &middot; {{ $training->location }}
                                </p>
                            </div>

                            <form method="POST" action="{{ route('trainings.unregister', $training) }}"
                                  onsubmit="return confirm('Je inschrijving voor {{ $training->title }} annuleren?');">
                                @csrf
                                @method('DELETE')
                                <x-secondary-button type="submit">Uitschrijven</x-secondary-button>
                            </form>
                        </div>
                    @empty
                        <x-empty-state title="Je staat nog nergens ingeschreven"
                                       description="Bekijk de agenda en schrijf je in voor een training die je aanspreekt.">
                            <a href="{{ route('trainings.index') }}"
                               class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">
                                Naar de agenda
                            </a>
                        </x-empty-state>
                    @endforelse
                </x-card>

                @if ($pastTrainings->isNotEmpty())
                    <x-card title="Eerder gevolgd">
                        <ul class="space-y-2 text-sm">
                            @foreach ($pastTrainings as $training)
                                <li class="flex justify-between gap-4">
                                    <a href="{{ route('trainings.show', $training) }}" class="text-slate-700 hover:text-amber-700 hover:underline">
                                        {{ $training->title }}
                                    </a>
                                    <span class="shrink-0 text-slate-500">
                                        {{ $training->starts_at->translatedFormat('j M Y') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </x-card>
                @endif
            </div>

            <div class="space-y-6">
                <x-card title="Mijn gegevens">
                    <div class="flex items-center gap-4">
                        <x-avatar :user="$user" size="lg" />
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-900">{{ $user->username }}</p>
                            <p class="truncate text-sm text-slate-500">{{ $user->email }}</p>
                        </div>
                    </div>

                    <dl class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-500">Naam</dt>
                            <dd class="font-medium text-slate-900">{{ $user->name }}</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-500">Verjaardag</dt>
                            <dd class="font-medium text-slate-900">
                                {{ $user->birthday?->translatedFormat('j F Y') ?? 'Niet ingevuld' }}
                            </dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-500">Rol</dt>
                            <dd class="font-medium text-slate-900">{{ $user->is_admin ? 'Beheerder' : 'Lid' }}</dd>
                        </div>
                    </dl>
                </x-card>

                <x-card title="Recent nieuws">
                    @forelse ($latestNews as $item)
                        <div class="border-b border-slate-100 py-3 first:pt-0 last:border-b-0 last:pb-0">
                            <a href="{{ route('news.show', $item) }}"
                               class="text-sm font-medium text-slate-900 hover:text-amber-700 hover:underline">
                                {{ $item->title }}
                            </a>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ $item->published_at->translatedFormat('j F Y') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Nog geen nieuws.</p>
                    @endforelse
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
