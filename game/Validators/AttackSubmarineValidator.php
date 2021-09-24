<?php

namespace Game\Validators;

use Game\Data\AttackSubmarineData;
use Game\Data\GameActionException;
use Game\Enums\Errors;
use Game\Services\AttackSubmarineService;
use Game\Services\VisibilityService;

class AttackSubmarineValidator
{
    protected AttackSubmarineData $data;

    public function __construct(
        protected AttackSubmarineService $attackSubmarineService,
        protected VisibilityService $visibilityService,
    ) {
    }

    /**
     * @param AttackSubmarineData $data
     * @throws GameActionException
     */
    public function validate(AttackSubmarineData $data): void
    {
        $this->data = $data;

        $this->checkValidTarget();

        $this->checkSufficientActionPoints();

        $this->getTargetVisibleByAttacker();
    }

    /**
     * @throws GameActionException
     */
    protected function checkValidTarget(): void
    {
        $attacker = $this->data->getAttacker();
        $target = $this->data->getTarget();

        if ($attacker->is($target)) {
            throw new GameActionException(Errors::CANNOT_TARGET_SELF);
        }

        if (! $attacker->getGame()->is($target->getGame())) {
            throw new GameActionException(Errors::TARGET_NOT_IN_GAME);
        }
    }

    /**
     * @throws GameActionException
     */
    protected function checkSufficientActionPoints(): void
    {
        $actionPointsRequired = $this->attackSubmarineService->getActionPointsRequired($this->data);

        if (
            ! $this->data->getAttacker()
                ->getActionPoints()
                ->canAfford($actionPointsRequired)
        ) {
            throw new GameActionException(Errors::INSUFFICIENT_ACTION_POINTS);
        }
    }

    /**
     * @throws GameActionException
     */
    protected function getTargetVisibleByAttacker(): void
    {
        if (
            ! $this->visibilityService->canSeeSubmarine(
                $this->data->getAttacker(),
                $this->data->getTarget()
            )
        ) {
            throw new GameActionException(Errors::TARGET_NOT_VISIBLE);
        }
    }
}
