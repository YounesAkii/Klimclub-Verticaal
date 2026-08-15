@props(['training'])

@php
    $levelColors = ['beginner' => 'emerald', 'gevorderd' => 'rose', 'alle niveaus' => 'sky'];
    $spotsLeft = $training->spotsLeft();
@endphp

<article {{ $attributes->merge(['class' => 'flex flex-col rounded-lg border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md']) }}>
    <div class="flex flex-wrap items-center gap-2">
        <x-badge :color="$levelColors[$training->level] ?? 'slate'">{{ ucfirst($training->level) }}</x-badge>

        @if ($training->hasStarted())
            <x-badge>Afgelopen</x-badge>
        @elseif ($training->isFull())
            <x-badge color="rose">Volzet</x-badge>
        @else
            <x-badge color="amber">Nog {{ $spotsLeft }} {{ $spotsLeft === 1 ? 'plaats' : 'plaatsen' }}</x-badge>
        @endif
    </div>

    <h3 class="mt-3 text-lg font-semibold leading-snug text-slate-900">
        <a href="{{ route('trainings.show', $training) }}" class="transition hover:text-amber-600">
            {{ $training->title }}
        </a>
    </h3>

    <dl class="mt-3 space-y-1 text-sm text-slate-600">
        <div class="flex gap-2">
            <dt class="w-20 shrink-0 text-slate-400">Wanneer</dt>
            <dd>
                {{ $training->starts_at->translatedFormat('l j F') }},
                {{ $training->starts_at->format('H:i') }}&ndash;{{ $training->ends_at->format('H:i') }}
            </dd>
        </div>
        <div class="flex gap-2">
            <dt class="w-20 shrink-0 text-slate-400">Waar</dt>
            <dd>{{ $training->location }}</dd>
        </div>
        <div class="flex gap-2">
            <dt class="w-20 shrink-0 text-slate-400">Lesgever</dt>
            <dd>
                @if ($training->instructor)
                    <a href="{{ route('users.show', $training->instructor) }}" class="text-amber-700 hover:underline">
                        {{ $training->instructor->username }}
                    </a>
                @else
                    Nog te bepalen
                @endif
            </dd>
        </div>
    </dl>

    <div class="mt-4 flex flex-1 items-end justify-between border-t border-slate-100 pt-4">
        <a href="{{ route('trainings.show', $training) }}" class="text-sm font-medium text-amber-700 hover:underline">
            Meer info &rarr;
        </a>

        @auth
            @if ($training->hasParticipant(auth()->user()))
                <x-badge color="emerald">Ingeschreven</x-badge>
            @endif
        @endauth
    </div>
</article>
