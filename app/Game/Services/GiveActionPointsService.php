<?php

namespace App\Game\Services;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\GiveActionPointsData;

class GiveActionPointsService
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
    ) {
    }

    public function giveActionPoints(GiveActionPointsData $data): void
    {
        $donor     = $data->getDonor();
        $recipient = $data->getRecipient();
        $amount    = $data->getAmount();

        $donor->setActionPoints($donor->getActionPoints() - $amount);
        $recipient->setActionPoints($recipient->getActionPoints() + $amount);

        $this->submarineRepository->save($donor);
        $this->submarineRepository->save($recipient);
    }
}
