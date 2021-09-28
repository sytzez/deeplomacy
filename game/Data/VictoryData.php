<?php

namespace Game\Data;

use Game\Contracts\SubmarineContract;

class VictoryData
{
    /**
     * @param bool $hasBeenWon
     * @param iterable<SubmarineContract>|null $winners
     */
    public function __construct(
        protected bool $hasBeenWon,
        protected ?iterable $winners = null,
    ) {
    }

    public function hasBeenWon(): bool
    {
        return $this->hasBeenWon;
    }

    /**
     * @return iterable<SubmarineContract>|null
     */
    public function getWinners(): ?iterable
    {
        return $this->winners;
    }
}
