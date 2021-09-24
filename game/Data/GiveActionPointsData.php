<?php

namespace Game\Data;

use Game\Contracts\SubmarineContract;

class GiveActionPointsData
{
    public function __construct(
        protected SubmarineContract $donor,
        protected SubmarineContract $recipient,
        protected ActionPoints $actionPoints,
    ) {
    }

    public function getDonor(): SubmarineContract
    {
        return $this->donor;
    }

    public function getRecipient(): SubmarineContract
    {
        return $this->recipient;
    }

    public function getActionPoints(): ActionPoints
    {
        return $this->actionPoints;
    }
}
