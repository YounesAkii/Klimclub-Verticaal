<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['news_item_id', 'user_id', 'body'])]
class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    /**
     * Het nieuwsitem waarop gereageerd werd (inverse van one-to-many).
     *
     * @return BelongsTo<NewsItem, $this>
     */
    public function newsItem(): BelongsTo
    {
        return $this->belongsTo(NewsItem::class);
    }

    /**
     * De gebruiker die de reactie schreef (inverse van one-to-many).
     *
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
