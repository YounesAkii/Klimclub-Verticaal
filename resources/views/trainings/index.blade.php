<x-app-layout title="Trainingen" description="De trainingsagenda van Klimclub Verticaal.">
    <x-page-header title="Trainingen"
                   subtitle="Initiaties, techniekavonden en cursussen. Schrijf je in met je eigen account." />

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        {{-- Filters --}}
        <form method="GET" action="{{ route('trainings.index') }}"
              class="mb-8 flex flex-wrap items-end gap-4 rounded-lg border border-slate-200 bg-white p-4">
            <div>
                <x-input-label for="niveau" value="Niveau" />
                <x-select-input id="niveau" name="niveau" class="mt-1 w-48">
                    <option value="">Alle</option>
                    @foreach (['beginner', 'gevorderd', 'alle niveaus'] as $option)
                        <option value="{{ $option }}" @selected($level === $option)>{{ ucfirst($option) }}</option>
                    @endforeach
                </x-select-input>
            </div>

            <div>
                <x-input-label for="periode" value="Periode" />
                <x-select-input id="periode" name="periode" class="mt-1 w-48">
                    <option value="">Komende trainingen</option>
                    <option value="voorbij" @selected($showPast)>Afgelopen trainingen</option>
                </x-select-input>
            </div>

            <x-primary-button>Filteren</x-primary-button>

            @if ($level || $showPast)
                <a href="{{ route('trainings.index') }}" class="pb-2 text-sm text-slate-500 hover:underline">
                    Filters wissen
                </a>
            @endif
        </form>

        @if ($trainings->isEmpty())
            <x-empty-state title="Geen trainingen gevonden"
                           description="Er staat niets ingepland dat aan deze filters voldoet." />
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($trainings as $training)
                    <x-training-card :training="$training" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $trainings->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
