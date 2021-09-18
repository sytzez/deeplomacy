<?php

namespace App\Game\Services;

use App\Game\Contracts\SubmarineContract;
use App\Game\Data\DistanceSquared;

class SubmarineService
{
    public function getDistanceSquared(SubmarineContract $a, SubmarineContract $b): DistanceSquared
    {
        return $a->getPosition()
            ->getOffsetTo($b->getPosition())
            ->getDistanceSquared();
    }
}
