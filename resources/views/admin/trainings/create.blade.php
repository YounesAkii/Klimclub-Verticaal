<x-admin-layout title="Nieuwe training">
    <x-card>
        @include('admin.trainings.partials.form', ['action' => route('admin.trainings.store')])
    </x-card>
</x-admin-layout>
