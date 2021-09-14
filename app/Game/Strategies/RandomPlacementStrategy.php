<?php

namespace App\Game\Strategies;

use App\Game\Contracts\PlacementStrategyContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Data\Position;

class RandomPlacementStrategy implements PlacementStrategyContract
{
    public function placeSubmarine(SubmarineContract $submarine): void
    {
        $bounds = $submarine->getGame()->getConfiguration()->getBounds();

        $topLeft = $bounds->getTopLeft();
        $bottomRight = $bounds->getBottomRight();

        $submarine->setPosition(new Position(
            random_int($topLeft->getX(), $bottomRight->getX()),
            random_int($topLeft->getY(), $bottomRight->getY()),
        ));
    }
}
