<?php

namespace App\Game\Actions;

use App\Game\Data\GameActionException;
use App\Game\Data\ShareSonarData;
use App\Game\Services\ShareSonarService;
use App\Game\Validators\ShareSonarValidator;

class ShareSonarAction
{
    public function __construct(
        protected ShareSonarValidator $validator,
        protected ShareSonarService $shareSonarService,
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
    }
}
