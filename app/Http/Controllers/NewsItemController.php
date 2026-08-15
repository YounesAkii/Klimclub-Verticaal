<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use Illuminate\View\View;

/**
 * De publieke kant van het nieuws: enkel lezen. Het beheer zit in
 * App\Http\Controllers\Admin\NewsItemController.
 */
class NewsItemController extends Controller
{
    public function index(): View
    {
        return view('news.index', [
            'newsItems' => NewsItem::query()
                ->published()
                ->newestFirst()
                ->with('author')
                ->withCount('comments')
                ->paginate(6),
        ]);
    }

    public function show(NewsItem $newsItem): View
    {
        // Een item met een publicatiedatum in de toekomst is nog niet zichtbaar
        // voor bezoekers; admins mogen het wel al bekijken.
        abort_if($newsItem->isScheduled() && ! request()->user()?->is_admin, 404);

        $newsItem->load([
            'author',
            'comments' => fn ($query) => $query->with('author')->latest(),
        ]);

        return view('news.show', [
            'newsItem' => $newsItem,
            'relatedItems' => NewsItem::query()
                ->published()
                ->newestFirst()
                ->whereKeyNot($newsItem->id)
                ->take(3)
                ->get(),
        ]);
    }
}
