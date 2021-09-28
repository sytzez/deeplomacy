<?php

namespace Game\Strategies;

use Game\Contracts\GameContract;
use Game\Contracts\SubmarineContract;
use Game\Contracts\SubmarineRepositoryContract;
use Game\Contracts\WinningStrategyContract;
use Game\Data\ActionPoints;
use Game\Data\VictoryData;

class ActionPointsWinningStrategy implements WinningStrategyContract
{
    public const DEFAULT_GOAL_VALUE = 100;

    protected ActionPoints $goal;

    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
    ) {
        $this->goal = new ActionPoints(static::DEFAULT_GOAL_VALUE);
    }

    public function setGoal(ActionPoints $goal): static
    {
        $this->goal = $goal;

        return $this;
    }

    function check(GameContract $game): VictoryData
    {
        $submarines = $this->submarineRepository->getAll($game);

        $highestSubmarines = $this->getSubmarinesWithHighestActionPoints($submarines);

        if (
            empty($highestSubmarines)
            || $highestSubmarines[0]->getActionPoints()->getAmount() < $this->goal->getAmount()
        ) {
            return new VictoryData(false);
        }

        return new VictoryData(true, $highestSubmarines);
    }

    /**
     * @param iterable<SubmarineContract> $submarines
     * @return iterable<SubmarineContract>
     */
    function getSubmarinesWithHighestActionPoints(iterable $submarines): iterable
    {
        $highestActionPoints = new ActionPoints(0);
        $highestSubmarines = [];

        foreach ($submarines as $submarine) {

            if ($submarine->getActionPoints()->getAmount() > $highestActionPoints->getAmount()) {
                $highestSubmarines = [$submarine];
                $highestActionPoints = $submarine->getActionPoints();
                continue;
            }

            if ($submarine->getActionPoints()->equals($highestActionPoints)) {
                $highestSubmarines[] = $submarine;
            }
        }

        return $highestSubmarines;
    }
}
