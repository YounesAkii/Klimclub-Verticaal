<x-guest-layout>
    <h1 class="text-2xl font-bold text-slate-900">Bevestig je wachtwoord</h1>
    <p class="mt-2 text-sm leading-relaxed text-slate-600">
        Dit is een beveiligd deel van de site. Geef je wachtwoord opnieuw in om verder te gaan.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="password" value="Wachtwoord" required />
            <x-text-input id="password" name="password" type="password" class="mt-1"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-primary-button class="w-full">Bevestigen</x-primary-button>
    </form>
</x-guest-layout>
