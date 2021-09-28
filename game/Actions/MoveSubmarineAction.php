<?php

namespace Game\Actions;

use Game\Data\GameActionException;
use Game\Data\MoveSubmarineData;
use Game\Services\MoveSubmarineService;
use Game\Services\WinningService;
use Game\Validators\MoveSubmarineValidator;

class MoveSubmarineAction
{
    public function __construct(
        protected MoveSubmarineValidator $validator,
        protected MoveSubmarineService $moveSubmarineService,
        protected WinningService $winningService,
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

        $this->winningService->checkVictory($data->getSubmarine()->getGame());
    }
}
