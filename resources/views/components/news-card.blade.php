@props(['newsItem'])

{{-- Kaart voor één nieuwsitem, gebruikt op de homepage en het nieuwsoverzicht. --}}
<article {{ $attributes->merge(['class' => 'group flex flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:shadow-md']) }}>
    <a href="{{ route('news.show', $newsItem) }}" class="block overflow-hidden" tabindex="-1" aria-hidden="true">
        <img src="{{ $newsItem->imageUrl() }}" alt=""
             class="h-48 w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
    </a>

    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <time datetime="{{ $newsItem->published_at->toDateString() }}">
                {{ $newsItem->published_at->translatedFormat('j F Y') }}
            </time>

            @if ($newsItem->isScheduled())
                <x-badge color="amber">Gepland</x-badge>
            @endif
        </div>

        <h3 class="mt-2 text-lg font-semibold leading-snug text-slate-900">
            <a href="{{ route('news.show', $newsItem) }}" class="transition hover:text-amber-600">
                {{ $newsItem->title }}
            </a>
        </h3>

        <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600">
            {{ Str::limit($newsItem->excerpt, 140) }}
        </p>

        <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4 text-xs text-slate-500">
            <span>
                @if ($newsItem->author)
                    Door {{ $newsItem->author->username }}
                @else
                    Redactie
                @endif
            </span>

            @isset($newsItem->comments_count)
                <span>{{ $newsItem->comments_count }} {{ $newsItem->comments_count === 1 ? 'reactie' : 'reacties' }}</span>
            @endisset
        </div>
    </div>
</article>
