<x-card title="Account verwijderen"
        subtitle="Je profiel, je reacties en je inschrijvingen verdwijnen definitief.">
    {{-- Wanneer de wachtwoordcontrole faalt, staat het paneel meteen open zodat
         de foutmelding zichtbaar is. --}}
    <div x-data="{ open: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">
        <x-danger-button type="button" @click="open = true">Mijn account verwijderen</x-danger-button>

        {{-- Bevestiging: het wachtwoord is nodig zodat dit niet per ongeluk gebeurt. --}}
        <div x-show="open" x-cloak class="mt-5 rounded-md border border-rose-200 bg-rose-50 p-4">
            <p class="text-sm text-rose-900">
                Weet je het zeker? Deze actie kan niet ongedaan gemaakt worden. Geef je wachtwoord in om te bevestigen.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}" class="mt-4 space-y-4">
                @csrf
                @method('DELETE')

                <div class="max-w-sm">
                    <x-input-label for="delete_password" value="Wachtwoord" class="sr-only" />
                    <x-text-input id="delete_password" name="password" type="password"
                                  placeholder="Wachtwoord" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->userDeletion->get('password')" />
                </div>

                <div class="flex gap-3">
                    <x-secondary-button type="button" @click="open = false">Annuleren</x-secondary-button>
                    <x-danger-button>Definitief verwijderen</x-danger-button>
                </div>
            </form>
        </div>
    </div>
</x-card>
