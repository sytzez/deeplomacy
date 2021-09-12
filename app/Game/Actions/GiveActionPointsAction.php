<?php

namespace App\Game\Actions;

use App\Game\Data\GiveActionPointsData;
use App\Game\Services\GiveActionPointsService;
use App\Game\Validators\GiveActionPointsValidator;
use Exception;

class GiveActionPointsAction
{
    public function __construct(
        protected GiveActionPointsValidator $validator,
        protected GiveActionPointsService $giveActionPointsService,
    ) {
    }

    /**
     * @param GiveActionPointsData $data
     * @throws Exception
     */
    public function do(GiveActionPointsData $data): void
    {
        $this->validator->validate($data);

        $this->giveActionPointsService->giveActionPoints($data);
    }
}
