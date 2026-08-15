@props(['faq'])

{{-- Uitklapbare vraag. Alpine houdt bij of het antwoord open staat. --}}
<div x-data="{ open: false }" {{ $attributes->merge(['class' => 'border-b border-slate-200 last:border-b-0']) }}>
    <h3>
        <button type="button" @click="open = ! open" :aria-expanded="open.toString()"
                class="flex w-full items-start justify-between gap-4 px-1 py-4 text-left transition hover:text-amber-700">
            <span class="text-base font-medium text-slate-900">{{ $faq->question }}</span>
            <svg class="mt-1 h-5 w-5 shrink-0 text-slate-400 transition-transform duration-200"
                 :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </button>
    </h3>

    <div x-show="open" x-cloak x-transition.duration.200ms>
        <div class="px-1 pb-5 text-sm leading-relaxed text-slate-600">
            {{-- e() escapet eerst de invoer, nl2br() maakt er daarna regeleindes
                 van. Zo blijven regeleindes behouden zonder XSS-risico. --}}
            {!! nl2br(e($faq->answer)) !!}
        </div>
    </div>
</div>
