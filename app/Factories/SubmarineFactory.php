<?php

namespace App\Factories;

use App\Adapters\SubmarineAdapter;
use App\Game\Actions\JoinSubmarineAction;
use App\Game\Data\JoinSubmarineData;
use App\Game\Strategies\RandomPlacementStrategy;
use App\Models\Game;
use App\Models\Submarine;
use App\Models\User;
use Exception;

class SubmarineFactory
{
    public function __construct(
        protected JoinSubmarineAction $placeSubmarineAction,
    ) {
    }

    /**
     * @param User $user
     * @param Game $game
     * @return Submarine
     * @throws Exception
     */
    public function make(User $user, Game $game): Submarine
    {
        if ($game->isJoinedBy($user)) {
            throw new Exception('User has already joined');
        }

        $submarine = new Submarine();

        $submarine->user()->associate($user);
        $submarine->game()->associate($game);

        $this->placeSubmarineAction->do(
            new JoinSubmarineData(
                new SubmarineAdapter($submarine),
                new RandomPlacementStrategy(),
            )
        );

        return $submarine;
    }
}
