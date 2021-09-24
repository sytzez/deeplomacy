<?php

namespace App\Adapters;

use App\Game\Contracts\GameContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Data\ActionPoints;
use App\Game\Data\Position;
use App\Models\Submarine;
use DomainException;

class SubmarineAdapter implements SubmarineContract
{
    final public function __construct(
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

    public function getActionPoints(): ActionPoints
    {
        return new ActionPoints(
            $this->model->action_points
        );
    }

    public function setActionPoints(ActionPoints $actionPoints): static
    {
        $this->model->action_points = $actionPoints->getAmount();

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

    public function hasSonarSharedFrom(SubmarineContract $submarine): bool
    {
        if (! $submarine instanceof self) {
            throw new DomainException();
        }

        return $this->model->sonarSharedFrom()
            ->where('id', $submarine->getModel()->getKey())
            ->exists();
    }

    /**
     * @return iterable<SubmarineContract>
     */
    public function getSonarSharedTo(): iterable
    {
        return $this->model->sonarSharedTo
            ->map(fn (Submarine $submarine) => new static($submarine));
    }

    public function hasSonarSharedTo(SubmarineContract $submarine): bool
    {
        if (! $submarine instanceof self) {
            throw new DomainException();
        }

        return $this->model->sonarSharedTo()
            ->where('id', $submarine->getModel()->getKey())
            ->exists();
    }

    public function shareSonarTo(SubmarineContract $recipient): static
    {
        if (! $recipient instanceof self) {
            throw new DomainException();
        }

        $this->model->sonarSharedTo()->attach($recipient->getModel());

        return $this;
    }

    public function kill(): static
    {
        $this->model->is_alive = false;

        return $this;
    }

    public function getModel(): Submarine
    {
        return $this->model;
    }

    public function is(SubmarineContract $submarine): bool
    {
        return $submarine instanceof self
            && $submarine->getModel()->is($this->getModel());
    }
}
