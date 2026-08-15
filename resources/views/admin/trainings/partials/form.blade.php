<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf

    @if ($training->exists)
        @method('PUT')
    @endif

    <div>
        <x-input-label for="title" value="Titel" required />
        <x-text-input id="title" name="title" type="text" class="mt-1"
                      :value="old('title', $training->title)" required minlength="5" maxlength="255" />
        <x-input-error :messages="$errors->get('title')" />
    </div>

    <div>
        <x-input-label for="slug" value="Slug" />
        <x-text-input id="slug" name="slug" type="text" class="mt-1"
                      :value="old('slug', $training->slug)" maxlength="255" pattern="[a-z0-9-]+" />
        <p class="mt-1 text-xs text-slate-500">Laat leeg om de slug uit de titel af te leiden.</p>
        <x-input-error :messages="$errors->get('slug')" />
    </div>

    <div>
        <x-input-label for="description" value="Omschrijving" required />
        <x-textarea id="description" name="description" rows="8" class="mt-1"
                    required minlength="30">{{ old('description', $training->description) }}</x-textarea>
        <p class="mt-1 text-xs text-slate-500">Laat een lege regel tussen twee alinea's.</p>
        <x-input-error :messages="$errors->get('description')" />
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <x-input-label for="starts_at" value="Start" required />
            <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="mt-1"
                          :value="old('starts_at', $training->starts_at?->format('Y-m-d\TH:i'))" required />
            <x-input-error :messages="$errors->get('starts_at')" />
        </div>

        <div>
            <x-input-label for="ends_at" value="Einde" required />
            <x-text-input id="ends_at" name="ends_at" type="datetime-local" class="mt-1"
                          :value="old('ends_at', $training->ends_at?->format('Y-m-d\TH:i'))" required />
            <x-input-error :messages="$errors->get('ends_at')" />
        </div>

        <div>
            <x-input-label for="location" value="Locatie" required />
            <x-text-input id="location" name="location" type="text" class="mt-1"
                          :value="old('location', $training->location)" required maxlength="255"
                          list="locaties" />
            <datalist id="locaties">
                <option value="Hoofdzaal"></option>
                <option value="Boulderzaal"></option>
                <option value="Buitenmuur"></option>
                <option value="Clublokaal"></option>
            </datalist>
            <x-input-error :messages="$errors->get('location')" />
        </div>

        <div>
            <x-input-label for="level" value="Niveau" required />
            <x-select-input id="level" name="level" class="mt-1" required>
                @foreach (['beginner', 'gevorderd', 'alle niveaus'] as $level)
                    <option value="{{ $level }}" @selected(old('level', $training->level) === $level)>
                        {{ ucfirst($level) }}
                    </option>
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('level')" />
        </div>

        <div>
            <x-input-label for="capacity" value="Maximum aantal deelnemers" required />
            <x-text-input id="capacity" name="capacity" type="number" class="mt-1"
                          :value="old('capacity', $training->capacity ?? 12)" required min="1" max="200" />
            <x-input-error :messages="$errors->get('capacity')" />
        </div>

        <div>
            <x-input-label for="instructor_id" value="Lesgever" />
            <x-select-input id="instructor_id" name="instructor_id" class="mt-1">
                <option value="">Nog te bepalen</option>
                @foreach ($instructors as $instructor)
                    <option value="{{ $instructor->id }}" @selected(old('instructor_id', $training->instructor_id) == $instructor->id)>
                        {{ $instructor->username }} ({{ $instructor->name }})
                    </option>
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('instructor_id')" />
        </div>
    </div>

    <div class="flex items-center gap-3 border-t border-slate-200 pt-5">
        <x-primary-button>{{ $training->exists ? 'Wijzigingen opslaan' : 'Training aanmaken' }}</x-primary-button>
        <a href="{{ route('admin.trainings.index') }}" class="text-sm text-slate-600 hover:underline">Annuleren</a>
    </div>
</form>
