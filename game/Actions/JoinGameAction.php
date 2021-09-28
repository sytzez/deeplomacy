<?php

namespace Game\Actions;

use Game\Contracts\SubmarineRepositoryContract;
use Game\Data\JoinGameData;
use Game\Services\WinningService;

class JoinGameAction
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
        protected WinningService $winningService,
    ) {
    }

    public function do(JoinGameData $data): void
    {
        $submarine = $data->getSubmarine();

        $this->placeSubmarine($data);

        $this->grantActionPoints($data);

        $this->submarineRepository->update($submarine);

        $this->winningService->checkVictory($submarine->getGame());
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
