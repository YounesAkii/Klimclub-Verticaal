<x-admin-layout title="Nieuwe gebruiker">
    <x-card subtitle="Het account is meteen actief; de gebruiker kan zelf later een profielfoto toevoegen."
            title="Gegevens">
        @include('admin.users.partials.form', ['action' => route('admin.users.store')])
    </x-card>
</x-admin-layout>
