<?php

namespace App\Game\Contracts;

interface RngServiceContract
{
    public function getBool(float $chanceOfTrue): bool;

    public function getInt(int $min, int $max): int;
}
