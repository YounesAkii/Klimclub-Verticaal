<x-admin-layout title="Training bewerken">
    <x-slot name="actions">
        <a href="{{ route('admin.trainings.show', $training) }}"
           class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
            Deelnemerslijst
        </a>
        <a href="{{ route('trainings.show', $training) }}"
           class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
            Bekijk op de site
        </a>
    </x-slot>

    <x-card>
        @include('admin.trainings.partials.form', ['action' => route('admin.trainings.update', $training)])
    </x-card>

    <div class="mt-6 rounded-lg border border-rose-200 bg-rose-50 p-5">
        <h2 class="font-semibold text-rose-900">Training verwijderen</h2>
        <p class="mt-1 text-sm text-rose-800">De training en alle inschrijvingen verdwijnen definitief.</p>
        <div class="mt-3">
            <x-delete-form :action="route('admin.trainings.destroy', $training)"
                           :confirm="'De training ' . $training->title . ' verwijderen? Alle inschrijvingen verdwijnen mee.'"
                           label="Definitief verwijderen" />
        </div>
    </div>
</x-admin-layout>
