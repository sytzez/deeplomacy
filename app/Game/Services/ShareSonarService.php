<?php

namespace App\Game\Services;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\ShareSonarData;

class ShareSonarService
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
        protected SubmarineService $submarineService,
    ) {
    }

    public function areSubmarinesWithinRange(ShareSonarData $data): bool
    {
        $donor     = $data->getDonor();
        $recipient = $data->getRecipient();

        $distanceSquared = $this->submarineService->getDistanceSquared($donor, $recipient);

        $distanceSquaredAllowed = $donor->getGame()
            ->getConfiguration()
            ->getDistanceSquaredAllowedToShareSonar();

        return $distanceSquared <= $distanceSquaredAllowed;
    }

    public function getActionPointsRequired(ShareSonarData $data): int
    {
        return $data
            ->getDonor()
            ->getGame()
            ->getConfiguration()
            ->getActionPointsRequiredToShareSonar();
    }

    public function shareSonar(ShareSonarData $data): void
    {
        $donor = $data->getDonor();

        $donor->shareSonarTo($data->getRecipient());

        $donor->setActionPoints($donor->getActionPoints() - $this->getActionPointsRequired($data));

        $this->submarineRepository->update($donor);
    }
}
