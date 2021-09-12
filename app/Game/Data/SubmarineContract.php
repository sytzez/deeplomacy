<?php

namespace App\Game\Data;

interface SubmarineContract
{
    public function getPosition(): Position;
    public function setPosition(Position $position): static;
}
