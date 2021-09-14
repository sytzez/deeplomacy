<?php

namespace App\Factories;

use App\Models\Game;
use App\Models\Submarine;
use App\Models\User;

class SubmarineFactory
{
    public function make(User $user, Game $game): Submarine
    {
        $submarine = new Submarine();

        $submarine->user()->associate($user);
        $submarine->game()->associate($game);

        return $submarine;
    }
}
