<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

/**
 * Class Game
 * @package App\Models
 * @property Configuration configuration
 * @property Collection<Submarine> submarines
 */
class Game extends Model
{
    public function configuration(): BelongsTo
    {
        return $this->belongsTo(Configuration::class);
    }

    public function submarines(): HasMany
    {
        return $this->hasMany(Submarine::class);
    }

    public function isJoinedBy(User $user): bool
    {
        return $this->submarines()
            ->where('user_id', $user->getKey())
            ->exists();
    }
}
