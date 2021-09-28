<?php

namespace Game\Actions;

use Game\Data\GameActionException;
use Game\Data\ShareSonarData;
use Game\Services\ShareSonarService;
use Game\Services\WinningService;
use Game\Validators\ShareSonarValidator;

class ShareSonarAction
{
    public function __construct(
        protected ShareSonarValidator $validator,
        protected ShareSonarService $shareSonarService,
        protected WinningService $winningService,
    ) {
    }

    /**
     * @param ShareSonarData $data
     * @throws GameActionException
     */
    public function do(ShareSonarData $data): void
    {
        $this->validator->validate($data);

        $this->shareSonarService->shareSonar($data);

        $this->winningService->checkVictory($data->getRecipient()->getGame());
    }
}
