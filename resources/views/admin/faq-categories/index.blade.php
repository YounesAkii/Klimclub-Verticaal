<x-admin-layout title="FAQ-categorieën">
    <x-slot name="actions">
        <a href="{{ route('admin.faq-categories.create') }}"
           class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">
            Nieuwe categorie
        </a>
    </x-slot>

    <x-card flush>
        @if ($categories->isEmpty())
            <div class="p-5">
                <x-empty-state title="Nog geen categorieën"
                               description="Maak eerst een categorie aan; daarna kan je er vragen aan toevoegen." />
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th scope="col" class="px-5 py-3">Volgorde</th>
                            <th scope="col" class="px-5 py-3">Naam</th>
                            <th scope="col" class="px-5 py-3">Omschrijving</th>
                            <th scope="col" class="px-5 py-3">Vragen</th>
                            <th scope="col" class="px-5 py-3 text-right">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($categories as $category)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 text-slate-500">{{ $category->position }}</td>
                                <td class="px-5 py-3">
                                    <span class="font-medium text-slate-900">{{ $category->name }}</span>
                                    <p class="text-xs text-slate-400">/{{ $category->slug }}</p>
                                </td>
                                <td class="px-5 py-3 text-slate-600">
                                    {{ Str::limit($category->description, 70) ?: '—' }}
                                </td>
                                <td class="px-5 py-3 text-slate-600">{{ $category->faqs_count }}</td>
                                <td class="whitespace-nowrap px-5 py-3 text-right">
                                    <a href="{{ route('admin.faq-categories.edit', $category) }}"
                                       class="text-sm font-medium text-amber-700 hover:underline">Bewerken</a>
                                    <span class="mx-1 text-slate-300">|</span>
                                    <x-delete-form :action="route('admin.faq-categories.destroy', $category)"
                                                   :confirm="'De categorie ' . $category->name . ' verwijderen? De ' . $category->faqs_count . ' vragen erin verdwijnen mee.'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>
</x-admin-layout>
