<?php

namespace App\Game\Data;

use App\Game\Contracts\PlacementStrategyContract;
use App\Game\Contracts\SubmarineContract;

class JoinGameData
{
    public function __construct(
        protected SubmarineContract $submarine,
        protected PlacementStrategyContract $strategy,
    ) {
    }

    public function getSubmarine(): SubmarineContract
    {
        return $this->submarine;
    }

    public function getPlacementStrategy(): PlacementStrategyContract
    {
        return $this->strategy;
    }
}
