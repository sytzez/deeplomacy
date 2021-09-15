<?php

namespace App\Game\Services;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\GiveActionPointsData;

class GiveActionPointsService
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
        protected SubmarineService $submarineService,
    ) {
    }

    public function areSubmarinesWithinRange(GiveActionPointsData $data): bool
    {
        $donor     = $data->getDonor();
        $recipient = $data->getRecipient();

        $distanceSquared = $this->submarineService->getDistanceSquared($donor, $recipient);

        $distanceSquaredAllowed = $donor->getGame()
            ->getConfiguration()
            ->getDistanceSquaredAllowedToGiveActionPoints();

        return $distanceSquared <= $distanceSquaredAllowed;
    }

    public function giveActionPoints(GiveActionPointsData $data): void
    {
        $donor     = $data->getDonor();
        $recipient = $data->getRecipient();
        $amount    = $data->getActionPoints();

        $donor->setActionPoints(
            $donor->getActionPoints()->decreasedBy($amount)
        );

        $recipient->setActionPoints(
            $recipient->getActionPoints()->increasedBy($amount)
        );

        $this->submarineRepository->update($donor);
        $this->submarineRepository->update($recipient);
    }
}
