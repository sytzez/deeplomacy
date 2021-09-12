<?php

namespace App\Models;

use App\Game\Contracts\ConfigurationContract;
use App\Game\Data\Bounds;
use App\Game\Data\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Configuration extends Model implements ConfigurationContract
{
    protected $fillable = [
        'width',
        'height',
        'distance_squared_movable_per_action_point',
        'field_of_view_squared',
        'distance_squared_allowed_to_give_action_points',
        'distance_squared_allowed_to_share_sonar',
        'action_points_required_to_share_sonar',
        'action_points_required_to_attack',
        'amount_of_action_points_distributed',
    ];

    public function game(): HasOne
    {
        return $this->hasOne(Game::class);
    }

    public function getBounds(): Bounds
    {
        return new Bounds(
            new Position(0, 0),
            new Position(
                $this->getAttribute('width'),
                $this->getAttribute('height'),
            ),
        );
    }

    public function getDistanceSquaredMovablePerActionPoint(): int
    {
        return $this->getAttribute('distance_squared_movable_per_action_point');
    }

    public function getFieldOfViewSquared(): int
    {
        return $this->getAttribute('field_of_view_squared');
    }

    public function getDistanceSquaredAllowedToGiveActionPoints(): int
    {
        return $this->getAttribute('distance_squared_allowed_to_give_action_points');
    }

    public function getDistanceSquaredAllowedToShareSonar(): int
    {
        return $this->getAttribute('distance_squared_allowed_to_share_sonar');
    }

    public function getActionPointsRequiredToShareSonar(): int
    {
        return $this->getAttribute('action_points_required_to_share_sonar');
    }

    public function getActionPointsRequiredToAttack(): int
    {
        return $this->getAttribute('action_points_required_to_attack');
    }

    public function getAmountOfActionPointsDistributed(): int
    {
        return $this->getAttribute('amount_of_action_points_distributed');
    }
}
