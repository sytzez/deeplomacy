<?php

namespace Game\Data;

use Game\Contracts\SubmarineContract;

class AttackSubmarineData
{
    public function __construct(
        protected SubmarineContract $attacker,
        protected SubmarineContract $target,
    ) {
    }

    public function getAttacker(): SubmarineContract
    {
        return $this->attacker;
    }

    public function getTarget(): SubmarineContract
    {
        return $this->target;
    }
}
