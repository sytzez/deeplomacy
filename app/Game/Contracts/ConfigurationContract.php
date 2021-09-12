<?php

namespace App\Game\Contracts;

use App\Game\Data\Bounds;

interface ConfigurationContract
{
    public function getBounds(): Bounds;

    public function getDistanceSquaredMovablePerActionPoint(): int;

    public function getFieldOfViewSquared(): int;

    public function getDistanceSquaredAllowedToGiveActionPoints(): int;

    public function getDistanceSquaredAllowedToShareSonar(): int;
    public function getActionPointsRequiredToShareSonar(): int;

    public function getActionPointsRequiredToAttack(): int;

    public function getAmountOfActionPointsDistributed(): int;
}
