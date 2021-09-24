<?php

namespace App\Game\Data;

use App\Game\Contracts\SubmarineContract;

class Cell
{
    public function __construct(
        protected Position $position,
        protected bool $isVisible,
        protected bool $canMoveTowards,
        protected ?ActionPoints $actionPointsToMove = null,
        protected ?SubmarineContract $submarine = null,
        protected bool $canAttack = false,
        protected ?ActionPoints $actionPointsToAttack = null,
        protected bool $canShareSonar = false,
        protected ?ActionPoints $actionPointsToShareSonar = null,
        protected bool $canGiveActionPoints = false,
    ) {
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    public function canMoveTowards(): bool
    {
        return $this->canMoveTowards;
    }

    public function getActionPointsToMove(): ?ActionPoints
    {
        return $this->actionPointsToMove;
    }

    public function getSubmarine(): ?SubmarineContract
    {
        return $this->submarine;
    }

    public function canAttack(): bool
    {
        return $this->canAttack;
    }

    public function getActionPointsToAttack(): ?ActionPoints
    {
        return $this->actionPointsToAttack;
    }

    public function canShareSonar(): bool
    {
        return $this->canShareSonar;
    }

    public function getActionPointsToShareSonar(): ?ActionPoints
    {
        return $this->actionPointsToShareSonar;
    }

    public function canGiveActionPoints(): bool
    {
        return $this->canGiveActionPoints;
    }

    public function withSubmarine(
        ?SubmarineContract $submarine,
        bool $canAttack = false,
        ?ActionPoints $actionPointsToAttack = null,
        bool $canShareSonar = false,
        ?ActionPoints $actionPointsToShareSonar = null,
        bool $canGiveActionPoints = false,
    ): self {
        return new self(
            $this->getPosition(),
            $this->isVisible(),
            $this->canMoveTowards(),
            $this->getActionPointsToMove(),
            $submarine,
            $canAttack,
            $actionPointsToAttack,
            $canShareSonar,
            $actionPointsToShareSonar,
            $canGiveActionPoints,
        );
    }
}
