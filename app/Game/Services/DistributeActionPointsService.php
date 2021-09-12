<?php

namespace App\Game\Services;

use App\Game\Contracts\GameContract;
use App\Game\Contracts\SubmarineRepositoryContract;

class DistributeActionPointsService
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
    ) {
    }

    public function distributeActionPoints(GameContract $game): void
    {
        $amount = $game->getConfiguration()->getAmountOfActionPointsDistributed();

        $submarines = $this->submarineRepository->getAll($game);

        foreach ($submarines as $submarine) {
            $submarine->setActionPoints($submarine->getActionPoints() + $amount);

            $this->submarineRepository->update($submarine);
        }
    }
}
