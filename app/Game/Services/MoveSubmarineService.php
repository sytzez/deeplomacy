<?php

namespace App\Game\Services;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\ActionPoints;
use App\Game\Data\MoveSubmarineData;
use App\Game\Data\Position;

class MoveSubmarineService
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
    ) {
    }

    public function getDestination(MoveSubmarineData $data): Position
    {
        return $data->getSubmarine()
            ->getPosition()
            ->translatedBy($data->getOffset());
    }

    public function getActionPointsRequired(MoveSubmarineData $data): ActionPoints
    {
        $distanceSquared = $data->getOffset()->getDistanceSquared();

        $distanceSquaredMovablePerActionPoint = $data->getSubmarine()
            ->getGame()
            ->getConfiguration()
            ->getDistanceSquaredMovablePerActionPoint();

        return new ActionPoints(
            ceil(
                $distanceSquared->getRoot()
                / $distanceSquaredMovablePerActionPoint->getRoot()
            )
        );
    }

    public function moveSubmarine(MoveSubmarineData $data): void
    {
        $cost = $this->getActionPointsRequired($data);

        $submarine = $data->getSubmarine();

        $submarine->setPosition($this->getDestination($data));

        $submarine->setActionPoints(
            $submarine->getActionPoints()->decreasedBy($cost)
        );

        $this->submarineRepository->update($submarine);
    }
}
