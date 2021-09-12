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

    public function shareSonar(ShareSonarData $data): void
    {
        $data->getDonor()->shareSonarTo($data->getRecipient());

        $this->submarineRepository->update($donor);
    }
}
