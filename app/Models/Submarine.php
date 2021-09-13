<?php

namespace App\Models;

use App\Game\Contracts\GameContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Data\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Submarine
 * @package App\Models
 * @property int x
 * @property int y
 * @property int action_points
 * @property bool is_alive
 * @property Game game
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

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
