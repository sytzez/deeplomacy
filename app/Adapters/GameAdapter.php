<?php

namespace App\Adapters;

use Game\Contracts\ConfigurationContract;
use Game\Contracts\GameContract;
use App\Models\Game;

class GameAdapter implements GameContract
{
    public function __construct(
        protected Game $model,
    ) {
    }

    public function getConfiguration(): ConfigurationContract
    {
        return new ConfigurationAdapter($this->model->configuration);
    }

    public function getModel(): Game
    {
        return $this->model;
    }

    public function is(GameContract $game): bool
    {
        return $game instanceof self
            && $game->getModel()->is($this->getModel());
    }
}
