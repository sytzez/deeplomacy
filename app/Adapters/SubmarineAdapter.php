<?php

namespace App\Adapters;

use App\Game\Contracts\GameContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Data\Position;
use App\Models\Submarine;
use DomainException;

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

    /**
     * @return iterable<SubmarineContract>
     */
    public function getSonarSharedFrom(): iterable
    {
        return $this->model->sonarSharedFrom
            ->map(fn (Submarine $submarine) => new static($submarine));
    }

    /**
     * @return iterable<SubmarineContract>
     */
    public function getSonarSharedTo(): iterable
    {
        return $this->model->sonarSharedTo
            ->map(fn (Submarine $submarine) => new static($submarine));
    }

    public function shareSonarTo(SubmarineContract $recipient): static
    {
        if (! $recipient instanceof Submarine) {
            throw new DomainException();
        }

        $this->model->sonarSharedTo()->attach($recipient);
    }

    public function kill(): static
    {
        $this->model->is_alive = false;

        return $this;
    }
}
