<?php

namespace App\Game\Data;

use App\Models\Submarine;

class Cell
{
    public function __construct(
        protected bool $isVisible,
        protected ?Submarine $submarine = null,
    ) {
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    public function getSubmarine(): ?Submarine
    {
        return $this->submarine;
    }
}
