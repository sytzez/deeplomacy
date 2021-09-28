<?php

namespace Game\Contracts;

use Game\Data\VictoryData;

interface WinningStrategyContract
{
    function check(GameContract $game): VictoryData;
}
