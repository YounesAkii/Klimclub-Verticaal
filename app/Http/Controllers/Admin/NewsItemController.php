<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsItemRequest;
use App\Models\NewsItem;
use App\Services\ImageUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Resource controller voor het beheer van nieuwsitems. De publieke index en
 * show zitten in App\Http\Controllers\NewsItemController.
 */
class NewsItemController extends Controller
{
    public function __construct(private readonly ImageUploader $images) {}

    public function index(): View
    {
        return view('admin.news.index', [
            'newsItems' => NewsItem::query()
                ->newestFirst()
                ->with('author')
                ->withCount('comments')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.news.create', [
            'newsItem' => new NewsItem(['published_at' => now()]),
        ]);
    }

    public function store(NewsItemRequest $request): RedirectResponse
    {
        $newsItem = new NewsItem($request->safe()->only(['title', 'excerpt', 'content', 'published_at']));
        $newsItem->user_id = $request->user()->id;
        $newsItem->slug = $this->resolveSlug($request->validated('slug'), $request->validated('title'));
        $newsItem->image_path = $this->images->store($request->file('image'), 'news');
        $newsItem->save();

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'Het nieuwsitem "' . $newsItem->title . '" is aangemaakt.');
    }

    public function edit(NewsItem $newsItem): View
    {
        return view('admin.news.edit', [
            'newsItem' => $newsItem,
        ]);
    }

    public function update(NewsItemRequest $request, NewsItem $newsItem): RedirectResponse
    {
        $newsItem->fill($request->safe()->only(['title', 'excerpt', 'content', 'published_at']));
        $newsItem->slug = $this->resolveSlug($request->validated('slug'), $request->validated('title'), $newsItem);

        if ($request->hasFile('image')) {
            $oldImage = $newsItem->image_path;
            $newsItem->image_path = $this->images->store($request->file('image'), 'news');
            $this->deleteImageIfUnused($oldImage, $newsItem->id);
        }

        $newsItem->save();

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'Het nieuwsitem "' . $newsItem->title . '" is bijgewerkt.');
    }

    public function destroy(NewsItem $newsItem): RedirectResponse
    {
        $title = $newsItem->title;
        $image = $newsItem->image_path;

        $newsItem->delete();
        $this->deleteImageIfUnused($image, $newsItem->id);

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'Het nieuwsitem "' . $title . '" is verwijderd.');
    }

    /**
     * Gebruikt de handmatig opgegeven slug, of leidt er zelf een af uit de
     * titel. Een cijfer achteraan houdt de slug uniek.
     */
    private function resolveSlug(?string $slug, string $title, ?NewsItem $current = null): string
    {
        $base = Str::slug($slug ?: $title);
        $candidate = $base;
        $suffix = 2;

        while (NewsItem::where('slug', $candidate)->whereKeyNot($current?->id ?? 0)->exists()) {
            $candidate = $base . '-' . $suffix++;
        }

        return $candidate;
    }

    /**
     * De seeder hergebruikt dezelfde afbeelding voor meerdere items. Verwijder
     * een bestand daarom enkel wanneer geen enkel ander item er nog naar wijst.
     */
    private function deleteImageIfUnused(?string $path, int $ignoreId): void
    {
        if ($path && ! NewsItem::where('image_path', $path)->whereKeyNot($ignoreId)->exists()) {
            $this->images->delete($path);
        }
    }
}
