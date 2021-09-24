<?php

namespace Game\Contracts;

use Game\Data\ActionPoints;
use Game\Data\Bounds;
use Game\Data\DistanceSquared;

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
