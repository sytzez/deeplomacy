<?php

namespace App\Game\Validators;

use App\Game\Data\AttackSubmarineData;
use App\Game\Enums\Errors;
use App\Game\Services\AttackSubmarineService;
use App\Game\Services\VisibilityService;
use Exception;

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
     * @throws Exception
     */
    public function validate(AttackSubmarineData $data): void
    {
        $this->data = $data;

        $this->checkValidTarget();

        $this->checkSufficientActionPoints();

        $this->getTargetVisibleByAttacker();
    }

    /**
     * @throws Exception
     */
    protected function checkValidTarget(): void
    {
        $attacker = $this->data->getAttacker();
        $target = $this->data->getTarget();

        if ($attacker->is($target)) {
            throw new Exception(Errors::CANNOT_TARGET_SELF);
        }

        if (! $attacker->getGame()->is($target->getGame())) {
            throw new Exception(Errors::TARGET_NOT_IN_GAME);
        }
    }

    /**
     * @throws Exception
     */
    protected function checkSufficientActionPoints(): void
    {
        $actionPointsRequired = $this->attackSubmarineService->getActionPointsRequired($this->data);

        if ($this->data->getAttacker()->getActionPoints() < $actionPointsRequired) {
            throw new Exception(Errors::INSUFFICIENT_ACTION_POINTS);
        }
    }

    /**
     * @throws Exception
     */
    protected function getTargetVisibleByAttacker(): void
    {
        if (! $this->visibilityService->canSeeSubmarine($this->data->getAttacker(), $this->data->getTarget())) {
            throw new Exception(Errors::TARGET_NOT_VISIBLE);
        }
    }
}
