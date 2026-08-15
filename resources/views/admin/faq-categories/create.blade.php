<x-admin-layout title="Nieuwe FAQ-categorie">
    <x-card>
        @include('admin.faq-categories.partials.form', ['action' => route('admin.faq-categories.store')])
    </x-card>
</x-admin-layout>
