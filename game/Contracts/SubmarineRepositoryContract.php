<?php

namespace Game\Contracts;

use Game\Data\Position;

interface SubmarineRepositoryContract
{
    public function create(GameContract $game, SubmarineContract $submarine): static;

    public function update(SubmarineContract $submarine): static;

    /**
     * @param GameContract $game
     * @return iterable<SubmarineContract>
     */
    public function getAll(GameContract $game): iterable;

    public function getAtPosition(GameContract $game, Position $position): ?SubmarineContract;
}
