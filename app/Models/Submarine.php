<?php

namespace App\Models;

use App\Game\Contracts\GameContract;
use App\Game\Contracts\SubmarineContract;
use App\Game\Data\Position;
use Illuminate\Database\Eloquent\Model;

class Submarine extends Model implements SubmarineContract
{
    protected $fillable = [
        'x',
        'y',
        'action_points',
        'is_alive',
    ];

    protected $casts = [
        'is_alive' => 'bool',
    ];

    public function getGame(): GameContract
    {
        // TODO: Implement getGame() method.
    }

    public function getPosition(): Position
    {
        return new Position(
            $this->getAttribute('x'),
            $this->getAttribute('y'),
        );
    }

    public function setPosition(Position $position): static
    {
        $this->setAttribute('x', $position->getX());
        $this->setAttribute('y', $position->getY());
    }

    public function getActionPoints(): int
    {
        return $this->getAttribute('action_points');
    }

    public function setActionPoints(int $actionPoints): static
    {
        return $this->setAttribute('action_points', $actionPoints);
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
        $this->setAttribute('is_alive', false);
    }
}
