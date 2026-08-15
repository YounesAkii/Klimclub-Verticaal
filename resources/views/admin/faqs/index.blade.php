<x-admin-layout title="FAQ-vragen">
    <x-slot name="actions">
        <a href="{{ route('admin.faq-categories.index') }}"
           class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
            Categorieën beheren
        </a>
        <a href="{{ route('admin.faqs.create') }}"
           class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">
            Nieuwe vraag
        </a>
    </x-slot>

    @if ($categories->isEmpty())
        <x-empty-state title="Nog geen categorieën"
                       description="Vragen horen altijd bij een categorie. Maak er eerst een aan.">
            <a href="{{ route('admin.faq-categories.create') }}"
               class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">
                Categorie aanmaken
            </a>
        </x-empty-state>
    @else
        <div class="space-y-6">
            @foreach ($categories as $category)
                <x-card :title="$category->name"
                        :subtitle="$category->faqs->count() . ' ' . ($category->faqs->count() === 1 ? 'vraag' : 'vragen')"
                        flush>
                    @if ($category->faqs->isEmpty())
                        <p class="px-5 py-4 text-sm text-slate-500">Deze categorie bevat nog geen vragen.</p>
                    @else
                        <ul class="divide-y divide-slate-100">
                            @foreach ($category->faqs as $faq)
                                <li class="flex flex-wrap items-start justify-between gap-4 px-5 py-4">
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium text-slate-900">{{ $faq->question }}</p>
                                        <p class="mt-1 text-sm text-slate-600">{{ Str::limit($faq->answer, 140) }}</p>
                                        <p class="mt-1 text-xs text-slate-400">Volgorde: {{ $faq->position }}</p>
                                    </div>

                                    <div class="shrink-0 whitespace-nowrap">
                                        <a href="{{ route('admin.faqs.edit', $faq) }}"
                                           class="text-sm font-medium text-amber-700 hover:underline">Bewerken</a>
                                        <span class="mx-1 text-slate-300">|</span>
                                        <x-delete-form :action="route('admin.faqs.destroy', $faq)"
                                                       confirm="Deze vraag verwijderen?" />
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </x-card>
            @endforeach
        </div>
    @endif
</x-admin-layout>
