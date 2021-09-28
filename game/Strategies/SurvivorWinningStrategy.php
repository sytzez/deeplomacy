<?php

namespace Game\Strategies;

use Game\Contracts\GameContract;
use Game\Contracts\SubmarineRepositoryContract;
use Game\Contracts\WinningStrategyContract;
use Game\Data\VictoryData;

class SurvivorWinningStrategy implements WinningStrategyContract
{
    protected int $survivorCount = 1;

    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
    ) {
    }

    public function setSurvivorCount(int $count): static
    {
        if ($count < 1) {
            throw new \DomainException();
        }

        $this->survivorCount = $count;

        return $this;
    }

    function check(GameContract $game): VictoryData
    {
        $submarines = $this->submarineRepository->getAll($game);

        if (iterator_count($submarines) > $this->survivorCount) {
            return new VictoryData(false);
        }

        return new VictoryData(true, $submarines);
    }
}
