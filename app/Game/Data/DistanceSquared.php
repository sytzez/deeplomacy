<?php

namespace App\Game\Data;

use DomainException;

class DistanceSquared
{
    public function __construct(
        protected int $value,
    ) {
        if ($this->value < 0) {
            throw new DomainException();
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function fitsInside(DistanceSquared $other): bool
    {
        return $this->getValue() <= $other->getValue();
    }

    public function equals(DistanceSquared $other): bool
    {
        return $this->getValue() === $other->getValue();
    }
}
