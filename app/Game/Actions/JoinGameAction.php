<?php

namespace App\Game\Actions;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\JoinGameData;

class JoinGameAction
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
    ) {
    }

    public function do(JoinGameData $data): void
    {
        $submarine = $data->getSubmarine();

        $this->placeSubmarine($data);

        $this->grantActionPoints($data);

        $this->submarineRepository->update($submarine);
    }

    protected function placeSubmarine(JoinGameData $data): void
    {
        $submarine = $data->getSubmarine();

        do {
            $data->getPlacementStrategy()->placeSubmarine($submarine);
        } while (
            $this->submarineRepository->getAtPosition(
                $submarine->getGame(),
                $submarine->getPosition(),
            )
        );
    }

    protected function grantActionPoints(JoinGameData $data): void
    {
        $data->getSubmarine()->setActionPoints(
            $data->getSubmarine()
                ->getGame()
                ->getConfiguration()
                ->getAmountOfActionPointsDistributed()
        );
    }
}
