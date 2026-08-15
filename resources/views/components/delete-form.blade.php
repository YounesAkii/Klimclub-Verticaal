@props(['action', 'confirm' => 'Ben je zeker dat je dit wil verwijderen?', 'label' => 'Verwijderen'])

{{-- Kleine herbruikbare verwijderknop. De POST gebeurt met @method('DELETE') en
     een CSRF-token; de bevestiging voorkomt een ongeluk met één klik. --}}
{{-- @js() zet de tekst om naar een veilige JavaScript-string, zodat een titel
     met een apostrof het bevestigingsvenster niet stukmaakt. --}}
<form method="POST" action="{{ $action }}" onsubmit="return confirm(@js($confirm));"
      {{ $attributes->merge(['class' => 'inline']) }}>
    @csrf
    @method('DELETE')

    <button type="submit" class="text-sm font-medium text-rose-600 transition hover:text-rose-500 hover:underline">
        {{ $label }}
    </button>
</form>
