<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['instructor_id', 'title', 'slug', 'description', 'location', 'level', 'capacity', 'starts_at', 'ends_at'])]
class Training extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    /**
     * De lesgever van deze training (inverse van one-to-many).
     *
     * @return BelongsTo<User, $this>
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * De ingeschreven deelnemers (many-to-many via de tabel training_user).
     *
     * @return BelongsToMany<User, $this>
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('registered_at')
            ->withTimestamps();
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('starts_at', '>=', now())->orderBy('starts_at');
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->where('starts_at', '<', now())->orderByDesc('starts_at');
    }

    public function hasStarted(): bool
    {
        return $this->starts_at->isPast();
    }

    /**
     * Het aantal vrije plaatsen. Gebruikt participants_count wanneer die via
     * withCount() geladen is, zodat overzichten geen extra query nodig hebben.
     */
    public function spotsLeft(): int
    {
        $taken = $this->participants_count ?? $this->participants()->count();

        return max(0, $this->capacity - $taken);
    }

    public function isFull(): bool
    {
        return $this->spotsLeft() === 0;
    }

    /**
     * Kan de opgegeven gebruiker zich nog inschrijven voor deze training?
     */
    public function isOpenFor(?User $user): bool
    {
        return $user !== null
            && ! $this->hasStarted()
            && ! $this->isFull()
            && ! $this->hasParticipant($user);
    }

    public function hasParticipant(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        // Wanneer de relatie al geladen is (bv. in een overzicht) hoeft er geen
        // extra query naar de databank te gaan.
        if ($this->relationLoaded('participants')) {
            return $this->participants->contains($user);
        }

        return $this->participants()->whereKey($user->getKey())->exists();
    }
}
