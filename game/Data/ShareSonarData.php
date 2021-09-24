<?php

namespace Game\Data;

use Game\Contracts\SubmarineContract;

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
