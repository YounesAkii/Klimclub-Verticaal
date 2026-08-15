@props(['title' => null, 'subtitle' => null, 'flush' => false])

{{-- Witte kaart met optionele kop. Met flush krijgt de inhoud geen padding,
     handig voor tabellen die tot tegen de rand mogen lopen. --}}
<section {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm']) }}>
    @if ($title)
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-5 py-4">
            <div>
                <h2 class="font-semibold text-slate-900">{{ $title }}</h2>

                @if ($subtitle)
                    <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
                @endif
            </div>

            @isset($actions)
                <div class="flex gap-2">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    <div class="{{ $flush ? '' : 'p-5' }}">
        {{ $slot }}
    </div>
</section>
