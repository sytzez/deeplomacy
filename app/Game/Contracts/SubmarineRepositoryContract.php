<?php

namespace App\Game\Contracts;

use App\Game\Data\Position;

interface SubmarineRepositoryContract
{
    public function save(SubmarineContract $submarine): static;

    /**
     * @param GameContract $game
     * @return iterable<SubmarineContract>
     */
    public function getAll(GameContract $game): iterable;

    public function getAtPosition(GameContract $game, Position $position): ?SubmarineContract;
}
