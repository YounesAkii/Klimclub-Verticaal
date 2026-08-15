<x-admin-layout title="Nieuw bericht">
    <x-card>
        @include('admin.news.partials.form', ['action' => route('admin.news.store')])
    </x-card>
</x-admin-layout>
