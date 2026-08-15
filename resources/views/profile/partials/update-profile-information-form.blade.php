<x-card title="Profielgegevens"
        subtitle="Je gebruikersnaam, verjaardag, foto en 'over mij' zijn zichtbaar voor iedereen.">
    {{-- enctype is nodig omdat dit formulier een bestand kan bevatten. --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <x-input-label for="username" value="Gebruikersnaam" required />
                <x-text-input id="username" name="username" type="text" class="mt-1"
                              :value="old('username', $user->username)" required
                              minlength="3" maxlength="30" pattern="[A-Za-z0-9_-]+" autocomplete="username" />
                <p class="mt-1 text-xs text-slate-500">
                    Letters, cijfers, - en _. Dit staat in de URL van je profiel.
                </p>
                <x-input-error :messages="$errors->get('username')" />
            </div>

            <div>
                <x-input-label for="name" value="Volledige naam" required />
                <x-text-input id="name" name="name" type="text" class="mt-1"
                              :value="old('name', $user->name)" required maxlength="255" autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" value="E-mailadres" required />
                <x-text-input id="email" name="email" type="email" class="mt-1"
                              :value="old('email', $user->email)" required maxlength="255" autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="birthday" value="Verjaardag" />
                <x-text-input id="birthday" name="birthday" type="date" class="mt-1"
                              :value="old('birthday', $user->birthday?->toDateString())"
                              min="1900-01-01" :max="now()->subDay()->toDateString()" />
                <x-input-error :messages="$errors->get('birthday')" />
            </div>
        </div>

        <div>
            <x-input-label for="bio" value="Over mij" />
            <x-textarea id="bio" name="bio" rows="4" class="mt-1" maxlength="1000"
                        placeholder="Sinds wanneer klim je, wat is je favoriete stijl, ...">{{ old('bio', $user->bio) }}</x-textarea>
            <x-input-error :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="avatar" value="Profielfoto" />

            <div class="mt-2 flex flex-wrap items-center gap-4">
                <x-avatar :user="$user" size="lg" />

                <div class="flex-1 min-w-64">
                    <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp"
                           class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800">
                    <p class="mt-1 text-xs text-slate-500">JPG, PNG of WebP, maximaal 2 MB.</p>
                    <x-input-error :messages="$errors->get('avatar')" />
                </div>
            </div>

            @if ($user->avatar_path)
                <label class="mt-3 inline-flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remove_avatar" value="1"
                           class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                    Huidige profielfoto verwijderen
                </label>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Opslaan</x-primary-button>
        </div>
    </form>
</x-card>
