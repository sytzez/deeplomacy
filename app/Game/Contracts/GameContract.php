<?php

namespace App\Game\Contracts;

interface GameContract
{
    public function getConfiguration(): ConfigurationContract;
}
