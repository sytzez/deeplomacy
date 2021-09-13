<?php

namespace App\Adapters;

use App\Game\Contracts\GameContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Data\Position;
use App\Models\Submarine;

class SubmarineAdapter implements SubmarineContract
{
    public function __construct(
        protected Submarine $model,
    ) {
    }

    public function getGame(): GameContract
    {
        return new GameAdapter($this->model->game);
    }

    public function getPosition(): Position
    {
        return new Position(
            $this->model->x,
            $this->model->y,
        );
    }

    public function setPosition(Position $position): static
    {
        $this->model->x = $position->getX();
        $this->model->y = $position->getY();

        return $this;
    }

    public function getActionPoints(): int
    {
        return $this->model->action_points;
    }

    public function setActionPoints(int $actionPoints): static
    {
        $this->model->action_points = $actionPoints;

        return $this;
    }

    public function getSonarSharedBy(): iterable
    {
        // TODO: Implement getSonarSharedBy() method.
    }

    public function getSonarSharedTo(): iterable
    {
        // TODO: Implement getSonarSharedTo() method.
    }

    public function shareSonarTo(SubmarineContract $recipient): static
    {
        // TODO: Implement shareSonarTo() method.
    }

    public function kill(): static
    {
        $this->model->is_alive = false;

        return $this;
    }
}
