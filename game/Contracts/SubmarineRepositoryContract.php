<?php

namespace Game\Contracts;

use Game\Data\Position;
use Traversable;

interface SubmarineRepositoryContract
{
    public function create(GameContract $game, SubmarineContract $submarine): static;

    public function update(SubmarineContract $submarine): static;

    /**
     * @param GameContract $game
     * @return Traversable<SubmarineContract>
     */
    public function getAll(GameContract $game): Traversable;

    public function getAtPosition(GameContract $game, Position $position): ?SubmarineContract;
}
