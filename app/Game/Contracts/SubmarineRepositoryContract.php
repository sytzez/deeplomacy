<?php

namespace App\Game\Contracts;

use App\Game\Data\Position;

interface SubmarineRepositoryContract
{
    public function save(SubmarineContract $submarine): static;

    public function getAtPosition(GameContract $game, Position $position): ?SubmarineContract;
}
