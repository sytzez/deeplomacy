<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Game
 * @package App\Models
 * @property ?DateTime $action_points_last_distributed_at
 * @property Configuration $configuration
 * @property Collection<Submarine> $submarines
 * @property Collection<Submarine> $aliveSubmarines
 * @property int $numOfPlayers
 */
class Game extends Model
{
    protected $fillable = [
        'action_points_last_distributed_at',
    ];

    protected $casts = [
        'action_points_last_distributed_at' => 'datetime',
    ];

    public function configuration(): BelongsTo
    {
        return $this->belongsTo(Configuration::class);
    }

    public function submarines(): HasMany
    {
        return $this->hasMany(Submarine::class);
    }

    public function aliveSubmarines(): HasMany
    {
        return $this->hasMany(Submarine::class)
            ->where('is_alive', true);
    }

    public function isJoinedBy(User $user): bool
    {
        return $this->aliveSubmarines()
            ->where('user_id', $user->getKey())
            ->exists();
    }

    public function isFull(): bool
    {
        return $this->aliveSubmarines()
            ->count() >= $this->configuration->max_num_of_players;
    }

    public function getNumOfPlayersAttribute(): int
    {
        return $this->aliveSubmarines()->count();
    }
}
