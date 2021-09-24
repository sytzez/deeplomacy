<?php

namespace Game\Services;

use Game\Contracts\SubmarineContract;
use Game\Data\DistanceSquared;

class SubmarineService
{
    public function getDistanceSquared(SubmarineContract $a, SubmarineContract $b): DistanceSquared
    {
        return $a->getPosition()
            ->getOffsetTo($b->getPosition())
            ->getDistanceSquared();
    }
}
