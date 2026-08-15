<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf

    @if ($category->exists)
        @method('PUT')
    @endif

    <div>
        <x-input-label for="name" value="Naam" required />
        <x-text-input id="name" name="name" type="text" class="mt-1"
                      :value="old('name', $category->name)" required minlength="3" maxlength="255" />
        <x-input-error :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="description" value="Omschrijving" />
        <x-textarea id="description" name="description" rows="3" class="mt-1"
                    maxlength="500">{{ old('description', $category->description) }}</x-textarea>
        <p class="mt-1 text-xs text-slate-500">Korte uitleg onder de titel van de categorie op de FAQ-pagina.</p>
        <x-input-error :messages="$errors->get('description')" />
    </div>

    <div class="max-w-xs">
        <x-input-label for="position" value="Volgorde" required />
        <x-text-input id="position" name="position" type="number" class="mt-1"
                      :value="old('position', $category->position ?? 0)" required min="0" max="999" />
        <p class="mt-1 text-xs text-slate-500">Lagere getallen staan bovenaan.</p>
        <x-input-error :messages="$errors->get('position')" />
    </div>

    <div class="flex items-center gap-3 border-t border-slate-200 pt-5">
        <x-primary-button>{{ $category->exists ? 'Wijzigingen opslaan' : 'Categorie aanmaken' }}</x-primary-button>
        <a href="{{ route('admin.faq-categories.index') }}" class="text-sm text-slate-600 hover:underline">Annuleren</a>
    </div>
</form>
