<x-guest-layout>
    <h1 class="text-2xl font-bold text-slate-900">Nieuw wachtwoord instellen</h1>

    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-5">
        @csrf

        {{-- De token uit de e-mail koppelt dit formulier aan de aanvraag. --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" value="E-mailadres" required />
            <x-text-input id="email" name="email" type="email" class="mt-1"
                          :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="password" value="Nieuw wachtwoord" required />
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

        <x-primary-button class="w-full">Wachtwoord opslaan</x-primary-button>
    </form>
</x-guest-layout>
