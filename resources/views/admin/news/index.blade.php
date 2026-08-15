<x-admin-layout title="Nieuws">
    <x-slot name="actions">
        <a href="{{ route('admin.news.create') }}"
           class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">
            Nieuw bericht
        </a>
    </x-slot>

    <x-card flush>
        @if ($newsItems->isEmpty())
            <div class="p-5">
                <x-empty-state title="Nog geen nieuwsitems"
                               description="Maak je eerste bericht aan om het op de site te tonen." />
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th scope="col" class="px-5 py-3">Titel</th>
                            <th scope="col" class="px-5 py-3">Publicatie</th>
                            <th scope="col" class="px-5 py-3">Auteur</th>
                            <th scope="col" class="px-5 py-3">Reacties</th>
                            <th scope="col" class="px-5 py-3 text-right">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($newsItems as $newsItem)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $newsItem->imageUrl() }}" alt=""
                                             class="h-10 w-16 shrink-0 rounded object-cover" loading="lazy">
                                        <div class="min-w-0">
                                            <a href="{{ route('news.show', $newsItem) }}"
                                               class="font-medium text-slate-900 hover:text-amber-700 hover:underline">
                                                {{ $newsItem->title }}
                                            </a>
                                            <p class="text-xs text-slate-400">/{{ $newsItem->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-slate-600">
                                    {{ $newsItem->published_at->translatedFormat('j M Y') }}

                                    @if ($newsItem->isScheduled())
                                        <x-badge color="amber" class="ml-1">Gepland</x-badge>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-slate-600">
                                    {{ $newsItem->author?->username ?? '—' }}
                                </td>
                                <td class="px-5 py-3 text-slate-600">{{ $newsItem->comments_count }}</td>
                                <td class="whitespace-nowrap px-5 py-3 text-right">
                                    <a href="{{ route('admin.news.edit', $newsItem) }}"
                                       class="text-sm font-medium text-amber-700 hover:underline">Bewerken</a>
                                    <span class="mx-1 text-slate-300">|</span>
                                    <x-delete-form :action="route('admin.news.destroy', $newsItem)"
                                                   :confirm="'Het bericht ' . $newsItem->title . ' verwijderen? De reacties verdwijnen mee.'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($newsItems->hasPages())
                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $newsItems->links() }}
                </div>
            @endif
        @endif
    </x-card>
</x-admin-layout>
