<?php

namespace App\Game\Actions;

use App\Game\Data\AttackSubmarineData;
use App\Game\Data\GameActionException;
use App\Game\Services\AttackSubmarineService;
use App\Game\Validators\AttackSubmarineValidator;

class AttackSubmarineAction
{
    public function __construct(
        protected AttackSubmarineValidator $validator,
        protected AttackSubmarineService $attackSubmarineService,
    ) {
    }

    /**
     * @param AttackSubmarineData $data
     * @throws GameActionException
     */
    public function do(AttackSubmarineData $data): void
    {
        $this->validator->validate($data);

        $this->attackSubmarineService->attackSubmarine($data);
    }
}
