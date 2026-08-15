<x-app-layout title="Profiel bewerken">
    <x-page-header title="Profiel bewerken"
                   subtitle="Deze gegevens verschijnen op je publieke profielpagina.">
        <x-slot name="actions">
            <a href="{{ route('users.show', $user) }}"
               class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                Bekijk mijn profiel
            </a>
        </x-slot>
    </x-page-header>

    <div class="mx-auto max-w-3xl space-y-6 px-4 py-10 sm:px-6 lg:px-8">
        @include('profile.partials.update-profile-information-form')
        @include('profile.partials.update-password-form')
        @include('profile.partials.delete-user-form')
    </div>
</x-app-layout>
