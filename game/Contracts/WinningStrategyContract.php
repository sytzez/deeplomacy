<?php

namespace Game\Contracts;

use Game\Data\VictoryData;

interface WinningStrategyContract
{
    public function check(GameContract $game): VictoryData;
}
