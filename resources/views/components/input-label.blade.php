@props(['value' => null, 'required' => false])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-slate-700']) }}>
    {{ $value ?? $slot }}

    @if ($required)
        <span class="text-rose-600" aria-hidden="true">*</span>
    @endif
</label>
