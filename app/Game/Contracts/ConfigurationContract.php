<?php

namespace App\Game\Contracts;

use App\Game\Data\ActionPoints;
use App\Game\Data\Bounds;

interface ConfigurationContract
{
    public function getBounds(): Bounds;

    public function getDistanceSquaredMovablePerActionPoint(): int;

    public function getFieldOfViewSquared(): int;

    public function getDistanceSquaredAllowedToGiveActionPoints(): int;

    public function getDistanceSquaredAllowedToShareSonar(): int;
    public function getActionPointsRequiredToShareSonar(): ActionPoints;

    public function getActionPointsRequiredToAttack(): ActionPoints;

    public function getAmountOfActionPointsDistributed(): ActionPoints;
}
