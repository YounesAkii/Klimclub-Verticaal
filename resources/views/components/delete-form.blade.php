@props(['action', 'confirm' => 'Ben je zeker dat je dit wil verwijderen?', 'label' => 'Verwijderen'])

{{-- Kleine herbruikbare verwijderknop. De POST gebeurt met @method('DELETE') en
     een CSRF-token; de bevestiging voorkomt een ongeluk met één klik. --}}
<form method="POST" action="{{ $action }}" onsubmit="return confirm('{{ $confirm }}');"
      {{ $attributes->merge(['class' => 'inline']) }}>
    @csrf
    @method('DELETE')

    <button type="submit" class="text-sm font-medium text-rose-600 transition hover:text-rose-500 hover:underline">
        {{ $label }}
    </button>
</form>
