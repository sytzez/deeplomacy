<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class Submarine
 * @package App\Models
 * @property int $x
 * @property int $y
 * @property int $action_points
 * @property bool $is_alive
 * @property User $user
 * @property Game $game
 * @property Collection<Submarine> $sonarSharedTo
 * @property Collection<Submarine> $sonarSharedFrom
 */
class Submarine extends Model
{
    protected $fillable = [
        'x',
        'y',
        'action_points',
        'is_alive',
    ];

    protected $casts = [
        'is_alive' => 'bool',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function sonarSharedTo(): BelongsToMany
    {
        return $this->belongsToMany(
            Submarine::class,
            'submarine_sonar_shares',
            'recipient_id',
            'donor_id',
        )->where('is_alive', true);
    }

    public function sonarSharedFrom(): BelongsToMany
    {
        return $this->belongsToMany(
            Submarine::class,
            'submarine_sonar_shares',
            'donor_id',
            'recipient_id',
        )->where('is_alive', true);
    }
}
