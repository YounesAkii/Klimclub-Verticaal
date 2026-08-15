<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use App\Models\NewsItem;
use App\Models\Training;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * De startpagina toont het recentste nieuws, de eerstvolgende trainingen en
     * een greep uit de veelgestelde vragen.
     */
    public function index(): View
    {
        return view('home', [
            'newsItems' => NewsItem::query()
                ->published()
                ->newestFirst()
                ->with('author')
                ->withCount('comments')
                ->take(3)
                ->get(),
            'trainings' => Training::query()
                ->upcoming()
                ->with('instructor')
                ->withCount('participants')
                ->take(3)
                ->get(),
            'faqCategories' => FaqCategory::query()
                ->ordered()
                ->withCount('faqs')
                ->get(),
        ]);
    }
}
