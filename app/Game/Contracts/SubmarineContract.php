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

    /**
     * @return iterable<static>
     */
    public function getSonarSharedBy(): iterable;

    /**
     * @return iterable<static>
     */
    public function getSonarSharedTo(): iterable;

    public function kill(): static;
}
