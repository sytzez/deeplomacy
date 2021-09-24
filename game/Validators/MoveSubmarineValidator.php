<?php

namespace Game\Validators;

use Game\Contracts\SubmarineRepositoryContract;
use Game\Data\GameActionException;
use Game\Data\MoveSubmarineData;
use Game\Enums\Errors;
use Game\Services\MoveSubmarineService;

class MoveSubmarineValidator
{
    protected MoveSubmarineData $data;

    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
        protected MoveSubmarineService $moveSubmarineService,
    ) {
    }

    /**
     * @param MoveSubmarineData $data
     * @throws GameActionException
     */
    public function validate(MoveSubmarineData $data): void
    {
        $this->data = $data;

        $this->checkDestinationWithinBounds();

        $this->checkSufficientActionPoints();

        $this->checkIfNoSubmarineExistsAtDestination();
    }

    /**
     * @throws GameActionException
     */
    protected function checkDestinationWithinBounds(): void
    {
        $destination = $this->moveSubmarineService->getDestination($this->data);

        if (
            ! $this->data->getSubmarine()
            ->getGame()
            ->getConfiguration()
            ->getBounds()
            ->containsPosition($destination)
        ) {
            throw new GameActionException(Errors::DESTINATION_OUT_OF_BOUNDS);
        }
    }

    /**
     * @throws GameActionException
     */
    protected function checkSufficientActionPoints(): void
    {
        $actionPointsRequired = $this->moveSubmarineService->getActionPointsRequired($this->data);

        if (
            ! $this->data->getSubmarine()
                ->getActionPoints()
                ->canAfford($actionPointsRequired)
        ) {
            throw new GameActionException(Errors::INSUFFICIENT_ACTION_POINTS);
        }
    }

    /**
     * @throws GameActionException
     */
    protected function checkIfNoSubmarineExistsAtDestination(): void
    {
        $game = $this->data->getSubmarine()->getGame();

        $destination = $this->moveSubmarineService->getDestination($this->data);

        $submarineAtDestination = $this->submarineRepository->getAtPosition($game, $destination);

        if (! is_null($submarineAtDestination)) {
            throw new GameActionException(Errors::SUBMARINE_AT_DESTINATION);
        }
    }
}
