<x-admin-layout :title="$training->title">
    <x-slot name="actions">
        <a href="{{ route('admin.trainings.edit', $training) }}"
           class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">
            Bewerken
        </a>
        <a href="{{ route('trainings.show', $training) }}"
           class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
            Bekijk op de site
        </a>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <x-card title="Gegevens" class="lg:col-span-1">
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
                    <dd class="font-medium text-slate-900">{{ $training->instructor?->username ?? 'Nog te bepalen' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Bezetting</dt>
                    <dd class="font-medium text-slate-900">
                        {{ $training->participants->count() }} van {{ $training->capacity }}
                    </dd>
                </div>
            </dl>
        </x-card>

        <x-card :title="'Deelnemers (' . $training->participants->count() . ')'" class="lg:col-span-2" flush>
            @if ($training->participants->isEmpty())
                <p class="p-5 text-sm text-slate-500">Er is nog niemand ingeschreven.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th scope="col" class="px-5 py-3">Lid</th>
                                <th scope="col" class="px-5 py-3">E-mail</th>
                                <th scope="col" class="px-5 py-3">Ingeschreven op</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($training->participants as $participant)
                                <tr>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            <x-avatar :user="$participant" size="sm" />
                                            <a href="{{ route('users.show', $participant) }}"
                                               class="font-medium text-slate-900 hover:text-amber-700 hover:underline">
                                                {{ $participant->username }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-slate-600">{{ $participant->email }}</td>
                                    <td class="whitespace-nowrap px-5 py-3 text-slate-600">
                                        {{ $participant->pivot->registered_at->translatedFormat('j M Y, H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-card>
    </div>

    <x-card title="Omschrijving" class="mt-6">
        <x-rich-text :text="$training->description" />
    </x-card>
</x-admin-layout>
