<x-admin-layout title="Contactbericht">
    <x-slot name="actions">
        <a href="{{ route('admin.contact-messages.index') }}"
           class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
            Terug naar de inbox
        </a>
    </x-slot>

    <div class="space-y-6">
        <x-card :title="$message->subject">
            <x-slot name="actions">
                @if ($message->isAnswered())
                    <x-badge color="emerald">Beantwoord</x-badge>
                @else
                    <x-badge color="amber">Open</x-badge>
                @endif
            </x-slot>

            <dl class="mb-5 grid gap-3 text-sm sm:grid-cols-3">
                <div>
                    <dt class="text-slate-500">Afzender</dt>
                    <dd class="font-medium text-slate-900">{{ $message->name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">E-mailadres</dt>
                    <dd class="font-medium text-slate-900">
                        <a href="mailto:{{ $message->email }}" class="text-amber-700 hover:underline">
                            {{ $message->email }}
                        </a>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-500">Ontvangen</dt>
                    <dd class="font-medium text-slate-900">
                        {{ $message->created_at->translatedFormat('j F Y \o\m H:i') }}
                    </dd>
                </div>
            </dl>

            <div class="rounded-md bg-slate-50 p-4">
                <x-rich-text :text="$message->message" />
            </div>
        </x-card>

        @if ($message->isAnswered())
            <x-card title="Verstuurd antwoord"
                    :subtitle="'Door ' . ($message->repliedBy?->username ?? 'een beheerder') . ' op ' . $message->replied_at->translatedFormat('j F Y \o\m H:i')">
                <div class="rounded-md border border-emerald-200 bg-emerald-50 p-4">
                    <x-rich-text :text="$message->reply" />
                </div>

                <p class="mt-4 text-sm text-slate-500">
                    Een nieuw antwoord versturen vervangt dit antwoord en stuurt opnieuw een e-mail.
                </p>
            </x-card>
        @endif

        <x-card :title="$message->isAnswered() ? 'Opnieuw antwoorden' : 'Antwoorden'"
                :subtitle="'Je antwoord wordt per e-mail naar ' . $message->email . ' gestuurd.'">
            <form method="POST" action="{{ route('admin.contact-messages.reply', $message) }}" class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="reply" value="Antwoord" required />
                    <x-textarea id="reply" name="reply" rows="10" class="mt-1"
                                required minlength="10" maxlength="5000">{{ old('reply', $message->reply) }}</x-textarea>
                    <x-input-error :messages="$errors->get('reply')" />
                </div>

                <x-primary-button>Antwoord versturen</x-primary-button>
            </form>

            {{-- Buiten het antwoordformulier: formulieren mogen niet genest zijn. --}}
            <div class="mt-5 border-t border-slate-200 pt-4">
                <x-delete-form :action="route('admin.contact-messages.destroy', $message)"
                               confirm="Dit bericht verwijderen?" label="Bericht verwijderen" />
            </div>
        </x-card>
    </div>
</x-admin-layout>
