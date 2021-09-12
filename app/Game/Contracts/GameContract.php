<?php

namespace App\Game\Contracts;

interface GameContract
{
    /**
     * @return iterable<SubmarineContract>
     */
    public function getSubmarines(): iterable;
    public function addSubmarine(SubmarineContract $submarine): static;

    public function getDistanceSquaredMovablePerActionPoint(): int;
}
