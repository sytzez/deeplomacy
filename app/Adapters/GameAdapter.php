<?php

namespace App\Adapters;

use App\Enums\GameStateEnum;
use Game\Contracts\ConfigurationContract;
use Game\Contracts\GameContract;
use App\Models\Game;
use Game\Contracts\SubmarineContract;
use Game\Contracts\SubmarineRepositoryContract;
use Game\Contracts\WinningStrategyContract;
use Game\Strategies\SurvivorWinningStrategy;

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

    public function getWinningStrategy(): WinningStrategyContract
    {
        return new SurvivorWinningStrategy(
            app()->make(SubmarineRepositoryContract::class),
        );
    }

    /**
     * @param iterable<SubmarineContract> $submarines
     * @return static
     */
    public function grantVictory(iterable $submarines): static
    {
        $game = $this->getModel();
        $game->state = GameStateEnum::FINISHED;
        $game->save();

        foreach ($submarines as $submarine) {

            if (! $submarine instanceof SubmarineAdapter) {
                throw new \DomainException();
            }

            $submarineModel = $submarine->getModel();

            $submarineModel->has_won = true;
            $submarineModel->save();
        }
    }
}
