<?php

namespace App\Game\Data;

use DomainException;

class DistanceSquared
{
    protected ?float $root = null;

    public function __construct(
        protected int $squared,
    ) {
        if ($this->squared < 0) {
            throw new DomainException();
        }
    }

    public function getSquared(): int
    {
        return $this->squared;
    }

    public function getRoot(): float
    {
        if ($this->root) {
            return $this->root;
        }

        return $this->root = sqrt($this->getSquared());
    }

    public function fitsInside(DistanceSquared $other): bool
    {
        return $this->getSquared() <= $other->getSquared();
    }

    public function equals(DistanceSquared $other): bool
    {
        return $this->getSquared() === $other->getSquared();
    }
}
