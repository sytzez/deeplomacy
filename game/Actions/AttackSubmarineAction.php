<?php

namespace Game\Actions;

use Game\Data\AttackSubmarineData;
use Game\Data\GameActionException;
use Game\Enums\Messages;
use Game\Services\AttackSubmarineService;
use Game\Services\WinningService;
use Game\Validators\AttackSubmarineValidator;

class AttackSubmarineAction
{
    public function __construct(
        protected AttackSubmarineValidator $validator,
        protected AttackSubmarineService $attackSubmarineService,
        protected WinningService $winningService,
    ) {
    }

    /**
     * @param AttackSubmarineData $data
     * @return string
     * @throws GameActionException
     */
    public function do(AttackSubmarineData $data): string
    {
        $this->validator->validate($data);

        $attackResult = $this->attackSubmarineService->attackSubmarine($data);

        $this->winningService->checkVictory($data->getAttacker()->getGame());

        return $attackResult
            ? Messages::HIT
            : Messages::MISS;
    }
}
