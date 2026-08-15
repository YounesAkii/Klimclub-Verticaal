<textarea {{ $attributes->merge(['rows' => 5, 'class' => 'block w-full rounded-md border-slate-300 shadow-sm transition focus:border-amber-500 focus:ring-amber-500']) }}>{{ $slot }}</textarea>
