<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable(['user_id', 'title', 'slug', 'image_path', 'excerpt', 'content', 'published_at'])]
class NewsItem extends Model
{
    /** @use HasFactory<\Database\Factories\NewsItemFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * De admin die dit nieuwsitem publiceerde (inverse van one-to-many).
     *
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * De reacties op dit nieuwsitem (one-to-many).
     *
     * @return HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Enkel nieuws waarvan de publicatiedatum al bereikt is. Zo kan een admin
     * een item alvast klaarzetten met een datum in de toekomst.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', now());
    }

    public function scopeNewestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('published_at');
    }

    public function isScheduled(): bool
    {
        return $this->published_at->isFuture();
    }

    public function imageUrl(): string
    {
        return Storage::disk('public')->url($this->image_path);
    }
}
