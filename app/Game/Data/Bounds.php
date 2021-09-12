<?php

namespace App\Game\Data;

use LogicException;

class Bounds
{
    public function __construct(
        protected Position $topLeft,
        protected Position $bottomRight,
    ) {
        if (! $topLeft->isTopLeftOf($bottomRight)) {
            throw new LogicException();
        }
    }

    public function getTopLeft(): Position
    {
        return $this->topLeft;
    }

    public function getBottomRight(): Position
    {
        return $this->bottomRight;
    }

    public function containsPosition(Position $position): bool
    {
        return $this->getTopLeft()->isTopLeftOf($position)
            && $position->isTopLeftOf($this->getBottomRight());
    }
}
