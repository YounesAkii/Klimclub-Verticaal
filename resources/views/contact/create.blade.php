<x-app-layout title="Contact" description="Neem contact op met Klimclub Verticaal.">
    <x-page-header title="Contact"
                   subtitle="Een vraag over lidmaatschap, een groepsuitstap of iets anders? Laat het ons weten." />

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-3">
            {{-- Formulier --}}
            <div class="lg:col-span-2">
                <x-card title="Stuur ons een bericht"
                        subtitle="We proberen binnen twee werkdagen te antwoorden.">
                    {{-- De required-, minlength- en type-attributen hieronder zorgen
                         voor client-side validatie; de ContactMessageRequest
                         valideert dezelfde regels nog eens op de server. --}}
                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                        @csrf

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <x-input-label for="name" value="Je naam" required />
                                <x-text-input id="name" name="name" type="text" class="mt-1"
                                              :value="old('name', auth()->user()?->name)"
                                              required minlength="2" maxlength="255" autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" value="E-mailadres" required />
                                <x-text-input id="email" name="email" type="email" class="mt-1"
                                              :value="old('email', auth()->user()?->email)"
                                              required maxlength="255" autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="subject" value="Onderwerp" required />
                            <x-text-input id="subject" name="subject" type="text" class="mt-1"
                                          :value="old('subject')" required minlength="3" maxlength="255" />
                            <x-input-error :messages="$errors->get('subject')" />
                        </div>

                        <div>
                            <x-input-label for="message" value="Je bericht" required />
                            <x-textarea id="message" name="message" rows="7" class="mt-1"
                                        required minlength="20" maxlength="5000">{{ old('message') }}</x-textarea>
                            <p class="mt-1 text-xs text-slate-500">Minstens 20 tekens.</p>
                            <x-input-error :messages="$errors->get('message')" />
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>Verstuur bericht</x-primary-button>
                        </div>
                    </form>
                </x-card>
            </div>

            {{-- Praktische info --}}
            <div class="space-y-6">
                <x-card title="Waar vind je ons">
                    <address class="space-y-3 not-italic text-sm text-slate-600">
                        <p class="whitespace-pre-line">{{ config('klimclub.address') }}</p>
                        <p>
                            <a href="tel:{{ str_replace(' ', '', config('klimclub.phone')) }}" class="text-amber-700 hover:underline">
                                {{ config('klimclub.phone') }}
                            </a>
                        </p>
                        <p>
                            <a href="mailto:{{ config('klimclub.email') }}" class="text-amber-700 hover:underline">
                                {{ config('klimclub.email') }}
                            </a>
                        </p>
                    </address>
                </x-card>

                <x-card title="Openingsuren">
                    <dl class="space-y-2 text-sm">
                        @foreach (config('klimclub.opening_hours') as $days => $hours)
                            <div class="flex justify-between gap-4">
                                <dt class="text-slate-600">{{ $days }}</dt>
                                <dd class="font-medium text-slate-900">{{ $hours }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </x-card>

                <x-card title="Eerst even nakijken?">
                    <p class="text-sm leading-relaxed text-slate-600">
                        Veel vragen over tarieven, materiaal en brevetten zijn al beantwoord in onze FAQ.
                    </p>
                    <a href="{{ route('faq.index') }}" class="mt-3 inline-block text-sm font-medium text-amber-700 hover:underline">
                        Naar de veelgestelde vragen &rarr;
                    </a>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
