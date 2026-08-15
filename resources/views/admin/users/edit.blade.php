<x-admin-layout title="Gebruiker bewerken">
    <x-slot name="actions">
        <a href="{{ route('users.show', $user) }}"
           class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
            Publiek profiel
        </a>
    </x-slot>

    <x-card :title="$user->username" :subtitle="'Aangemaakt op ' . $user->created_at->translatedFormat('j F Y')">
        @include('admin.users.partials.form', ['action' => route('admin.users.update', $user)])
    </x-card>

    @unless ($user->is(auth()->user()))
        <div class="mt-6 rounded-lg border border-rose-200 bg-rose-50 p-5">
            <h2 class="font-semibold text-rose-900">Account verwijderen</h2>
            <p class="mt-1 text-sm text-rose-800">
                Het profiel, de reacties en de inschrijvingen van deze gebruiker verdwijnen definitief.
            </p>
            <div class="mt-3">
                <x-delete-form :action="route('admin.users.destroy', $user)"
                               :confirm="'Het account van ' . $user->username . ' verwijderen?'"
                               label="Definitief verwijderen" />
            </div>
        </div>
    @endunless
</x-admin-layout>
