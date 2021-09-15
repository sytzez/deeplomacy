<?php

namespace App\Game\Contracts;

interface GameContract
{
    public function getConfiguration(): ConfigurationContract;

    public function is(self $game): bool;
}
