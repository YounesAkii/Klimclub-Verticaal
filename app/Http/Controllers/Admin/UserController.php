<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\ImageUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Gebruikersbeheer voor beheerders: manueel accounts aanmaken, gegevens
 * aanpassen, adminrechten toekennen of afnemen en accounts verwijderen.
 */
class UserController extends Controller
{
    public function __construct(private readonly ImageUploader $images) {}

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('zoek'));
        $role = $request->query('rol');

        return view('admin.users.index', [
            'users' => User::query()
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('username', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                })
                ->when($role === 'admin', fn ($query) => $query->where('is_admin', true))
                ->when($role === 'lid', fn ($query) => $query->where('is_admin', false))
                ->orderByDesc('is_admin')
                ->orderBy('username')
                ->paginate(20)
                ->withQueryString(),
            'search' => $search,
            'role' => $role,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'user' => new User(),
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $user = new User($request->safe()->only(['name', 'username', 'email', 'birthday', 'bio']));
        $user->password = Hash::make($request->validated('password'));
        $user->is_admin = $request->boolean('is_admin');
        $user->email_verified_at = now();
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'De gebruiker "' . $user->username . '" is aangemaakt.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->fill($request->safe()->only(['name', 'username', 'email', 'birthday', 'bio']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->validated('password'));
        }

        // Een admin kan zichzelf niet degraderen: anders kan de laatste
        // beheerder zichzelf per ongeluk buitensluiten.
        if ($user->isNot($request->user())) {
            $user->is_admin = $request->boolean('is_admin');
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'De gegevens van "' . $user->username . '" zijn bijgewerkt.');
    }

    /**
     * Geef of neem adminrechten. Bewust een aparte route, zodat dit met één
     * knop vanuit het overzicht kan.
     */
    public function toggleRole(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'Je kan je eigen adminrechten niet aanpassen.');
        }

        $user->is_admin = ! $user->is_admin;
        $user->save();

        $message = $user->is_admin
            ? '"' . $user->username . '" is nu beheerder.'
            : 'De beheerdersrechten van "' . $user->username . '" zijn ingetrokken.';

        return back()->with('status', $message);
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'Je kan je eigen account niet verwijderen vanuit het beheer.');
        }

        $username = $user->username;

        $this->images->delete($user->avatar_path);
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'De gebruiker "' . $username . '" is verwijderd.');
    }
}
