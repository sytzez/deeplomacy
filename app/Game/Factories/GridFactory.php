<?php

namespace App\Game\Factories;

use App\Game\Contracts\GameContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\Cell;
use App\Game\Data\Grid;
use App\Game\Data\Position;
use App\Game\Services\VisibilityService;

class GridFactory
{
    public function __construct(
        protected VisibilityService $visibilityService,
        protected SubmarineRepositoryContract $submarineRepositoryContract,
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

        $submarines = $this->submarineRepositoryContract->getAll($game);

        foreach ($submarines as $submarine) {
            if (! $this->visibilityService->canSeeSubmarine($viewer, $submarine)) {
                continue;
            }

            $rows[$submarine->getPosition()->getY()][$submarine->getPosition()->getX()] =
                new Cell(true, $submarine);
        }

        return new Grid($rows);
    }
}
