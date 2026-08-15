<x-admin-layout title="Contactberichten">
    <div class="mb-6 flex flex-wrap gap-2">
        @php
            $filters = [
                ['label' => 'Alle', 'value' => null],
                ['label' => 'Open (' . $openCount . ')', 'value' => 'open'],
                ['label' => 'Beantwoord', 'value' => 'beantwoord'],
            ];
        @endphp

        @foreach ($filters as $option)
            <a href="{{ route('admin.contact-messages.index', array_filter(['status' => $option['value']])) }}"
               class="rounded-md px-3 py-1.5 text-sm font-medium transition {{ $filter === $option['value'] ? 'bg-slate-900 text-white' : 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50' }}">
                {{ $option['label'] }}
            </a>
        @endforeach
    </div>

    <x-card flush>
        @if ($messages->isEmpty())
            <div class="p-5">
                <x-empty-state title="Geen berichten"
                               description="Er zijn nog geen contactformulieren ingevuld die aan dit filter voldoen." />
            </div>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach ($messages as $message)
                    <li class="flex flex-wrap items-start justify-between gap-4 px-5 py-4 hover:bg-slate-50">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('admin.contact-messages.show', $message) }}"
                                   class="font-medium text-slate-900 hover:text-amber-700 hover:underline">
                                    {{ $message->subject }}
                                </a>

                                @if ($message->isAnswered())
                                    <x-badge color="emerald">Beantwoord</x-badge>
                                @else
                                    <x-badge color="amber">Open</x-badge>
                                @endif
                            </div>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $message->name }} &lt;{{ $message->email }}&gt; &middot;
                                {{ $message->created_at->translatedFormat('j M Y, H:i') }}
                            </p>

                            <p class="mt-2 text-sm text-slate-600">{{ Str::limit($message->message, 160) }}</p>
                        </div>

                        <div class="shrink-0 whitespace-nowrap">
                            <a href="{{ route('admin.contact-messages.show', $message) }}"
                               class="text-sm font-medium text-amber-700 hover:underline">
                                {{ $message->isAnswered() ? 'Bekijken' : 'Antwoorden' }}
                            </a>
                            <span class="mx-1 text-slate-300">|</span>
                            <x-delete-form :action="route('admin.contact-messages.destroy', $message)"
                                           confirm="Dit bericht verwijderen?" />
                        </div>
                    </li>
                @endforeach
            </ul>

            @if ($messages->hasPages())
                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $messages->links() }}
                </div>
            @endif
        @endif
    </x-card>
</x-admin-layout>
