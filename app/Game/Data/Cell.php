<?php

namespace App\Game\Data;

use App\Game\Contracts\SubmarineContract;

class Cell
{
    public function __construct(
        protected bool $isVisible,
        protected ?SubmarineContract $submarine = null,
    ) {
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    public function getSubmarine(): ?SubmarineContract
    {
        return $this->submarine;
    }
}
