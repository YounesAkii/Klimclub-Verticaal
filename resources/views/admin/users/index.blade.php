<x-admin-layout title="Gebruikers">
    <x-slot name="actions">
        <a href="{{ route('admin.users.create') }}"
           class="rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">
            Nieuwe gebruiker
        </a>
    </x-slot>

    <form method="GET" action="{{ route('admin.users.index') }}"
          class="mb-6 flex flex-wrap items-end gap-3 rounded-lg border border-slate-200 bg-white p-4">
        <div class="min-w-56 flex-1">
            <x-input-label for="zoek" value="Zoeken" />
            <x-text-input id="zoek" name="zoek" type="search" class="mt-1" :value="$search"
                          maxlength="50" placeholder="Naam, gebruikersnaam of e-mail" />
        </div>

        <div>
            <x-input-label for="rol" value="Rol" />
            <x-select-input id="rol" name="rol" class="mt-1 w-44">
                <option value="">Iedereen</option>
                <option value="admin" @selected($role === 'admin')>Enkel beheerders</option>
                <option value="lid" @selected($role === 'lid')>Enkel leden</option>
            </x-select-input>
        </div>

        <x-primary-button>Filteren</x-primary-button>

        @if ($search !== '' || $role)
            <a href="{{ route('admin.users.index') }}" class="pb-2 text-sm text-slate-500 hover:underline">Wissen</a>
        @endif
    </form>

    <x-card flush>
        @if ($users->isEmpty())
            <div class="p-5">
                <x-empty-state title="Geen gebruikers gevonden" description="Probeer een andere zoekterm of filter." />
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th scope="col" class="px-5 py-3">Gebruiker</th>
                            <th scope="col" class="px-5 py-3">E-mail</th>
                            <th scope="col" class="px-5 py-3">Rol</th>
                            <th scope="col" class="px-5 py-3">Lid sinds</th>
                            <th scope="col" class="px-5 py-3 text-right">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($users as $user)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <x-avatar :user="$user" size="sm" />
                                        <div class="min-w-0">
                                            <a href="{{ route('users.show', $user) }}"
                                               class="font-medium text-slate-900 hover:text-amber-700 hover:underline">
                                                {{ $user->username }}
                                            </a>
                                            <p class="text-xs text-slate-400">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-slate-600">{{ $user->email }}</td>
                                <td class="px-5 py-3">
                                    @if ($user->is_admin)
                                        <x-badge color="amber">Beheerder</x-badge>
                                    @else
                                        <x-badge>Lid</x-badge>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-slate-600">
                                    {{ $user->created_at->translatedFormat('j M Y') }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-right">
                                    @if ($user->is(auth()->user()))
                                        <span class="text-xs text-slate-400">Dat ben jij</span>
                                        <span class="mx-1 text-slate-300">|</span>
                                        <a href="{{ route('profile.edit') }}"
                                           class="text-sm font-medium text-amber-700 hover:underline">Profiel</a>
                                    @else
                                        {{-- Adminrechten toekennen of intrekken. --}}
                                        <form method="POST" action="{{ route('admin.users.role', $user) }}" class="inline"
                                              onsubmit="return confirm(@js($user->is_admin
                                                  ? 'De beheerdersrechten van ' . $user->username . ' intrekken?'
                                                  : $user->username . ' beheerder maken?'));">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm font-medium text-slate-600 hover:text-slate-900 hover:underline">
                                                {{ $user->is_admin ? 'Rechten intrekken' : 'Maak beheerder' }}
                                            </button>
                                        </form>
                                        <span class="mx-1 text-slate-300">|</span>
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="text-sm font-medium text-amber-700 hover:underline">Bewerken</a>
                                        <span class="mx-1 text-slate-300">|</span>
                                        <x-delete-form :action="route('admin.users.destroy', $user)"
                                                       :confirm="'Het account van ' . $user->username . ' verwijderen? Reacties en inschrijvingen verdwijnen mee.'" />
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </x-card>
</x-admin-layout>
