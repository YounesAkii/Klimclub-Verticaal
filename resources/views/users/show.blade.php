<x-app-layout :title="'Profiel van ' . $user->username"
              :description="$user->bio ? Str::limit($user->bio, 150) : 'Het profiel van ' . $user->username . ' bij Klimclub Verticaal.'">
    {{-- Profielkop --}}
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-start">
                <x-avatar :user="$user" size="xl" class="ring-4 ring-slate-100" />

                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ $user->username }}</h1>

                        @if ($user->is_admin)
                            <x-badge color="amber">Beheerder</x-badge>
                        @endif
                    </div>

                    <p class="mt-1 text-slate-600">{{ $user->name }}</p>

                    <dl class="mt-4 flex flex-wrap gap-x-8 gap-y-2 text-sm">
                        @if ($user->birthday)
                            <div>
                                <dt class="text-slate-500">Verjaardag</dt>
                                <dd class="font-medium text-slate-900">
                                    {{ $user->birthday->translatedFormat('j F') }}
                                    <span class="font-normal text-slate-500">({{ $user->birthday->age }} jaar)</span>
                                </dd>
                            </div>
                        @endif

                        <div>
                            <dt class="text-slate-500">Lid sinds</dt>
                            <dd class="font-medium text-slate-900">{{ $user->created_at->translatedFormat('F Y') }}</dd>
                        </div>

                        <div>
                            <dt class="text-slate-500">Inschrijvingen</dt>
                            <dd class="font-medium text-slate-900">{{ $trainings->count() }}</dd>
                        </div>
                    </dl>

                    @auth
                        @if (auth()->user()->is($user))
                            <a href="{{ route('profile.edit') }}"
                               class="mt-5 inline-block rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                                Mijn profiel bewerken
                            </a>
                        @elseif (auth()->user()->is_admin)
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="mt-5 inline-block rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                Bewerken in het beheer
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <x-card title="Over mij">
                    @if ($user->bio)
                        <x-rich-text :text="$user->bio" />
                    @else
                        <p class="text-sm text-slate-500">
                            {{ $user->username }} heeft nog geen tekst toegevoegd.
                        </p>
                    @endif
                </x-card>

                <x-card title="Laatste reacties">
                    @forelse ($comments as $comment)
                        <div class="border-b border-slate-100 py-3 first:pt-0 last:border-b-0 last:pb-0">
                            <p class="text-sm text-slate-700">{{ Str::limit($comment->body, 160) }}</p>
                            <p class="mt-1 text-xs text-slate-500">
                                bij
                                <a href="{{ route('news.show', $comment->newsItem) }}" class="text-amber-700 hover:underline">
                                    {{ $comment->newsItem->title }}
                                </a>
                                &middot; {{ $comment->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Nog geen reacties geplaatst.</p>
                    @endforelse
                </x-card>
            </div>

            <div>
                <x-card title="Trainingen">
                    @forelse ($trainings as $training)
                        <div class="border-b border-slate-100 py-3 first:pt-0 last:border-b-0 last:pb-0">
                            <a href="{{ route('trainings.show', $training) }}"
                               class="text-sm font-medium text-slate-900 hover:text-amber-700 hover:underline">
                                {{ $training->title }}
                            </a>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ $training->starts_at->translatedFormat('j M Y') }}
                                @if ($training->hasStarted())
                                    &middot; afgelopen
                                @endif
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Nog geen inschrijvingen.</p>
                    @endforelse
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>
