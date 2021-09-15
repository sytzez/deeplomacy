<?php

namespace App\Jobs;

use App\Models\Game;
use App\Services\GameService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DistributeActionPointsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(
        GameService $gameService,
    ): void {
        foreach (Game::all() as $game) {
            $gameService->distributeActionPointsIfNeeded($game);
        }
    }
}
