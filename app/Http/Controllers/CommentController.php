<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\NewsItem;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Plaats een reactie onder een nieuwsitem.
     */
    public function store(CommentRequest $request, NewsItem $newsItem): RedirectResponse
    {
        abort_if($newsItem->isScheduled(), 404);

        $newsItem->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->validated('body'),
        ]);

        return redirect()
            ->route('news.show', $newsItem)
            ->withFragment('reacties')
            ->with('status', 'Je reactie is geplaatst.');
    }

    /**
     * Verwijder een reactie. De CommentPolicy laat dit toe voor de auteur van
     * de reactie en voor beheerders.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $newsItem = $comment->newsItem;
        $comment->delete();

        return redirect()
            ->route('news.show', $newsItem)
            ->withFragment('reacties')
            ->with('status', 'De reactie is verwijderd.');
    }
}
