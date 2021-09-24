<?php

namespace App\Adapters;

use Game\Contracts\ConfigurationContract;
use Game\Data\ActionPoints;
use Game\Data\Bounds;
use Game\Data\DistanceSquared;
use Game\Data\Position;
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

    public function getDistanceSquaredMovablePerActionPoint(): DistanceSquared
    {
        return new DistanceSquared(
            $this->model->distance_squared_movable_per_action_point
        );
    }

    public function getFieldOfViewSquared(): DistanceSquared
    {
        return new DistanceSquared(
            $this->model->field_of_view_squared
        );
    }

    public function getDistanceSquaredAllowedToGiveActionPoints(): DistanceSquared
    {
        return new DistanceSquared(
            $this->model->distance_squared_allowed_to_give_action_points
        );
    }

    public function getDistanceSquaredAllowedToShareSonar(): DistanceSquared
    {
        return new DistanceSquared(
            $this->model->distance_squared_allowed_to_share_sonar
        );
    }

    public function getActionPointsRequiredToShareSonar(): ActionPoints
    {
        return new ActionPoints(
            $this->model->action_points_required_to_share_sonar
        );
    }

    public function getActionPointsRequiredToAttack(): ActionPoints
    {
        return new ActionPoints(
            $this->model->action_points_required_to_attack
        );
    }

    public function getAmountOfActionPointsDistributed(): ActionPoints
    {
        return new ActionPoints(
            $this->model->amount_of_action_points_distributed
        );
    }
}
