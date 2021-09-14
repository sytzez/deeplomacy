<?php

namespace App\Game\Factories;

use App\Game\Contracts\GameContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Data\Cell;
use App\Game\Data\Grid;
use App\Game\Data\Position;
use App\Game\Services\VisibilityService;

class GridFactory
{
    public function __construct(
        protected VisibilityService $visibilityService,
    ) {
    }

    public function make(GameContract $game, SubmarineContract $viewer): Grid
    {
        $bounds = $game->getConfiguration()->getBounds();

        $topLeft = $bounds->getTopLeft();
        $bottomRight = $bounds->getBottomRight();

        $rows = [];

        for ($y = $topLeft->getY(); $y <=$bottomRight->getY(); $y++) {
            $row = [];

            for ($x = $topLeft->getX(); $x <= $bottomRight->getX(); $x++) {
                $position = new Position($x, $y);

                $row[] = new Cell($this->visibilityService->canSeePosition($viewer, $position));
            }

            $rows[] = $row;
        }

        return new Grid($rows);
    }
}
