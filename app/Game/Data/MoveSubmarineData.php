<?php

namespace App\Game\Data;

use App\Game\Contracts\SubmarineContract;

class MoveSubmarineData
{
    public function __construct(
        protected SubmarineContract $submarine,
        protected Offset $offset,
    ) {
    }

    public function getSubmarine(): SubmarineContract
    {
        return $this->submarine;
    }

    public function getOffset(): Offset
    {
        return $this->offset;
    }
}
