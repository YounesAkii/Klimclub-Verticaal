<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Pivotmodel voor de tabel training_user. Dankzij deze klasse is
 * $user->pivot->registered_at meteen een Carbon-instantie in plaats van een
 * string.
 */
class TrainingRegistration extends Pivot
{
    protected $table = 'training_user';

    public $incrementing = true;

    protected function casts(): array
    {
        return [
            'registered_at' => 'datetime',
        ];
    }
}
