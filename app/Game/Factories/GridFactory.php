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
    /** @var array<array<Cell>> */
    protected array $rows;

    protected GameContract $game;

    protected SubmarineContract $viewer;

    public function __construct(
        protected VisibilityService $visibilityService,
        protected SubmarineRepositoryContract $submarineRepositoryContract,
    ) {
    }

    public function make(GameContract $game, SubmarineContract $viewer): Grid
    {
        $this->game = $game;
        $this->viewer = $viewer;

        $this->generateGridWithVisibility();

        $this->insertSubmarines();

        return new Grid($this->rows);
    }

    protected function generateGridWithVisibility(): void
    {
        $bounds = $this->game->getConfiguration()->getBounds();

        $topLeft = $bounds->getTopLeft();
        $bottomRight = $bounds->getBottomRight();

        $this->rows = [];

        for ($y = $topLeft->getY(); $y <=$bottomRight->getY(); $y++) {
            $row = [];

            for ($x = $topLeft->getX(); $x <= $bottomRight->getX(); $x++) {
                $position = new Position($x, $y);

                $row[] = new Cell($this->visibilityService->canSeePosition($this->viewer, $position));
            }

            $this->rows[] = $row;
        }
    }

    protected function insertSubmarines(): void
    {
        $submarines = $this->submarineRepositoryContract->getAll($this->game);

        foreach ($submarines as $submarine) {
            if (! $this->visibilityService->canSeeSubmarine($this->viewer, $submarine)) {
                continue;
            }

            $this->replaceCell(
                $submarine->getPosition(),
                new Cell(true, $submarine),
            );
        }
    }

    protected function replaceCell(Position $position, Cell $cell): void
    {
        $this->rows[$position->getY()][$position->getX()] = $cell;
    }
}
