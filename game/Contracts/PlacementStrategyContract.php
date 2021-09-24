<?php

namespace Game\Contracts;

interface PlacementStrategyContract
{
    public function placeSubmarine(SubmarineContract $submarine): void;
}
