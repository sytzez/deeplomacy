<?php

namespace App\Game\Actions;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\PlaceSubmarineData;

class PlaceSubmarineAction
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
    ) {
    }

    public function do(PlaceSubmarineData $data): void
    {
        $submarine = $data->getSubmarine();

        do {
            $data->getStrategy()->placeSubmarine($submarine);
        } while($this->submarineRepository->getAtPosition(
            $submarine->getGame(),
            $submarine->getPosition(),
        ));

        $this->submarineRepository->update($submarine);
    }
}
