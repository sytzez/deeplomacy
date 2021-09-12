<?php

namespace App\Game\Contracts;

use App\Game\Data\Bounds;

interface GameContract
{
    public function getConfiguration(): ConfigurationContract;
}
