<?php

namespace App\Game\Data;

use App\Game\Contracts\SubmarineContract;

class ShareSonarData
{
    public function __construct(
        protected SubmarineContract $donor,
        protected SubmarineContract $recipient,
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
}
