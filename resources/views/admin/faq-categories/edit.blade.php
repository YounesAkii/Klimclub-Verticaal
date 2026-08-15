<x-admin-layout title="Categorie bewerken">
    <x-card>
        @include('admin.faq-categories.partials.form', ['action' => route('admin.faq-categories.update', $category)])
    </x-card>
</x-admin-layout>
