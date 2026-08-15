<x-admin-layout title="Nieuwe vraag">
    <x-card>
        @include('admin.faqs.partials.form', ['action' => route('admin.faqs.store')])
    </x-card>
</x-admin-layout>
