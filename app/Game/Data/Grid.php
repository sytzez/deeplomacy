<?php

namespace App\Game\Data;

class Grid
{
    public function __construct(
        protected array $rows,
    ) {
    }

    /**
     * @return array<array<Cell>>
     */
    public function getRows(): array
    {
        return $this->rows;
    }
}
