<?php

namespace App\Factories;

use App\Adapters\SubmarineAdapter;
use App\Game\Actions\PlaceSubmarineAction;
use App\Game\Data\PlaceSubmarineData;
use App\Game\Strategies\RandomPlacementStrategy;
use App\Models\Game;
use App\Models\Submarine;
use App\Models\User;

class SubmarineFactory
{
    public function __construct(
        protected PlaceSubmarineAction $placeSubmarineAction,
    ) {
    }

    public function make(User $user, Game $game): Submarine
    {
        $submarine = new Submarine();

        $submarine->user()->associate($user);
        $submarine->game()->associate($game);

        $this->placeSubmarineAction->do(
            new PlaceSubmarineData(
                new SubmarineAdapter($submarine),
                new RandomPlacementStrategy(),
            )
        );

        return $submarine;
    }
}
