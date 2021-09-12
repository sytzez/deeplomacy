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

    public function getOffsetTo(Position $position): Offset
    {
        return new Offset(
            $position->getX() - $this->getX(),
            $position->getY() - $this->getY(),
        );
    }

    public function addOffset(Offset $offset): static
    {
        return new static(
            $this->getX() + $offset->getDx(),
            $this->getY() + $offset->getDy(),
        );
    }

    public function equals(Position $position): bool
    {
        return $this->getX() === $position->getX()
            && $this->getY() === $position->getY();
    }
}
