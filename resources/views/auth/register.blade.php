<x-guest-layout>
    <h1 class="text-2xl font-bold text-slate-900">Account aanmaken</h1>
    <p class="mt-1 text-sm text-slate-600">
        Met een account schrijf je je in voor trainingen en reageer je op nieuws.
    </p>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="name" value="Volledige naam" required />
            <x-text-input id="name" name="name" type="text" class="mt-1" :value="old('name')"
                          required autofocus maxlength="255" autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" value="Gebruikersnaam" required />
            <x-text-input id="username" name="username" type="text" class="mt-1" :value="old('username')"
                          required minlength="3" maxlength="30" pattern="[A-Za-z0-9_-]+" autocomplete="username" />
            <p class="mt-1 text-xs text-slate-500">
                Dit is de naam op je publieke profiel. Letters, cijfers, - en _.
            </p>
            <x-input-error :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="email" value="E-mailadres" required />
            <x-text-input id="email" name="email" type="email" class="mt-1" :value="old('email')"
                          required maxlength="255" autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="password" value="Wachtwoord" required />
            <x-text-input id="password" name="password" type="password" class="mt-1"
                          required minlength="8" autocomplete="new-password" />
            <p class="mt-1 text-xs text-slate-500">Minstens 8 tekens.</p>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Herhaal wachtwoord" required />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1"
                          required minlength="8" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <x-primary-button class="w-full">Account aanmaken</x-primary-button>
    </form>

    <p class="mt-6 border-t border-slate-100 pt-6 text-center text-sm text-slate-600">
        Heb je al een account?
        <a href="{{ route('login') }}" class="font-medium text-amber-700 hover:underline">Log in</a>
    </p>
</x-guest-layout>
