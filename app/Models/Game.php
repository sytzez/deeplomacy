<?php

namespace App\Models;

use App\Game\Contracts\ConfigurationContract;
use App\Game\Contracts\GameContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
}
