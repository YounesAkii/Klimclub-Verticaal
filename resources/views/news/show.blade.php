<x-app-layout :title="$newsItem->title" :description="$newsItem->excerpt">
    <article class="bg-white">
        <div class="mx-auto max-w-3xl px-4 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-slate-500">
                <a href="{{ route('news.index') }}" class="hover:text-amber-700 hover:underline">Nieuws</a>
                <span class="mx-2">/</span>
                <span class="text-slate-700">{{ Str::limit($newsItem->title, 50) }}</span>
            </nav>

            <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-slate-500">
                <time datetime="{{ $newsItem->published_at->toDateString() }}">
                    {{ $newsItem->published_at->translatedFormat('j F Y') }}
                </time>

                @if ($newsItem->author)
                    <span aria-hidden="true">&middot;</span>
                    <a href="{{ route('users.show', $newsItem->author) }}" class="hover:text-amber-700 hover:underline">
                        {{ $newsItem->author->username }}
                    </a>
                @endif

                @if ($newsItem->isScheduled())
                    <x-badge color="amber">Gepland &mdash; nog niet publiek zichtbaar</x-badge>
                @endif
            </div>

            <h1 class="mt-3 text-3xl font-bold leading-tight tracking-tight text-slate-900 sm:text-4xl">
                {{ $newsItem->title }}
            </h1>

            <p class="mt-4 text-lg leading-relaxed text-slate-600">{{ $newsItem->excerpt }}</p>
        </div>

        <div class="mx-auto mt-8 max-w-4xl px-4 sm:px-6 lg:px-8">
            <img src="{{ $newsItem->imageUrl() }}" alt="{{ $newsItem->title }}"
                 class="aspect-[16/9] w-full rounded-lg object-cover">
        </div>

        <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
            <x-rich-text :text="$newsItem->content" />

            @auth
                @if (auth()->user()->is_admin)
                    <div class="mt-8 rounded-md border border-amber-200 bg-amber-50 p-4 text-sm">
                        <span class="text-amber-900">Je bekijkt dit als beheerder.</span>
                        <a href="{{ route('admin.news.edit', $newsItem) }}" class="ml-2 font-semibold text-amber-800 hover:underline">
                            Dit item bewerken &rarr;
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </article>

    {{-- Reacties --}}
    <section id="reacties" class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-slate-900">
            {{ $newsItem->comments->count() }}
            {{ $newsItem->comments->count() === 1 ? 'reactie' : 'reacties' }}
        </h2>

        @auth
            <form method="POST" action="{{ route('comments.store', $newsItem) }}" class="mt-6">
                @csrf

                <x-input-label for="body" value="Laat een reactie achter" required />

                <x-textarea id="body" name="body" rows="4" required minlength="3" maxlength="1000"
                            class="mt-1" placeholder="Wat denk jij hierover?">{{ old('body') }}</x-textarea>

                <x-input-error :messages="$errors->get('body')" />

                <div class="mt-3 flex items-center justify-between">
                    <p class="text-xs text-slate-500">Je reageert als {{ auth()->user()->username }}.</p>
                    <x-primary-button>Plaatsen</x-primary-button>
                </div>
            </form>
        @else
            <p class="mt-4 rounded-md border border-slate-200 bg-white p-4 text-sm text-slate-600">
                <a href="{{ route('login') }}" class="font-medium text-amber-700 hover:underline">Log in</a>
                of
                <a href="{{ route('register') }}" class="font-medium text-amber-700 hover:underline">maak een account aan</a>
                om te reageren.
            </p>
        @endauth

        <div class="mt-8 space-y-5">
            @forelse ($newsItem->comments as $comment)
                <div class="flex gap-4 rounded-lg border border-slate-200 bg-white p-4">
                    <x-avatar :user="$comment->author" size="md" />

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
                            <a href="{{ route('users.show', $comment->author) }}"
                               class="font-medium text-slate-900 hover:text-amber-700 hover:underline">
                                {{ $comment->author->username }}
                            </a>
                            <time class="text-xs text-slate-500" datetime="{{ $comment->created_at->toIso8601String() }}">
                                {{ $comment->created_at->diffForHumans() }}
                            </time>
                        </div>

                        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $comment->body }}</p>

                        @can('delete', $comment)
                            <div class="mt-3">
                                <x-delete-form :action="route('comments.destroy', $comment)"
                                               confirm="Deze reactie verwijderen?" label="Verwijderen" />
                            </div>
                        @endcan
                    </div>
                </div>
            @empty
                <x-empty-state title="Nog geen reacties"
                               description="Wees de eerste die iets achterlaat bij dit bericht." />
            @endforelse
        </div>
    </section>

    {{-- Ander nieuws --}}
    @if ($relatedItems->isNotEmpty())
        <section class="border-t border-slate-200 bg-white">
            <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
                <h2 class="text-xl font-bold text-slate-900">Ander nieuws</h2>

                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedItems as $item)
                        <x-news-card :news-item="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-app-layout>
