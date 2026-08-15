<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf

    @if ($user->exists)
        @method('PUT')
    @endif

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <x-input-label for="username" value="Gebruikersnaam" required />
            <x-text-input id="username" name="username" type="text" class="mt-1"
                          :value="old('username', $user->username)" required
                          minlength="3" maxlength="30" pattern="[A-Za-z0-9_-]+" />
            <x-input-error :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="name" value="Volledige naam" required />
            <x-text-input id="name" name="name" type="text" class="mt-1"
                          :value="old('name', $user->name)" required maxlength="255" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="E-mailadres" required />
            <x-text-input id="email" name="email" type="email" class="mt-1"
                          :value="old('email', $user->email)" required maxlength="255" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="birthday" value="Verjaardag" />
            <x-text-input id="birthday" name="birthday" type="date" class="mt-1"
                          :value="old('birthday', $user->birthday?->toDateString())"
                          min="1900-01-01" :max="now()->subDay()->toDateString()" />
            <x-input-error :messages="$errors->get('birthday')" />
        </div>

        <div>
            <x-input-label for="password" value="Wachtwoord" :required="! $user->exists" />
            <x-text-input id="password" name="password" type="password" class="mt-1"
                          @required(! $user->exists) minlength="8" autocomplete="new-password" />
            <p class="mt-1 text-xs text-slate-500">
                Minstens 8 tekens.
                @if ($user->exists) Laat leeg om het huidige wachtwoord te behouden. @endif
            </p>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Herhaal wachtwoord" :required="! $user->exists" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1"
                          @required(! $user->exists) minlength="8" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>
    </div>

    <div>
        <x-input-label for="bio" value="Over mij" />
        <x-textarea id="bio" name="bio" rows="4" class="mt-1"
                    maxlength="1000">{{ old('bio', $user->bio) }}</x-textarea>
        <x-input-error :messages="$errors->get('bio')" />
    </div>

    <div class="rounded-md border border-slate-200 bg-slate-50 p-4">
        @if ($user->exists && $user->is(auth()->user()))
            <p class="text-sm text-slate-600">
                Je kan je eigen beheerdersrechten hier niet aanpassen. Vraag een andere beheerder om dat te doen.
            </p>
        @else
            <label for="is_admin" class="flex items-start gap-3">
                {{-- De hidden input zorgt ervoor dat een uitgevinkte checkbox ook
                     effectief als 0 verstuurd wordt. --}}
                <input type="hidden" name="is_admin" value="0">
                <input id="is_admin" name="is_admin" type="checkbox" value="1"
                       @checked(old('is_admin', $user->is_admin))
                       class="mt-0.5 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                <span class="text-sm">
                    <span class="font-medium text-slate-900">Beheerder</span>
                    <span class="block text-slate-500">
                        Beheerders kunnen nieuws, FAQ, trainingen en gebruikers beheren.
                    </span>
                </span>
            </label>
        @endif
        <x-input-error :messages="$errors->get('is_admin')" />
    </div>

    <div class="flex items-center gap-3 border-t border-slate-200 pt-5">
        <x-primary-button>{{ $user->exists ? 'Wijzigingen opslaan' : 'Gebruiker aanmaken' }}</x-primary-button>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-600 hover:underline">Annuleren</a>
    </div>
</form>
