<?php

namespace App\Factories;

use App\Http\Requests\StoreGameRequest;
use App\Models\Configuration;
use App\Models\Game;

class GameFactory
{
    public function make(StoreGameRequest $request): Game
    {
        $game = new Game();

        $configuration = Configuration::query()
            ->find($request->get('configuration'));

        $game->configuration()->associate($configuration);

        return $game;
    }
}
