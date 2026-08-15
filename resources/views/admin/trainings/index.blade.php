<x-admin-layout title="Trainingen">
    <x-slot name="actions">
        <a href="{{ route('admin.trainings.create') }}"
           class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">
            Nieuwe training
        </a>
    </x-slot>

    <x-card flush>
        @if ($trainings->isEmpty())
            <div class="p-5">
                <x-empty-state title="Nog geen trainingen"
                               description="Plan je eerste training in om leden te laten inschrijven." />
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th scope="col" class="px-5 py-3">Training</th>
                            <th scope="col" class="px-5 py-3">Wanneer</th>
                            <th scope="col" class="px-5 py-3">Lesgever</th>
                            <th scope="col" class="px-5 py-3">Inschrijvingen</th>
                            <th scope="col" class="px-5 py-3 text-right">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($trainings as $training)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3">
                                    <a href="{{ route('admin.trainings.show', $training) }}"
                                       class="font-medium text-slate-900 hover:text-amber-700 hover:underline">
                                        {{ $training->title }}
                                    </a>
                                    <p class="text-xs text-slate-400">
                                        {{ ucfirst($training->level) }} &middot; {{ $training->location }}
                                    </p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-slate-600">
                                    {{ $training->starts_at->translatedFormat('j M Y, H:i') }}

                                    @if ($training->hasStarted())
                                        <x-badge class="ml-1">Afgelopen</x-badge>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-slate-600">{{ $training->instructor?->username ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-slate-600">
                                        {{ $training->participants_count }}/{{ $training->capacity }}
                                    </span>

                                    @if ($training->participants_count >= $training->capacity)
                                        <x-badge color="rose" class="ml-1">Volzet</x-badge>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-right">
                                    <a href="{{ route('admin.trainings.edit', $training) }}"
                                       class="text-sm font-medium text-amber-700 hover:underline">Bewerken</a>
                                    <span class="mx-1 text-slate-300">|</span>
                                    <x-delete-form :action="route('admin.trainings.destroy', $training)"
                                                   :confirm="'De training ' . $training->title . ' verwijderen? Alle inschrijvingen verdwijnen mee.'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($trainings->hasPages())
                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $trainings->links() }}
                </div>
            @endif
        @endif
    </x-card>
</x-admin-layout>
