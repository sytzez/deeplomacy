<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Submarine;

class MapUpdateTracker
{
    public function markSubmarineUpdated(Submarine $submarine): void
    {
        $submarine->map_last_received_at = now();
        $submarine->save();
    }

    public function markGameChanged(Game $game): void
    {
        $game->touch();
    }

    public function doesSubmarineNeedUpdating(Submarine $submarine): bool
    {
        if (! $submarine->map_last_received_at) {
            return true;
        }

        return $submarine->map_last_received_at < $submarine->game->updated_at;
    }
}
