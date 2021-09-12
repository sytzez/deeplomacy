<?php

namespace App\Game\Services;

use App\Game\Contracts\RngServiceContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\AttackSubmarineData;
use App\Game\Data\ShareSonarData;

class AttackSubmarineService
{
    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
        protected RngServiceContract $rngService,
    ) {
    }

    public function getActionPointsRequired(AttackSubmarineData $data): int
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

    public function attackSubmarine(AttackSubmarineData $data): void
    {
        $attacker = $data->getAttacker();

        $attacker->setActionPoints($attacker->getActionPoints() - $this->getActionPointsRequired($data));

        $this->submarineRepository->update($attacker);

        if ($this->rngService->getBool($this->getHitChance($data))) {
            $this->hitSubmarine($data->getTarget());
        }
    }

    protected function hitSubmarine(SubmarineContract $submarine): void
    {
        $submarine->kill();

        $this->submarineRepository->update($submarine);
    }
}
