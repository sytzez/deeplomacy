<?php

namespace Game\Services;

use Game\Contracts\RngServiceContract;
use Game\Contracts\SubmarineContract;
use Game\Contracts\SubmarineRepositoryContract;
use Game\Data\ActionPoints;
use Game\Data\AttackSubmarineData;

class AttackSubmarineService
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
        protected RngServiceContract $rngService,
    ) {
    }

    public function getActionPointsRequired(AttackSubmarineData $data): ActionPoints
    {
        return $data
            ->getAttacker()
            ->getGame()
            ->getConfiguration()
            ->getActionPointsRequiredToAttack();
    }

    public function getHitChance(AttackSubmarineData $data): float
    {
        return 0.5;
    }

    public function attackSubmarine(AttackSubmarineData $data): bool
    {
        $attacker = $data->getAttacker();

        $cost = $this->getActionPointsRequired($data);

        $attacker->setActionPoints(
            $attacker->getActionPoints()->decreasedBy($cost)
        );

        $this->submarineRepository->update($attacker);

        if ($this->rngService->getBool($this->getHitChance($data))) {
            $this->hitSubmarine($data->getTarget());

            return true;
        }

        return false;
    }

    protected function hitSubmarine(SubmarineContract $submarine): void
    {
        $submarine->kill();

        $this->submarineRepository->update($submarine);
    }
}
