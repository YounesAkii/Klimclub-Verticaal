<x-admin-layout title="Bericht bewerken">
    <x-slot name="actions">
        <a href="{{ route('news.show', $newsItem) }}"
           class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
            Bekijk op de site
        </a>
    </x-slot>

    <x-card>
        @include('admin.news.partials.form', ['action' => route('admin.news.update', $newsItem)])
    </x-card>

    <div class="mt-6 rounded-lg border border-rose-200 bg-rose-50 p-5">
        <h2 class="font-semibold text-rose-900">Bericht verwijderen</h2>
        <p class="mt-1 text-sm text-rose-800">
            Het bericht en alle reacties erop verdwijnen definitief.
        </p>
        <div class="mt-3">
            <x-delete-form :action="route('admin.news.destroy', $newsItem)"
                           :confirm="'Het bericht ' . $newsItem->title . ' verwijderen? De reacties verdwijnen mee.'"
                           label="Definitief verwijderen" />
        </div>
    </div>
</x-admin-layout>
