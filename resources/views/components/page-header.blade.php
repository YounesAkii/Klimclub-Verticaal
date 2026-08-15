@props(['title', 'subtitle' => null])

<header class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>

                @if ($subtitle)
                    <p class="mt-2 max-w-2xl text-slate-600">{{ $subtitle }}</p>
                @endif
            </div>

            {{-- Optionele knoppen rechts van de titel. --}}
            @isset($actions)
                <div class="flex shrink-0 flex-wrap gap-2">{{ $actions }}</div>
            @endisset
        </div>
    </div>
</header>
