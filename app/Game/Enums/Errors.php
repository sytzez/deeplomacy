<?php

namespace App\Game\Enums;

class Errors
{
    public const INSUFFICIENT_ACTION_POINTS = 'insufficient_action_points';
    public const SUBMARINE_AT_DESTINATION = 'submarine_at_destination';
    public const CANNOT_TARGET_SELF = 'cannot_target_self';
    public const DESTINATION_OUT_OF_BOUNDS = 'destination_out_of_bounds';
    public const AMOUNT_TOO_LOW = 'amount_too_low';
    public const TARGET_TOO_FAR_AWAY = 'target_too_far_away';
    public const TARGET_NOT_VISIBLE = 'target_not_visible';
    public const TARGET_NOT_IN_GAME = 'target_not_in_game'
}
