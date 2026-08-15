<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Het persoonlijke overzicht van een ingelogd lid.
 */
class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'user' => $user,
            'upcomingTrainings' => $user->trainings()
                ->where('starts_at', '>=', now())
                ->orderBy('starts_at')
                ->with('instructor')
                ->withCount('participants')
                ->get(),
            'pastTrainings' => $user->trainings()
                ->where('starts_at', '<', now())
                ->orderByDesc('starts_at')
                ->take(5)
                ->get(),
            'latestNews' => NewsItem::query()
                ->published()
                ->newestFirst()
                ->take(3)
                ->get(),
        ]);
    }
}
