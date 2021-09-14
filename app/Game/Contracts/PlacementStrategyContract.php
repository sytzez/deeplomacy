<?php

namespace App\Game\Contracts;

interface PlacementStrategyContract
{
    public function placeSubmarine(SubmarineContract $submarine): void;
}
