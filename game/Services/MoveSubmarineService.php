<?php

namespace Game\Services;

use Game\Contracts\SubmarineRepositoryContract;
use Game\Data\ActionPoints;
use Game\Data\MoveSubmarineData;
use Game\Data\Position;

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
            (int) ceil(
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
