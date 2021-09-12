<?php

namespace App\Game\Contracts;

use App\Game\Data\Bounds;

interface ConfigurationContract
{
    public function getBounds(): Bounds;

    public function getDistanceSquaredMovablePerActionPoint(): int;

    public function getFieldOfViewSquared(): int;
}
