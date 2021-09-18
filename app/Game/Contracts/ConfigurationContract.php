<?php

namespace App\Game\Contracts;

use App\Game\Data\ActionPoints;
use App\Game\Data\Bounds;
use App\Game\Data\DistanceSquared;

interface ConfigurationContract
{
    public function getBounds(): Bounds;

    public function getDistanceSquaredMovablePerActionPoint(): DistanceSquared;

    public function getFieldOfViewSquared(): DistanceSquared;

    public function getDistanceSquaredAllowedToGiveActionPoints(): DistanceSquared;

    public function getDistanceSquaredAllowedToShareSonar(): DistanceSquared;
    public function getActionPointsRequiredToShareSonar(): ActionPoints;

    public function getActionPointsRequiredToAttack(): ActionPoints;

    public function getAmountOfActionPointsDistributed(): ActionPoints;
}
