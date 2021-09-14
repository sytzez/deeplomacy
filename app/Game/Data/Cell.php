<?php

namespace App\Game\Data;

use App\Game\Contracts\SubmarineContract;

class Cell
{
    public function __construct(
        protected Position $position,
        protected bool $isVisible,
        protected bool $canMoveTowards,
        protected ?SubmarineContract $submarine = null,
        protected bool $canAttack = false,
        protected bool $canShareSonar = false,
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

    public function getSubmarine(): ?SubmarineContract
    {
        return $this->submarine;
    }

    public function canAttack(): bool
    {
        return $this->canAttack;
    }

    public function canShareSonar(): bool
    {
        return $this->canShareSonar;
    }

    public function canGiveActionPoints(): bool
    {
        return $this->canGiveActionPoints;
    }

    public function withSubmarine(
        ?SubmarineContract $submarine,
        bool $canAttack = false,
        bool $canShareSonar = false,
        bool $canGiveActionPoints = false,
    ): Cell {
        return new static(
            $this->getPosition(),
            $this->isVisible(),
            $this->canMoveTowards(),
            $submarine,
            $canAttack,
            $canShareSonar,
            $canGiveActionPoints,
        );
    }
}
