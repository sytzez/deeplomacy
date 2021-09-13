<?php

namespace App\Adapters;

use App\Game\Contracts\ConfigurationContract;
use App\Game\Data\Bounds;
use App\Game\Data\Position;
use App\Models\Configuration;

class ConfigurationAdapter implements ConfigurationContract
{
    public function __construct(
        protected Configuration $model,
    ) {
    }

    public function getBounds(): Bounds
    {
        return new Bounds(
            new Position(0, 0),
            new Position(
                $this->model->width,
                $this->model->height,
            ),
        );
    }

    public function getDistanceSquaredMovablePerActionPoint(): int
    {
        return $this->model->distance_squared_movable_per_action_point;
    }

    public function getFieldOfViewSquared(): int
    {
        return $this->model->field_of_view_squared;
    }

    public function getDistanceSquaredAllowedToGiveActionPoints(): int
    {
        return $this->model->distance_squared_allowed_to_give_action_points;
    }

    public function getDistanceSquaredAllowedToShareSonar(): int
    {
        return $this->model->distance_squared_allowed_to_share_sonar;
    }

    public function getActionPointsRequiredToShareSonar(): int
    {
        return $this->model->action_points_required_to_share_sonar;
    }

    public function getActionPointsRequiredToAttack(): int
    {
        return $this->model->action_points_required_to_attack;
    }

    public function getAmountOfActionPointsDistributed(): int
    {
        return $this->model->amount_of_action_points_distributed;
    }
}
