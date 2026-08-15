<x-guest-layout>
    <h1 class="text-2xl font-bold text-slate-900">Inloggen</h1>
    <p class="mt-1 text-sm text-slate-600">Welkom terug bij Klimclub Verticaal.</p>

    <x-auth-session-status class="mt-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="E-mailadres" required />
            <x-text-input id="email" name="email" type="email" class="mt-1" :value="old('email')"
                          required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="password" value="Wachtwoord" required />
            <x-text-input id="password" name="password" type="password" class="mt-1"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center justify-between">
            {{-- 'Remember me' laat Laravel een langlopend cookie plaatsen. --}}
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input id="remember_me" name="remember" type="checkbox"
                       class="rounded border-slate-300 text-amber-600 shadow-sm focus:ring-amber-500">
                Ingelogd blijven
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-amber-700 hover:underline">
                    Wachtwoord vergeten?
                </a>
            @endif
        </div>

        <x-primary-button class="w-full">Inloggen</x-primary-button>
    </form>

    <p class="mt-6 border-t border-slate-100 pt-6 text-center text-sm text-slate-600">
        Nog geen account?
        <a href="{{ route('register') }}" class="font-medium text-amber-700 hover:underline">Maak er een aan</a>
    </p>
</x-guest-layout>
