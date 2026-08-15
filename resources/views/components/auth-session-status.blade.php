@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-md border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-800']) }}>
        {{ $status }}
    </div>
@endif
