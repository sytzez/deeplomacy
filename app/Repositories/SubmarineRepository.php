<?php

namespace App\Repositories;

use App\Adapters\SubmarineAdapter;
use App\Game\Contracts\GameContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\Position;
use App\Models\Game;
use App\Models\Submarine;
use DomainException;

class SubmarineRepository implements SubmarineRepositoryContract
{
    public function create(GameContract $game, SubmarineContract $submarine): static
    {
        if (! (
            $game instanceof Game
            && $submarine instanceof Submarine
        )) {
            throw new DomainException();
        }

        $game->submarines()->save($submarine);

        return $this;
    }

    public function update(SubmarineContract $submarine): static
    {
        if (! $submarine instanceof Submarine) {
            throw new DomainException();
        }

        $submarine->save();

        return $this;
    }

    /**
     * @param GameContract $game
     * @return iterable<Submarine>
     */
    public function getAll(GameContract $game): iterable
    {
        if (! $game instanceof Game) {
            throw new DomainException();
        }

        return $game->submarines->map(
            fn (Submarine $submarine) => new SubmarineAdapter($submarine)
        );
    }

    public function getAtPosition(GameContract $game, Position $position): ?SubmarineContract
    {
        if (! $game instanceof Game) {
            throw new DomainException();
        }

        return $game->submarines()
            ->where('x', $position->getX())
            ->where('y', $position->getY())
            ->get()
            ->map(
                fn (Submarine $submarine) => new SubmarineAdapter($submarine)
            );
    }
}
