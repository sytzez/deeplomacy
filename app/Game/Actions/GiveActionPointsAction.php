<?php

namespace App\Game\Actions;

use App\Game\Data\GameActionException;
use App\Game\Data\GiveActionPointsData;
use App\Game\Services\GiveActionPointsService;
use App\Game\Validators\GiveActionPointsValidator;

class GiveActionPointsAction
{
    public function __construct(
        protected GiveActionPointsValidator $validator,
        protected GiveActionPointsService $giveActionPointsService,
    ) {
    }

    /**
     * @param GiveActionPointsData $data
     * @throws GameActionException
     */
    public function do(GiveActionPointsData $data): void
    {
        $this->validator->validate($data);

        $this->giveActionPointsService->giveActionPoints($data);
    }
}
