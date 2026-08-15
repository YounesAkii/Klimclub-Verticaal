@props(['user', 'size' => 'md'])

@php
    $sizes = [
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-16 w-16 text-lg',
        'xl' => 'h-28 w-28 text-3xl',
    ];

    $classes = $sizes[$size] ?? $sizes['md'];
    $url = $user->avatarUrl();
@endphp

@if ($url)
    <img src="{{ $url }}" alt="Profielfoto van {{ $user->username }}"
         {{ $attributes->merge(['class' => 'shrink-0 rounded-full object-cover ring-2 ring-white/20 ' . $classes]) }}>
@else
    {{-- Geen foto geüpload: toon de initialen in plaats van een gebroken afbeelding. --}}
    <span {{ $attributes->merge(['class' => 'inline-flex shrink-0 items-center justify-center rounded-full bg-slate-600 font-semibold text-white ring-2 ring-white/20 ' . $classes]) }}
          aria-label="Profielfoto van {{ $user->username }}">
        {{ $user->initials() }}
    </span>
@endif
