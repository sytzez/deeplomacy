<?php

namespace Game\Data;

class Grid
{
    /**
     * @param array<array<Cell>> $rows
     */
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
