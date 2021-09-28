<?php

namespace Game\Strategies;

use Game\Contracts\GameContract;
use Game\Contracts\WinningStrategyContract;
use Game\Data\VictoryData;

class NoWinningStrategy implements WinningStrategyContract
{
    public function check(GameContract $game): VictoryData
    {
        return new VictoryData(false);
    }
}
