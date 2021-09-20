<?php

namespace App\Game\Actions;

use App\Game\Data\AttackSubmarineData;
use App\Game\Data\GameActionException;
use App\Game\Enums\Messages;
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
