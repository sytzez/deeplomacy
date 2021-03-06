<?php

namespace Game\Factories;

use Game\Contracts\GameContract;
use Game\Contracts\SubmarineContract;
use Game\Contracts\SubmarineRepositoryContract;
use Game\Data\ActionPoints;
use Game\Data\AttackSubmarineData;
use Game\Data\Cell;
use Game\Data\GiveActionPointsData;
use Game\Data\Grid;
use Game\Data\MoveSubmarineData;
use Game\Data\Position;
use Game\Data\ShareSonarData;
use Game\Services\AttackSubmarineService;
use Game\Services\MoveSubmarineService;
use Game\Services\ShareSonarService;
use Game\Services\VisibilityService;
use Game\Validators\AttackSubmarineValidator;
use Game\Validators\GiveActionPointsValidator;
use Game\Validators\MoveSubmarineValidator;
use Game\Validators\ShareSonarValidator;
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
        protected AttackSubmarineValidator $attackSubmarineValidator,
        protected ShareSonarValidator $shareSonarValidator,
        protected GiveActionPointsValidator $giveActionPointsValidator,
        protected MoveSubmarineService $moveSubmarineService,
        protected AttackSubmarineService $attackSubmarineService,
        protected ShareSonarService $shareSonarService,
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

        for ($y = $topLeft->getY(); $y <= $bottomRight->getY(); $y++) {
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

        $canMoveTowards = $this->canMoveTowards($position);

        $actionPointsToMove = $canMoveTowards ? $this->getActionPointsToMoveTowards($position) : null;

        return new Cell(
            $position,
            $isVisible,
            $canMoveTowards,
            $actionPointsToMove,
        );
    }

    protected function canMoveTowards(Position $position): bool
    {
        try {
            $this->moveSubmarineValidator->validate(
                new MoveSubmarineData(
                    $this->viewer,
                    $this->viewer->getPosition()->getOffsetTo($position)
                )
            );

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function getActionPointsToMoveTowards(Position $position): ActionPoints
    {
        return $this->moveSubmarineService->getActionPointsRequired(
            new MoveSubmarineData(
                $this->viewer,
                $this->viewer->getPosition()->getOffsetTo($position)
            )
        );
    }

    protected function insertSubmarines(): void
    {
        $submarines = $this->submarineRepositoryContract->getAll($this->game);

        foreach ($submarines as $submarine) {
            if (! $this->visibilityService->canSeeSubmarine($this->viewer, $submarine)) {
                continue;
            }

            $cell = $this->getCell($submarine->getPosition())
                ->withSubmarine(
                    $submarine,
                    $this->canAttack($submarine),
                    $this->getActionPointsToAttack($submarine),
                    $this->canShareSonar($submarine),
                    $this->getActionPointsToShareSonar($submarine),
                    $this->canGiveActionPoints($submarine),
                );

            $this->replaceCell(
                $submarine->getPosition(),
                $cell,
            );
        }
    }

    protected function canAttack(SubmarineContract $submarine): bool
    {
        try {
            $this->attackSubmarineValidator->validate(new AttackSubmarineData($this->viewer, $submarine));

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function getActionPointsToAttack(SubmarineContract $submarine): ActionPoints
    {
        return $this->attackSubmarineService->getActionPointsRequired(
            new AttackSubmarineData($this->viewer, $submarine)
        );
    }

    protected function canShareSonar(SubmarineContract $submarine): bool
    {
        try {
            $this->shareSonarValidator->validate(new ShareSonarData($this->viewer, $submarine));

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function getActionPointsToShareSonar(SubmarineContract $submarine): ActionPoints
    {
        return $this->shareSonarService->getActionPointsRequired(
            new ShareSonarData($this->viewer, $submarine)
        );
    }

    protected function canGiveActionPoints(SubmarineContract $submarine): bool
    {
        try {
            $this->giveActionPointsValidator->validate(new GiveActionPointsData(
                $this->viewer,
                $submarine,
                new ActionPoints(1),
            ));

            return true;
        } catch (Exception $e) {
            return false;
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
