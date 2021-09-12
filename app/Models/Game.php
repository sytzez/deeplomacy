<?php

namespace App\Models;

use App\Game\Contracts\ConfigurationContract;
use App\Game\Contracts\GameContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model implements GameContract
{
    public function configuration(): BelongsTo
    {
        return $this->belongsTo(Configuration::class);
    }

    public function submarines(): HasMany
    {
        return $this->hasMany(Submarine::class);
    }

    public function getConfiguration(): ConfigurationContract
    {
        return $this->getRelation('configuration');
    }
}
