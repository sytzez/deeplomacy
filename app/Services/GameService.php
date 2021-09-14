<?php

namespace App\Services;

use App\Factories\SubmarineFactory;
use App\Models\Game;
use App\Models\Submarine;
use App\Models\User;
use Exception;

class GameService
{
    public function __construct(
        protected SubmarineFactory $submarineFactory,
    ) {
    }

    /**
     * @param User $user
     * @param Game $game
     * @throws Exception
     */
    public function join(User $user, Game $game): void
    {
        if ($game->isJoinedBy($user)) {
            throw new Exception('You have already joined this game');
        }

        if ($game->isFull()) {
            throw new Exception('This game is full');
        }

        $this->deleteDeadSubmarines($user, $game);

        $submarine = $this->submarineFactory->make($user, $game);

        $submarine->save();
    }

    public function leave(User $user, Game $game): void
    {
        $user->submarines()
            ->where('game_id', $game->getKey())
            ->delete();
    }


    public function getUserSubmarine(User $user, Game $game): Submarine
    {
        /** @var Submarine $submarine */
        $submarine = $user->submarines()
            ->where('game_id', $game->getKey())
            ->where('is_alive', true)
            ->first();

        return $submarine;
    }

    protected function deleteDeadSubmarines(User $user, Game $game): void
    {
        $user->submarines()
            ->where('game_id', $game->getKey())
            ->where('is_alive', false)
            ->delete();
    }
}
