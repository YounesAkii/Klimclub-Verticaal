<x-app-layout>
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-slate-900">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>

        <div class="relative mx-auto max-w-6xl px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-wider text-amber-400">Anderlecht, Brussel</p>
                <h1 class="mt-3 text-4xl font-bold tracking-tight text-white sm:text-5xl">
                    Klimmen leer je niet alleen
                </h1>
                <p class="mt-5 text-lg leading-relaxed text-slate-300">
                    Klimclub Verticaal is een club voor wie voor het eerst in een gordel hangt én voor wie al jaren aan
                    hetzelfde project werkt. Vier zalen, een vaste ploeg begeleiders en elke week trainingen waar je
                    zonder ervaring aan kan beginnen.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('trainings.index') }}"
                       class="rounded-md bg-amber-500 px-5 py-2.5 font-semibold text-slate-900 transition hover:bg-amber-400">
                        Bekijk de trainingen
                    </a>

                    @guest
                        <a href="{{ route('register') }}"
                           class="rounded-md border border-slate-600 px-5 py-2.5 font-semibold text-slate-200 transition hover:border-slate-400 hover:text-white">
                            Maak een account aan
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                           class="rounded-md border border-slate-600 px-5 py-2.5 font-semibold text-slate-200 transition hover:border-slate-400 hover:text-white">
                            Naar mijn klimclub
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    {{-- Openingsuren in het kort --}}
    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto grid max-w-6xl gap-6 px-4 py-8 sm:px-6 md:grid-cols-3 lg:px-8">
            @foreach (config('klimclub.opening_hours') as $days => $hours)
                <div class="flex items-baseline justify-between gap-4 rounded-md bg-slate-50 px-4 py-3">
                    <span class="text-sm font-medium text-slate-600">{{ $days }}</span>
                    <span class="font-semibold text-slate-900">{{ $hours }}</span>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Laatste nieuws --}}
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Laatste nieuwtjes</h2>
                <p class="mt-1 text-slate-600">Wat er de voorbije weken gebeurde in en rond de club.</p>
            </div>

            <a href="{{ route('news.index') }}" class="shrink-0 text-sm font-medium text-amber-700 hover:underline">
                Alle nieuws &rarr;
            </a>
        </div>

        @if ($newsItems->isEmpty())
            <x-empty-state class="mt-6" title="Nog geen nieuws"
                           description="Zodra er iets te melden valt, verschijnt het hier." />
        @else
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($newsItems as $newsItem)
                    <x-news-card :news-item="$newsItem" />
                @endforeach
            </div>
        @endif
    </section>

    {{-- Komende trainingen --}}
    <section class="border-y border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">Eerstvolgende trainingen</h2>
                    <p class="mt-1 text-slate-600">Inschrijven kan met je eigen account, tot de training start.</p>
                </div>

                <a href="{{ route('trainings.index') }}" class="shrink-0 text-sm font-medium text-amber-700 hover:underline">
                    Volledige agenda &rarr;
                </a>
            </div>

            @if ($trainings->isEmpty())
                <x-empty-state class="mt-6" title="Nog geen trainingen ingepland"
                               description="De agenda voor het volgende seizoen wordt binnenkort aangevuld." />
            @else
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    @foreach ($trainings as $training)
                        <x-training-card :training="$training" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- FAQ-verwijzing --}}
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-2">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Eerste keer? Begin hier.</h2>
                <p class="mt-3 leading-relaxed text-slate-600">
                    De meeste vragen die we krijgen gaan over hoe je begint, wat het kost en welk materiaal je nodig
                    hebt. We hebben de antwoorden gebundeld per onderwerp. Staat je vraag er niet bij, stuur ons dan
                    gerust een bericht.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('faq.index') }}"
                       class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Naar de FAQ
                    </a>
                    <a href="{{ route('contact.create') }}"
                       class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        Stel je vraag
                    </a>
                </div>
            </div>

            <ul class="grid gap-3 sm:grid-cols-2">
                @foreach ($faqCategories as $category)
                    <li>
                        <a href="{{ route('faq.index') }}#{{ $category->slug }}"
                           class="block h-full rounded-lg border border-slate-200 bg-white p-4 transition hover:border-amber-300 hover:shadow-sm">
                            <span class="font-medium text-slate-900">{{ $category->name }}</span>
                            <span class="mt-1 block text-sm text-slate-500">
                                {{ $category->faqs_count }} {{ $category->faqs_count === 1 ? 'vraag' : 'vragen' }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</x-app-layout>
