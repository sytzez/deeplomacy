<?php

namespace Game\Services;

use Game\Contracts\SubmarineContract;
use Game\Data\Position;

class VisibilityService
{
    public function canSeeSubmarine(SubmarineContract $seeer, SubmarineContract $seen): bool
    {
        return $this->canSeePosition($seeer, $seen->getPosition());
    }

    public function canSeePosition(SubmarineContract $submarine, Position $position): bool
    {
        if ($this->isPositionWithinFieldOfView($submarine, $position)) {
            return true;
        }

        foreach ($submarine->getSonarSharedFrom() as $sharedSubmarine) {
            if ($this->isPositionWithinFieldOfView($sharedSubmarine, $position)) {
                return true;
            }
        }

        return false;
    }

    protected function isPositionWithinFieldOfView(SubmarineContract $submarine, Position $position): bool
    {
        $distanceSquared = $submarine->getPosition()
            ->getOffsetTo($position)
            ->getDistanceSquared();

        $fieldOfViewSquared = $submarine->getGame()
            ->getConfiguration()
            ->getFieldOfViewSquared();

        return $distanceSquared->fitsInside($fieldOfViewSquared);
    }
}
