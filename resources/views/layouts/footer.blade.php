<footer class="mt-16 bg-slate-900 text-slate-300">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-4">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 font-bold text-white">
                    <x-application-logo class="h-8 w-8 text-amber-400" />
                    <span class="text-lg">Klimclub <span class="text-amber-400">Verticaal</span></span>
                </div>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-slate-400">
                    Een klimclub in Anderlecht voor wie voor het eerst in een gordel hangt en voor wie al jaren
                    projecteert. Kom langs tijdens een initiatiemoment, of stuur ons een berichtje.
                </p>
            </div>

            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wide text-white">Openingsuren</h2>
                <dl class="mt-4 space-y-2 text-sm">
                    @foreach (config('klimclub.opening_hours') as $days => $hours)
                        <div>
                            <dt class="text-slate-400">{{ $days }}</dt>
                            <dd class="text-slate-200">{{ $hours }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wide text-white">Contact</h2>
                <ul class="mt-4 space-y-2 text-sm text-slate-400">
                    <li>{{ config('klimclub.address') }}</li>
                    <li>{{ config('klimclub.phone') }}</li>
                    <li>
                        <a href="mailto:{{ config('klimclub.email') }}" class="transition hover:text-amber-400">
                            {{ config('klimclub.email') }}
                        </a>
                    </li>
                    <li class="pt-2">
                        <a href="{{ route('contact.create') }}" class="font-medium text-amber-400 transition hover:text-amber-300">
                            Contactformulier &rarr;
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-3 border-t border-slate-800 pt-6 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} Klimclub Verticaal. Schoolproject Backend Web.</p>
            <div class="flex gap-4">
                <a href="{{ route('faq.index') }}" class="transition hover:text-slate-300">Veelgestelde vragen</a>
                <a href="{{ route('news.index') }}" class="transition hover:text-slate-300">Nieuws</a>
                <a href="{{ route('trainings.index') }}" class="transition hover:text-slate-300">Trainingen</a>
            </div>
        </div>
    </div>
</footer>
