<?php

namespace App\Game\Validators;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\MoveSubmarineData;
use App\Game\Enums\Errors;
use Exception;

class MoveSubmarineValidator
{
    protected MoveSubmarineData $data;

    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
    ) {
    }

    /**
     * @param MoveSubmarineData $data
     * @throws Exception
     */
    public function validate(MoveSubmarineData $data): void
    {
        $this->data = $data;

        $this->checkIfNoSubmarineExistsAtDestination();
    }

    /**
     * @throws Exception
     */
    protected function checkIfNoSubmarineExistsAtDestination(): void
    {
        $destination = $this->data->getSubmarine()
            ->getPosition()
            ->addOffset($this->data->getOffset());

        $submarineAtDestination = $this->submarineRepository->getAtPosition($destination);

        if (! is_null($submarineAtDestination)) {
            throw new Exception(Errors::SUBMARINE_AT_DESTINATION);
        }
    }
}
