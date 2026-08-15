<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\NewsItem;
use App\Models\Training;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Overzichtspagina van het beheer met de belangrijkste cijfers en de
     * berichten die nog een antwoord verwachten.
     */
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'Gebruikers' => User::count(),
                'Beheerders' => User::where('is_admin', true)->count(),
                'Nieuwsitems' => NewsItem::count(),
                'Vragen in de FAQ' => Faq::count(),
                'Trainingen' => Training::count(),
                'Inschrijvingen' => Training::withCount('participants')->get()->sum('participants_count'),
            ],
            'unansweredMessages' => ContactMessage::query()
                ->unanswered()
                ->latest()
                ->take(5)
                ->get(),
            'unansweredCount' => ContactMessage::unanswered()->count(),
            'upcomingTrainings' => Training::query()
                ->upcoming()
                ->withCount('participants')
                ->take(5)
                ->get(),
            'latestNews' => NewsItem::query()
                ->newestFirst()
                ->take(5)
                ->get(),
        ]);
    }
}
