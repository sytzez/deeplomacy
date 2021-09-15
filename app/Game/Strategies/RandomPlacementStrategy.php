<?php

namespace App\Game\Strategies;

use App\Game\Contracts\PlacementStrategyContract;
use App\Game\Contracts\RngServiceContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Data\Position;

class RandomPlacementStrategy implements PlacementStrategyContract
{
    public function __construct(
        protected RngServiceContract $rngService,
    ) {
    }

    public function placeSubmarine(SubmarineContract $submarine): void
    {
        $bounds = $submarine->getGame()->getConfiguration()->getBounds();

        $topLeft = $bounds->getTopLeft();
        $bottomRight = $bounds->getBottomRight();

        $submarine->setPosition(new Position(
            $this->rngService->getInt($topLeft->getX(), $bottomRight->getX()),
            $this->rngService->getInt($topLeft->getY(), $bottomRight->getY()),
        ));
    }
}
