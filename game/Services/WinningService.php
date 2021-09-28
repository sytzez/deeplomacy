<?php

namespace Game\Services;

use Game\Contracts\GameContract;

class WinningService
{
    public function checkVictory(GameContract $game): void
    {
        $winningStrategy = $game->getWinningStrategy();

        $result = $winningStrategy->check($game);

        if ($result->hasBeenWon()) {
            $game->grantVictory($result->getWinners() ?? []);
        }
    }
}
