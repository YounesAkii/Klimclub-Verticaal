<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'email', 'subject', 'message'])]
class ContactMessage extends Model
{
    /** @use HasFactory<\Database\Factories\ContactMessageFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'replied_at' => 'datetime',
        ];
    }

    /**
     * De admin die op dit bericht antwoordde (inverse van one-to-many).
     *
     * @return BelongsTo<User, $this>
     */
    public function repliedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function isAnswered(): bool
    {
        return $this->replied_at !== null;
    }

    public function scopeUnanswered(Builder $query): Builder
    {
        return $query->whereNull('replied_at');
    }
}
