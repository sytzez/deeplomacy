<?php

namespace App\Game\Validators;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\MoveSubmarineData;
use App\Game\Enums\Errors;
use App\Game\Services\MoveSubmarineService;
use Exception;

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
     * @throws Exception
     */
    public function validate(MoveSubmarineData $data): void
    {
        $this->data = $data;

        $this->checkDestinationWithinBounds();

        $this->checkSufficientActionPoints();

        $this->checkIfNoSubmarineExistsAtDestination();
    }

    /**
     * @throws Exception
     */
    protected function checkDestinationWithinBounds(): void
    {
        $destination = $this->moveSubmarineService->getDestination($this->data);

        if (! $this->data->getSubmarine()
            ->getGame()
            ->getBounds()
            ->containsPosition($destination)
        ) {
            throw new Exception(Errors::DESTINATION_OUT_OF_BOUNDS);
        }
    }

    /**
     * @throws Exception
     */
    protected function checkSufficientActionPoints(): void
    {
        $actionPointsRequired = $this->moveSubmarineService->getActionPointsRequired($this->data);

        if ($this->data->getSubmarine()->getActionPoints() < $actionPointsRequired) {
            throw new Exception(Errors::INSUFFICIENT_ACTION_POINTS);
        }
    }

    /**
     * @throws Exception
     */
    protected function checkIfNoSubmarineExistsAtDestination(): void
    {
        $game = $this->data->getSubmarine()->getGame();

        $destination = $this->moveSubmarineService->getDestination($this->data);

        $submarineAtDestination = $this->submarineRepository->getAtPosition($game, $destination);

        if (! is_null($submarineAtDestination)) {
            throw new Exception(Errors::SUBMARINE_AT_DESTINATION);
        }
    }
}
