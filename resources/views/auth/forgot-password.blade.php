<x-guest-layout>
    <h1 class="text-2xl font-bold text-slate-900">Wachtwoord vergeten</h1>
    <p class="mt-2 text-sm leading-relaxed text-slate-600">
        Geef je e-mailadres in. We sturen je een link waarmee je een nieuw wachtwoord kan instellen.
    </p>

    <x-auth-session-status class="mt-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="E-mailadres" required />
            <x-text-input id="email" name="email" type="email" class="mt-1" :value="old('email')"
                          required autofocus autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <x-primary-button class="w-full">Stuur de resetlink</x-primary-button>
    </form>

    <p class="mt-6 border-t border-slate-100 pt-6 text-center text-sm text-slate-600">
        <a href="{{ route('login') }}" class="font-medium text-amber-700 hover:underline">Terug naar inloggen</a>
    </p>
</x-guest-layout>
