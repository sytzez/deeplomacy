<?php

namespace App\Game\Data;

class Offset
{
    public function __construct(
        protected int $dx,
        protected int $dy,
    ) {
    }

    public function getDx(): int
    {
        return $this->dx;
    }

    public function getDy(): int
    {
        return $this->dy;
    }

    public function getDistanceSquared(): int
    {
        return $this->dx ** 2
            + $this->dy ** 2;
    }

    public function equals(Offset $offset): bool
    {
        return $this->getDx() === $offset->getDx()
            && $this->getDy() === $offset->getDy();
    }
}
