<?php

namespace App\Game\Data;

use App\Game\Contracts\SubmarineContract;

class GiveActionPointsData
{
    public function __construct(
        protected SubmarineContract $donor,
        protected SubmarineContract $recipient,
        protected int $amount,
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

    public function getAmount(): int
    {
        return $this->amount;
    }
}
