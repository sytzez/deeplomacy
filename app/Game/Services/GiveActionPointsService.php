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

    public function areSubmarinesWithinRange(GiveActionPointsData $data): bool
    {
        $donor     = $data->getDonor();
        $recipient = $data->getRecipient();

        $distanceSquared = $donor->getPosition()
            ->getOffsetTo($recipient->getPosition())
            ->getDistanceSquared();

        $distanceSquaredAllowed = $donor->getGame()
            ->getConfiguration()
            ->getDistanceSquaredAllowedToGiveActionPoints();

        return $distanceSquared <= $distanceSquaredAllowed;
    }

    public function giveActionPoints(GiveActionPointsData $data): void
    {
        $donor     = $data->getDonor();
        $recipient = $data->getRecipient();
        $amount    = $data->getAmount();

        $donor->setActionPoints($donor->getActionPoints() - $amount);
        $recipient->setActionPoints($recipient->getActionPoints() + $amount);

        $this->submarineRepository->update($donor);
        $this->submarineRepository->update($recipient);
    }
}
