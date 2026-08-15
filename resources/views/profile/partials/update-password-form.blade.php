<x-card title="Wachtwoord wijzigen"
        subtitle="Kies een lang, uniek wachtwoord om je account te beveiligen.">
    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="update_password_current_password" value="Huidig wachtwoord" required />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                          class="mt-1" required autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="update_password_password" value="Nieuw wachtwoord" required />
                <x-text-input id="update_password_password" name="password" type="password"
                              class="mt-1" required minlength="8" autocomplete="new-password" />
                <p class="mt-1 text-xs text-slate-500">Minstens 8 tekens.</p>
                <x-input-error :messages="$errors->updatePassword->get('password')" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" value="Herhaal nieuw wachtwoord" required />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                              class="mt-1" required minlength="8" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
            </div>
        </div>

        <x-primary-button>Wachtwoord opslaan</x-primary-button>
    </form>
</x-card>
