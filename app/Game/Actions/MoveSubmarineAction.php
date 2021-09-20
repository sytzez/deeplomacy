<?php

namespace App\Game\Actions;

use App\Game\Data\GameActionException;
use App\Game\Data\MoveSubmarineData;
use App\Game\Services\MoveSubmarineService;
use App\Game\Validators\MoveSubmarineValidator;

class MoveSubmarineAction
{
    public function __construct(
        protected MoveSubmarineValidator $validator,
        protected MoveSubmarineService $moveSubmarineService,
    ) {
    }

    /**
     * @param MoveSubmarineData $data
     * @throws GameActionException
     */
    public function do(MoveSubmarineData $data): void
    {
        $this->validator->validate($data);

        $this->moveSubmarineService->moveSubmarine($data);
    }
}
