<?php

namespace App\Game\Services;

use App\Game\Contracts\SubmarineRepositoryContract;
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
            ->addOffset($data->getOffset());
    }

    public function getActionPointsRequired(MoveSubmarineData $data): int
    {
        $distanceSquared = $data->getOffset()->getDistanceSquared();

        $distanceSquaredMovablePerActionPoint = $data->getSubmarine()
            ->getGame()
            ->getDistanceSquaredMovablePerActionPoint();

        return ceil($distanceSquared / $distanceSquaredMovablePerActionPoint);
    }

    public function moveSubmarine(MoveSubmarineData $data): void
    {
        $submarine = $data->getSubmarine();

        $submarine->setPosition($this->getDestination($data));

        $submarine->setActionPoints($submarine->getActionPoints() - $this->getActionPointsRequired($data));

        $this->submarineRepository->save($submarine);
    }
}
