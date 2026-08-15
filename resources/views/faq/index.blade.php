<x-app-layout title="Veelgestelde vragen"
              description="Antwoorden op de vragen die we het vaakst krijgen over lidmaatschap, veiligheid en trainingen.">
    <x-page-header title="Veelgestelde vragen"
                   subtitle="Gegroepeerd per onderwerp. Staat je vraag er niet bij? Stuur ons gerust een bericht.">
        <x-slot name="actions">
            <a href="{{ route('contact.create') }}"
               class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                Stel je vraag
            </a>
        </x-slot>
    </x-page-header>

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        @if ($categories->isEmpty())
            <x-empty-state title="Nog geen vragen"
                           description="De FAQ wordt op dit moment samengesteld." />
        @else
            <div class="grid gap-10 lg:grid-cols-4">
                {{-- Inhoudstafel --}}
                <nav class="lg:col-span-1">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Onderwerpen</h2>
                    <ul class="mt-3 space-y-1">
                        @foreach ($categories as $category)
                            <li>
                                <a href="#{{ $category->slug }}"
                                   class="block rounded-md px-3 py-2 text-sm text-slate-700 transition hover:bg-white hover:text-amber-700">
                                    {{ $category->name }}
                                    <span class="text-slate-400">({{ $category->faqs->count() }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div class="space-y-8 lg:col-span-3">
                    @foreach ($categories as $category)
                        <section id="{{ $category->slug }}"
                                 class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                            <div class="border-b border-slate-200 px-5 py-4">
                                <h2 class="text-lg font-semibold text-slate-900">{{ $category->name }}</h2>

                                @if ($category->description)
                                    <p class="mt-1 text-sm text-slate-600">{{ $category->description }}</p>
                                @endif
                            </div>

                            <div class="px-5">
                                @forelse ($category->faqs as $faq)
                                    <x-faq-item :faq="$faq" />
                                @empty
                                    <p class="py-5 text-sm text-slate-500">
                                        Er staan nog geen vragen in deze categorie.
                                    </p>
                                @endforelse
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
