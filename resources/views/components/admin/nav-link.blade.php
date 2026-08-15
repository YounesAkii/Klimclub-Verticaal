@props(['active' => false])

@php
    $classes = $active
        ? 'flex items-center gap-2 rounded-md bg-slate-800 px-3 py-2 text-sm font-semibold text-white'
        : 'flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} @if ($active) aria-current="page" @endif>
    {{ $slot }}
</a>
