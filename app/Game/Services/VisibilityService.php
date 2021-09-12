<?php

namespace App\Game\Services;

use App\Game\Contracts\SubmarineContract;
use App\Game\Data\Position;

class VisibilityService
{
    public function canSeePosition(SubmarineContract $submarine, Position $position): bool
    {
        if ($this->positionIsWithinFieldOfView($submarine, $position)) {
            return true;
        }

        foreach ($submarine->getSonarSharedBy() as $sharedSubmarine) {
            if ($this->positionIsWithinFieldOfView($sharedSubmarine, $position)) {
                return true;
            }
        }

        return false;
    }

    protected function positionIsWithinFieldOfView(SubmarineContract $submarine, Position $position): bool
    {
        $distanceSquared = $submarine->getPosition()
            ->getOffsetTo($position)
            ->getDistanceSquared();

        $fieldOfViewSquared = $submarine->getGame()->getFieldOfViewSquared();

        return $distanceSquared <= $fieldOfViewSquared;
    }
}
