<?php

namespace Game\Data;

use Game\Contracts\PlacementStrategyContract;
use Game\Contracts\SubmarineContract;

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
