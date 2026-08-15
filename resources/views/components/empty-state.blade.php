@props(['title' => 'Nog niets te zien', 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-dashed border-slate-300 bg-white px-6 py-12 text-center']) }}>
    <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>

    @if ($description)
        <p class="mx-auto mt-2 max-w-md text-sm text-slate-600">{{ $description }}</p>
    @endif

    @if (trim($slot) !== '')
        <div class="mt-5 flex justify-center gap-2">{{ $slot }}</div>
    @endif
</div>
