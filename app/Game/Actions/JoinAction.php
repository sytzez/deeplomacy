<?php

namespace App\Game\Actions;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\JoinData;

class JoinAction
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
    ) {
    }

    public function do(JoinData $data): void
    {
        $submarine = $data->getSubmarine();

        $this->placeSubmarine($data);

        $this->grantActionPoints($data);

        $this->submarineRepository->update($submarine);
    }

    protected function placeSubmarine(JoinData $data): void
    {
        $submarine = $data->getSubmarine();

        do {
            $data->getPlacementStrategy()->placeSubmarine($submarine);
        } while(
            $this->submarineRepository->getAtPosition(
                $submarine->getGame(),
                $submarine->getPosition(),
            )
        );
    }

    protected function grantActionPoints(JoinData $data): void
    {
        $data->getSubmarine()->setActionPoints(
            $data->getSubmarine()
                ->getGame()
                ->getConfiguration()
                ->getAmountOfActionPointsDistributed()
        );
    }
}
