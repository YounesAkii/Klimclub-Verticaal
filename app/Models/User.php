<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'username', 'email', 'password', 'birthday', 'avatar_path', 'bio', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday' => 'date',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * De nieuwsitems die deze gebruiker geschreven heeft (one-to-many).
     *
     * @return HasMany<NewsItem, $this>
     */
    public function newsItems(): HasMany
    {
        return $this->hasMany(NewsItem::class);
    }

    /**
     * De reacties die deze gebruiker achterliet op nieuwsitems (one-to-many).
     *
     * @return HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * De trainingen die deze gebruiker begeleidt als lesgever (one-to-many).
     *
     * @return HasMany<Training, $this>
     */
    public function taughtTrainings(): HasMany
    {
        return $this->hasMany(Training::class, 'instructor_id');
    }

    /**
     * De trainingen waarvoor deze gebruiker ingeschreven is (many-to-many).
     *
     * @return BelongsToMany<Training, $this>
     */
    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class)
            ->using(TrainingRegistration::class)
            ->withPivot('registered_at')
            ->withTimestamps();
    }

    /**
     * De URL van de geüploade profielfoto, of null wanneer er geen is.
     * De x-avatar component toont in dat geval de initialen.
     */
    public function avatarUrl(): ?string
    {
        if ($this->avatar_path && Storage::disk('public')->exists($this->avatar_path)) {
            return Storage::disk('public')->url($this->avatar_path);
        }

        return null;
    }

    /**
     * De initialen van de gebruiker, gebruikt in de placeholder-avatar.
     */
    public function initials(): string
    {
        preg_match_all('/\b\p{L}/u', (string) $this->username, $matches);

        return mb_strtoupper(implode('', array_slice($matches[0], 0, 2)) ?: 'K');
    }
}
