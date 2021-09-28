<?php

namespace Game\Contracts;

interface GameContract
{
    public function getConfiguration(): ConfigurationContract;

    public function getWinningStrategy(): WinningStrategyContract;

    /**
     * @param iterable<SubmarineContract> $submarines
     * @return static
     */
    public function grantVictory(iterable $submarines): static;

    public function is(self $game): bool;
}
