<x-app-layout title="Nieuws" description="Alle nieuwtjes van Klimclub Verticaal.">
    <x-page-header title="Laatste nieuwtjes"
                   subtitle="Verbouwingen, competities, clubreizen en alles wat er verder gebeurt." />

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        @if ($newsItems->isEmpty())
            <x-empty-state title="Nog geen nieuws"
                           description="Er zijn nog geen berichten gepubliceerd. Kom later nog eens terug." />
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($newsItems as $newsItem)
                    <x-news-card :news-item="$newsItem" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $newsItems->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
