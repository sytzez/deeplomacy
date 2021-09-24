<?php

namespace Game\Strategies;

use Game\Contracts\PlacementStrategyContract;
use Game\Contracts\RngServiceContract;
use Game\Contracts\SubmarineContract;
use Game\Data\Position;

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
