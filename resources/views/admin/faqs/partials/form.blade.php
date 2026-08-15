<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf

    @if ($faq->exists)
        @method('PUT')
    @endif

    <div>
        <x-input-label for="faq_category_id" value="Categorie" required />
        <x-select-input id="faq_category_id" name="faq_category_id" class="mt-1" required>
            <option value="">Kies een categorie</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('faq_category_id', $faq->faq_category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </x-select-input>
        <x-input-error :messages="$errors->get('faq_category_id')" />
    </div>

    <div>
        <x-input-label for="question" value="Vraag" required />
        <x-text-input id="question" name="question" type="text" class="mt-1"
                      :value="old('question', $faq->question)" required minlength="10" maxlength="255" />
        <x-input-error :messages="$errors->get('question')" />
    </div>

    <div>
        <x-input-label for="answer" value="Antwoord" required />
        <x-textarea id="answer" name="answer" rows="8" class="mt-1"
                    required minlength="10" maxlength="5000">{{ old('answer', $faq->answer) }}</x-textarea>
        <x-input-error :messages="$errors->get('answer')" />
    </div>

    <div class="max-w-xs">
        <x-input-label for="position" value="Volgorde binnen de categorie" required />
        <x-text-input id="position" name="position" type="number" class="mt-1"
                      :value="old('position', $faq->position ?? 0)" required min="0" max="999" />
        <x-input-error :messages="$errors->get('position')" />
    </div>

    <div class="flex items-center gap-3 border-t border-slate-200 pt-5">
        <x-primary-button>{{ $faq->exists ? 'Wijzigingen opslaan' : 'Vraag toevoegen' }}</x-primary-button>
        <a href="{{ route('admin.faqs.index') }}" class="text-sm text-slate-600 hover:underline">Annuleren</a>
    </div>
</form>
