<?php

namespace App\Services;

use App\Game\Contracts\RngServiceContract;

class RngService implements RngServiceContract
{
    public function getBool(float $chanceOfTrue): bool
    {
        return random_int(1, 1000) > $chanceOfTrue * 1000;
    }

    public function getInt(int $min, int $max): int
    {
        return random_int($min, $max);
    }
}
