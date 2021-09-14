<?php

namespace App\Game\Actions;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\JoinSubmarineData;

class JoinSubmarineAction
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
    ) {
    }

    public function do(JoinSubmarineData $data): void
    {
        $submarine = $data->getSubmarine();

        $this->placeSubmarine($data);

        $this->grantActionPoints($data);

        $this->submarineRepository->update($submarine);
    }

    protected function placeSubmarine(JoinSubmarineData $data): void
    {
        $submarine = $data->getSubmarine();

        do {
            $data->getStrategy()->placeSubmarine($submarine);
        } while($this->submarineRepository->getAtPosition(
            $submarine->getGame(),
            $submarine->getPosition(),
        ));
    }

    protected function grantActionPoints(JoinSubmarineData $data): void
    {
        $data->getSubmarine()->setActionPoints(
            $data->getSubmarine()
                ->getGame()
                ->getConfiguration()
                ->getAmountOfActionPointsDistributed()
        );
    }
}
