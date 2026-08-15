<x-admin-layout title="Overzicht">
    <x-slot name="actions">
        <a href="{{ route('admin.news.create') }}"
           class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">
            Nieuw bericht
        </a>
        <a href="{{ route('admin.trainings.create') }}"
           class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
            Nieuwe training
        </a>
    </x-slot>

    {{-- Kerncijfers --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($stats as $label => $value)
            <div class="rounded-lg border border-slate-200 bg-white p-5">
                <dt class="text-sm text-slate-500">{{ $label }}</dt>
                <dd class="mt-1 text-3xl font-bold tracking-tight text-slate-900">{{ $value }}</dd>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        {{-- Openstaande berichten --}}
        <x-card title="Onbeantwoorde berichten"
                :subtitle="$unansweredCount === 0 ? 'Alles is beantwoord.' : $unansweredCount . ' bericht(en) wachten op een antwoord.'">
            <x-slot name="actions">
                <a href="{{ route('admin.contact-messages.index') }}" class="text-sm font-medium text-amber-700 hover:underline">
                    Alle berichten
                </a>
            </x-slot>

            @forelse ($unansweredMessages as $message)
                <div class="border-b border-slate-100 py-3 first:pt-0 last:border-b-0 last:pb-0">
                    <a href="{{ route('admin.contact-messages.show', $message) }}"
                       class="font-medium text-slate-900 hover:text-amber-700 hover:underline">
                        {{ $message->subject }}
                    </a>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ $message->name }} &middot; {{ $message->created_at->diffForHumans() }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-slate-500">Er staan geen berichten open.</p>
            @endforelse
        </x-card>

        {{-- Komende trainingen --}}
        <x-card title="Eerstvolgende trainingen">
            <x-slot name="actions">
                <a href="{{ route('admin.trainings.index') }}" class="text-sm font-medium text-amber-700 hover:underline">
                    Alle trainingen
                </a>
            </x-slot>

            @forelse ($upcomingTrainings as $training)
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 py-3 first:pt-0 last:border-b-0 last:pb-0">
                    <div class="min-w-0">
                        <a href="{{ route('admin.trainings.show', $training) }}"
                           class="font-medium text-slate-900 hover:text-amber-700 hover:underline">
                            {{ $training->title }}
                        </a>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $training->starts_at->translatedFormat('j M Y, H:i') }}
                        </p>
                    </div>
                    <span class="shrink-0 text-sm text-slate-500">
                        {{ $training->participants_count }}/{{ $training->capacity }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-slate-500">Er staat niets ingepland.</p>
            @endforelse
        </x-card>

        {{-- Recent nieuws --}}
        <x-card title="Recente nieuwsitems" class="lg:col-span-2">
            <x-slot name="actions">
                <a href="{{ route('admin.news.index') }}" class="text-sm font-medium text-amber-700 hover:underline">
                    Alle nieuwsitems
                </a>
            </x-slot>

            @forelse ($latestNews as $item)
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 py-3 first:pt-0 last:border-b-0 last:pb-0">
                    <div class="min-w-0">
                        <a href="{{ route('admin.news.edit', $item) }}"
                           class="font-medium text-slate-900 hover:text-amber-700 hover:underline">
                            {{ $item->title }}
                        </a>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $item->published_at->translatedFormat('j M Y') }}
                        </p>
                    </div>

                    @if ($item->isScheduled())
                        <x-badge color="amber">Gepland</x-badge>
                    @endif
                </div>
            @empty
                <p class="text-sm text-slate-500">Er zijn nog geen nieuwsitems.</p>
            @endforelse
        </x-card>
    </div>
</x-admin-layout>
