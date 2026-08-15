@props(['active' => false])

@php
    $classes = $active
        ? 'block rounded-md bg-slate-800 px-3 py-2 text-base font-semibold text-white'
        : 'block rounded-md px-3 py-2 text-base font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} @if ($active) aria-current="page" @endif>
    {{ $slot }}
</a>
