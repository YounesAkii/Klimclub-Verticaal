{{-- Gedeeld formulier voor het aanmaken en bewerken van een nieuwsitem.
     $newsItem is bij 'create' een leeg model, bij 'edit' het bestaande item. --}}
<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    @if ($newsItem->exists)
        @method('PUT')
    @endif

    <div>
        <x-input-label for="title" value="Titel" required />
        <x-text-input id="title" name="title" type="text" class="mt-1"
                      :value="old('title', $newsItem->title)" required minlength="5" maxlength="255" />
        <x-input-error :messages="$errors->get('title')" />
    </div>

    <div>
        <x-input-label for="slug" value="Slug" />
        <x-text-input id="slug" name="slug" type="text" class="mt-1"
                      :value="old('slug', $newsItem->slug)" maxlength="255" pattern="[a-z0-9-]+" />
        <p class="mt-1 text-xs text-slate-500">
            Het stukje dat in de URL komt. Laat leeg om het automatisch uit de titel af te leiden.
        </p>
        <x-input-error :messages="$errors->get('slug')" />
    </div>

    <div>
        <x-input-label for="excerpt" value="Samenvatting" required />
        <x-textarea id="excerpt" name="excerpt" rows="3" class="mt-1"
                    required minlength="20" maxlength="500">{{ old('excerpt', $newsItem->excerpt) }}</x-textarea>
        <p class="mt-1 text-xs text-slate-500">Dit verschijnt op de overzichtspagina. Tussen 20 en 500 tekens.</p>
        <x-input-error :messages="$errors->get('excerpt')" />
    </div>

    <div>
        <x-input-label for="content" value="Inhoud" required />
        <x-textarea id="content" name="content" rows="14" class="mt-1"
                    required minlength="50">{{ old('content', $newsItem->content) }}</x-textarea>
        <p class="mt-1 text-xs text-slate-500">Laat een lege regel tussen twee alinea's.</p>
        <x-input-error :messages="$errors->get('content')" />
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <x-input-label for="published_at" value="Publicatiedatum" required />
            <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1"
                          :value="old('published_at', $newsItem->published_at?->format('Y-m-d\TH:i'))" required />
            <p class="mt-1 text-xs text-slate-500">
                Een datum in de toekomst houdt het bericht verborgen tot dat moment.
            </p>
            <x-input-error :messages="$errors->get('published_at')" />
        </div>

        <div>
            <x-input-label for="image" value="Afbeelding" :required="! $newsItem->exists" />

            @if ($newsItem->exists)
                <img src="{{ $newsItem->imageUrl() }}" alt="Huidige afbeelding"
                     class="mt-1 h-24 w-40 rounded object-cover">
            @endif

            <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
                   @required(! $newsItem->exists)
                   class="mt-2 block w-full text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800">
            <p class="mt-1 text-xs text-slate-500">
                JPG, PNG of WebP, maximaal 4 MB.
                @if ($newsItem->exists) Laat leeg om de huidige afbeelding te behouden. @endif
            </p>
            <x-input-error :messages="$errors->get('image')" />
        </div>
    </div>

    <div class="flex items-center gap-3 border-t border-slate-200 pt-5">
        <x-primary-button>{{ $newsItem->exists ? 'Wijzigingen opslaan' : 'Bericht aanmaken' }}</x-primary-button>

        <a href="{{ route('admin.news.index') }}" class="text-sm text-slate-600 hover:underline">Annuleren</a>
    </div>
</form>
