<?php

namespace App\Game\Actions;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\MoveSubmarineData;
use App\Game\Services\MoveSubmarineService;
use App\Game\Validators\MoveSubmarineValidator;
use Exception;

class MoveSubmarineAction
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
        protected MoveSubmarineValidator $validator,
        protected MoveSubmarineService $moveSubmarineService,
    ) {
    }

    /**
     * @param MoveSubmarineData $data
     * @throws Exception
     */
    public function do(MoveSubmarineData $data): void
    {
        $this->validator->validate($data);

        $this->moveSubmarineService->moveSubmarine($data);
    }
}
