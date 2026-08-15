@php
    $isParticipant = auth()->check() && $training->hasParticipant(auth()->user());
    $spotsLeft = $training->spotsLeft();
@endphp

<x-app-layout :title="$training->title" :description="Str::limit(strip_tags($training->description), 150)">
    <x-page-header :title="$training->title"
                   :subtitle="$training->starts_at->translatedFormat('l j F Y') . ' om ' . $training->starts_at->format('H:i')">
        <x-slot name="actions">
            <a href="{{ route('trainings.index') }}"
               class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                Terug naar de agenda
            </a>
        </x-slot>
    </x-page-header>

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <x-card title="Over deze training">
                    <x-rich-text :text="$training->description" />
                </x-card>

                <x-card :title="'Deelnemers (' . $training->participants_count . '/' . $training->capacity . ')'">
                    @if ($training->participants->isEmpty())
                        <p class="text-sm text-slate-500">Er is nog niemand ingeschreven. Wees de eerste.</p>
                    @else
                        <ul class="flex flex-wrap gap-3">
                            @foreach ($training->participants as $participant)
                                <li>
                                    <a href="{{ route('users.show', $participant) }}"
                                       class="flex items-center gap-2 rounded-full border border-slate-200 py-1 pl-1 pr-3 transition hover:border-amber-300 hover:bg-amber-50">
                                        <x-avatar :user="$participant" size="sm" />
                                        <span class="text-sm text-slate-700">{{ $participant->username }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </x-card>
            </div>

            {{-- Praktisch + inschrijven --}}
            <div class="space-y-6">
                <x-card title="Praktisch">
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-slate-500">Wanneer</dt>
                            <dd class="font-medium text-slate-900">
                                {{ $training->starts_at->translatedFormat('l j F Y') }}<br>
                                {{ $training->starts_at->format('H:i') }}&ndash;{{ $training->ends_at->format('H:i') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Locatie</dt>
                            <dd class="font-medium text-slate-900">{{ $training->location }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Niveau</dt>
                            <dd class="font-medium text-slate-900">{{ ucfirst($training->level) }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Lesgever</dt>
                            <dd class="font-medium text-slate-900">
                                @if ($training->instructor)
                                    <a href="{{ route('users.show', $training->instructor) }}" class="text-amber-700 hover:underline">
                                        {{ $training->instructor->username }}
                                    </a>
                                @else
                                    Nog te bepalen
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Vrije plaatsen</dt>
                            <dd class="font-medium text-slate-900">{{ $spotsLeft }} van {{ $training->capacity }}</dd>
                        </div>
                    </dl>
                </x-card>

                <x-card title="Inschrijven">
                    @guest
                        <p class="text-sm text-slate-600">
                            Je hebt een account nodig om je in te schrijven.
                        </p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('login') }}"
                               class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">
                                Inloggen
                            </a>
                            <a href="{{ route('register') }}"
                               class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                Account aanmaken
                            </a>
                        </div>
                    @else
                        @if ($training->hasStarted())
                            <p class="text-sm text-slate-600">
                                Deze training heeft al plaatsgevonden.
                                @if ($isParticipant)
                                    Je was ingeschreven.
                                @endif
                            </p>
                        @elseif ($isParticipant)
                            <x-alert type="success" class="mb-4">Je bent ingeschreven voor deze training.</x-alert>

                            <form method="POST" action="{{ route('trainings.unregister', $training) }}"
                                  onsubmit="return confirm('Je inschrijving annuleren?');">
                                @csrf
                                @method('DELETE')

                                <x-secondary-button type="submit" class="w-full">
                                    Inschrijving annuleren
                                </x-secondary-button>
                            </form>
                        @elseif ($training->isFull())
                            <p class="text-sm text-slate-600">
                                Deze training is volzet. Kijk gerust later nog eens terug: er schrijven regelmatig
                                mensen zich terug uit.
                            </p>
                        @else
                            <p class="text-sm text-slate-600">
                                Er zijn nog {{ $spotsLeft }} {{ $spotsLeft === 1 ? 'plaats' : 'plaatsen' }} vrij.
                            </p>

                            <form method="POST" action="{{ route('trainings.register', $training) }}" class="mt-4">
                                @csrf
                                <x-primary-button class="w-full">Schrijf me in</x-primary-button>
                            </form>
                        @endif
                    @endguest
                </x-card>

                @auth
                    @if (auth()->user()->is_admin)
                        <x-card title="Beheer">
                            <div class="flex flex-wrap gap-3 text-sm">
                                <a href="{{ route('admin.trainings.edit', $training) }}" class="font-medium text-amber-700 hover:underline">
                                    Training bewerken
                                </a>
                                <a href="{{ route('admin.trainings.show', $training) }}" class="font-medium text-amber-700 hover:underline">
                                    Deelnemerslijst
                                </a>
                            </div>
                        </x-card>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
