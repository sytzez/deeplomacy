<?php

namespace App\Adapters;

use App\Game\Contracts\ConfigurationContract;
use App\Game\Contracts\GameContract;
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
}
