<?php

namespace Game\Services;

use Game\Contracts\GameContract;
use Game\Contracts\SubmarineRepositoryContract;

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
            $submarine->setActionPoints(
                $submarine->getActionPoints()->increasedBy($amount)
            );

            $this->submarineRepository->update($submarine);
        }
    }
}
