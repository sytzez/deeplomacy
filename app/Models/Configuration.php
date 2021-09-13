<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Configuration
 * @package App\Models
 * @property string name
 * @property string description
 * @property int width
 * @property int height
 * @property int distance_squared_movable_per_action_point
 * @property int field_of_view_squared
 * @property int distance_squared_allowed_to_give_action_points
 * @property int distance_squared_allowed_to_share_sonar
 * @property int action_points_required_to_share_sonar
 * @property int action_points_required_to_attack
 * @property int amount_of_action_points_distributed
 * @property Game game
 */
class Configuration extends Model
{
    protected $fillable = [
        'name',
        'description',
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
}
