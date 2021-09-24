<?php

namespace Game\Actions;

use Game\Data\AttackSubmarineData;
use Game\Data\GameActionException;
use Game\Enums\Messages;
use Game\Services\AttackSubmarineService;
use Game\Validators\AttackSubmarineValidator;

class AttackSubmarineAction
{
    public function __construct(
        protected AttackSubmarineValidator $validator,
        protected AttackSubmarineService $attackSubmarineService,
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

        return $this->attackSubmarineService->attackSubmarine($data)
            ? Messages::HIT
            : Messages::MISS;
    }
}
