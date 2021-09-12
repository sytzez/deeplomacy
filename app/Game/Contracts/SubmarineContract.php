<?php

namespace App\Game\Contracts;

use App\Game\Data\Position;

interface SubmarineContract
{
    public function getGame(): GameContract;

    public function getPosition(): Position;
    public function setPosition(Position $position): static;

    public function getActionPoints(): int;
    public function setActionPoints(int $actionPoints): static;

    public function kill(): static;
}
