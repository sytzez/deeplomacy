<?php

namespace App\Game\Contracts;

use App\Game\Data\ActionPoints;
use App\Game\Data\Position;

interface SubmarineContract
{
    public function getGame(): GameContract;

    public function getPosition(): Position;
    public function setPosition(Position $position): static;

    public function getActionPoints(): ActionPoints;
    public function setActionPoints(ActionPoints $actionPoints): static;

    /**
     * @return iterable<static>
     */
    public function getSonarSharedFrom(): iterable;

    /**
     * @return iterable<static>
     */
    public function getSonarSharedTo(): iterable;

    public function shareSonarTo(self $recipient): static;

    public function kill(): static;

    public function is(self $submarine): bool;
}
