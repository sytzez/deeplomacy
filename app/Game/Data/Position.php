<?php

namespace App\Game\Data;

class Position
{
    public function __construct(
        protected int $x,
        protected int $y,
    ) {
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getDistanceTo(Position $position): int
    {
        return ($this->getX() - $position->getX()) ** 2
            + ($this->getY() - $position->getY()) ** 2;
    }

    public function translated(int $dx, int $dy): static
    {
        return new static(
            $this->getX() + $dx,
            $this->getY() + $dy,
        );
    }
}
