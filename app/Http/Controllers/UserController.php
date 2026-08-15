<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * De publieke ledenlijst en profielpagina's. Deze pagina's zijn voor iedereen
 * toegankelijk, ook zonder account.
 */
class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('zoek'));

        return view('users.index', [
            'users' => User::query()
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('username', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
                })
                ->orderBy('username')
                ->withCount('trainings')
                ->paginate(12)
                ->withQueryString(),
            'search' => $search,
        ]);
    }

    public function show(User $user): View
    {
        return view('users.show', [
            'user' => $user,
            'trainings' => $user->trainings()
                ->orderByDesc('starts_at')
                ->with('instructor')
                ->take(10)
                ->get(),
            'comments' => $user->comments()
                ->with('newsItem')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
