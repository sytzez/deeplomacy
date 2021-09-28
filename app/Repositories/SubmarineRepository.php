<?php

namespace App\Repositories;

use App\Adapters\GameAdapter;
use App\Adapters\SubmarineAdapter;
use Game\Contracts\GameContract;
use Game\Contracts\SubmarineContract;
use Game\Contracts\SubmarineRepositoryContract;
use Game\Data\Position;
use App\Models\Submarine;
use DomainException;
use Traversable;

class SubmarineRepository implements SubmarineRepositoryContract
{
    public function create(GameContract $game, SubmarineContract $submarine): static
    {
        if (
            ! (
                $game instanceof GameAdapter
                && $submarine instanceof SubmarineAdapter
            )
        ) {
            throw new DomainException();
        }

        $game->getModel()->submarines()->save(
            $submarine->getModel()
        );

        return $this;
    }

    public function update(SubmarineContract $submarine): static
    {
        if (! $submarine instanceof SubmarineAdapter) {
            throw new DomainException();
        }

        $submarine->getModel()->save();

        return $this;
    }

    /**
     * @param GameContract $game
     * @return Traversable<SubmarineContract>
     */
    public function getAll(GameContract $game): Traversable
    {
        if (! $game instanceof GameAdapter) {
            throw new DomainException();
        }

        return $game->getModel()->aliveSubmarines->map(
            fn (Submarine $submarine) => new SubmarineAdapter($submarine)
        );
    }

    public function getAtPosition(GameContract $game, Position $position): ?SubmarineContract
    {
        if (! $game instanceof GameAdapter) {
            throw new DomainException();
        }

        /** @var ?Submarine $submarine */
        $submarine = $game->getModel()
            ->aliveSubmarines()
            ->where('x', $position->getX())
            ->where('y', $position->getY())
            ->first();

        if (! $submarine) {
            return null;
        }

        return new SubmarineAdapter($submarine);
    }
}
