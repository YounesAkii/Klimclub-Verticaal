<x-admin-layout title="Vraag bewerken">
    <x-card>
        @include('admin.faqs.partials.form', ['action' => route('admin.faqs.update', $faq)])
    </x-card>
</x-admin-layout>
