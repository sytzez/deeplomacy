<?php

namespace Game\Contracts;

use Game\Data\ActionPoints;
use Game\Data\Position;

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

    public function hasSonarSharedFrom(self $submarine): bool;

    /**
     * @return iterable<static>
     */
    public function getSonarSharedTo(): iterable;

    public function hasSonarSharedTo(self $submarine): bool;

    public function shareSonarTo(self $recipient): static;

    public function kill(): static;

    public function is(self $submarine): bool;
}
