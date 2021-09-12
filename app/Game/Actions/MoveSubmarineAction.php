<?php

namespace App\Game\Actions;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\MoveSubmarineData;
use App\Game\Validators\MoveSubmarineValidator;
use Exception;

class MoveSubmarineAction
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
        protected MoveSubmarineValidator $validator,
    ) {
    }

    /**
     * @param MoveSubmarineData $data
     * @throws Exception
     */
    public function do(MoveSubmarineData $data): void
    {
        $this->validator->validate($data);

        $this->execute($data);
    }

    protected function execute(MoveSubmarineData $data): void
    {
        $submarine = $data->getSubmarine();

        $destination = $submarine->getPosition()
            ->addOffset($data->getOffset());

        $submarine->setPosition($destination);

        $this->submarineRepository->save($submarine);
    }
}
