<?php

namespace App\Game\Services;

use App\Game\Contracts\SubmarineContract;

class SubmarineService
{
    public function getDistanceSquared(SubmarineContract $a, SubmarineContract $b): int
    {
        return $a->getPosition()
            ->getOffsetTo($b->getPosition())
            ->getDistanceSquared();
    }
}
