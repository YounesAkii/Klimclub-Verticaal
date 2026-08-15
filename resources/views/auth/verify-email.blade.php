<x-guest-layout>
    <h1 class="text-2xl font-bold text-slate-900">Bevestig je e-mailadres</h1>
    <p class="mt-2 text-sm leading-relaxed text-slate-600">
        Bedankt voor je registratie. Klik op de link in de e-mail die we je stuurden om je adres te bevestigen.
        Niets ontvangen? Dan sturen we hem graag opnieuw.
    </p>

    @if (session('status') === 'verification-link-sent')
        <x-alert type="success" class="mt-4">
            Er is een nieuwe bevestigingslink verstuurd naar je e-mailadres.
        </x-alert>
    @endif

    <div class="mt-6 flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>Opnieuw versturen</x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-slate-600 underline hover:text-slate-900">Uitloggen</button>
        </form>
    </div>
</x-guest-layout>
