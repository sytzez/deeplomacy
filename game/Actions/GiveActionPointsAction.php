<?php

namespace Game\Actions;

use Game\Data\GameActionException;
use Game\Data\GiveActionPointsData;
use Game\Services\GiveActionPointsService;
use Game\Validators\GiveActionPointsValidator;

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
