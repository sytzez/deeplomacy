<?php

namespace App\Game\Contracts;

use App\Game\Data\Bounds;

interface GameContract
{
    /**
     * @return iterable<SubmarineContract>
     */
    public function getSubmarines(): iterable;
    public function addSubmarine(SubmarineContract $submarine): static;

    public function getBounds(): Bounds;

    public function getDistanceSquaredMovablePerActionPoint(): int;
}
