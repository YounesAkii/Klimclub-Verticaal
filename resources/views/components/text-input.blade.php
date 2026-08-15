@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'block w-full rounded-md border-slate-300 shadow-sm transition focus:border-amber-500 focus:ring-amber-500 disabled:bg-slate-100 disabled:text-slate-500']) }}>
