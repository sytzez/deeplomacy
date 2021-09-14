<?php

namespace App\Game\Factories;

use App\Game\Contracts\GameContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\Cell;
use App\Game\Data\Grid;
use App\Game\Data\MoveSubmarineData;
use App\Game\Data\Position;
use App\Game\Services\VisibilityService;
use App\Game\Validators\MoveSubmarineValidator;
use Exception;

class GridFactory
{
    /** @var array<array<Cell>> */
    protected array $rows;

    protected GameContract $game;

    protected SubmarineContract $viewer;

    public function __construct(
        protected VisibilityService $visibilityService,
        protected SubmarineRepositoryContract $submarineRepositoryContract,
        protected MoveSubmarineValidator $moveSubmarineValidator,
    ) {
    }

    public function make(GameContract $game, SubmarineContract $viewer): Grid
    {
        $this->game = $game;
        $this->viewer = $viewer;

        $this->createCells();

        $this->insertSubmarines();

        return new Grid($this->rows);
    }

    protected function createCells(): void
    {
        $bounds = $this->game->getConfiguration()->getBounds();

        $topLeft = $bounds->getTopLeft();
        $bottomRight = $bounds->getBottomRight();

        $this->rows = [];

        for ($y = $topLeft->getY(); $y <=$bottomRight->getY(); $y++) {
            $row = [];

            for ($x = $topLeft->getX(); $x <= $bottomRight->getX(); $x++) {
                $row[] = $this->createCell(new Position($x, $y));
            }

            $this->rows[] = $row;
        }
    }

    protected function createCell(Position $position): Cell
    {
        $isVisible = $this->visibilityService->canSeePosition($this->viewer, $position);

        $canMoveTowards = false;

        try {
            $this->moveSubmarineValidator->validate(new MoveSubmarineData(
                $this->viewer,
                $this->viewer->getPosition()->getOffsetTo($position)
            ));

            $canMoveTowards = true;
        } catch(Exception $e) {
        }

        return new Cell(
            $isVisible,
            $canMoveTowards,
        );
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
                $this->getCell($submarine->getPosition())
                    ->withSubmarine($submarine)
            );
        }
    }

    protected function getCell(Position $position): Cell
    {
        return $this->rows[$position->getY()][$position->getX()];
    }

    protected function replaceCell(Position $position, Cell $cell): void
    {
        $this->rows[$position->getY()][$position->getX()] = $cell;
    }
}
