<?php

namespace App\Factories;

use App\Adapters\SubmarineAdapter;
use App\Game\Actions\JoinAction;
use App\Game\Data\JoinData;
use App\Game\Strategies\RandomPlacementStrategy;
use App\Models\Game;
use App\Models\Submarine;
use App\Models\User;
use Exception;

class SubmarineFactory
{
    public function __construct(
        protected JoinAction $placeSubmarineAction,
        protected RandomPlacementStrategy $randomPlacementStrategy,
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
            new JoinData(
                new SubmarineAdapter($submarine),
                $this->randomPlacementStrategy,
            )
        );

        return $submarine;
    }
}
