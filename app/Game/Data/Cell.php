<?php

namespace App\Game\Data;

use App\Game\Contracts\SubmarineContract;

class Cell
{
    public function __construct(
        protected bool $isVisible,
        protected bool $canMoveTowards,
        protected ?SubmarineContract $submarine = null,
    ) {
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    public function canMoveTowards(): bool
    {
        return $this->canMoveTowards;
    }

    public function getSubmarine(): ?SubmarineContract
    {
        return $this->submarine;
    }

    public function withSubmarine(?SubmarineContract $submarine): Cell
    {
        return new Cell(
            $this->isVisible(),
            $this->canMoveTowards(),
            $submarine,
        );
    }
}
