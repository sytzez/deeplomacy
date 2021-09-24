<?php

namespace Game\Enums;

class Errors
{
    public const INSUFFICIENT_ACTION_POINTS = 'You have insufficient action points';
    public const SUBMARINE_AT_DESTINATION = 'There is already a submarine at the destination';
    public const CANNOT_TARGET_SELF = 'You can not target yourself';
    public const DESTINATION_OUT_OF_BOUNDS = 'The destination if out of bounds';
    public const AMOUNT_TOO_LOW = 'The amount is too low';
    public const TARGET_TOO_FAR_AWAY = 'The target is too far away';
    public const TARGET_NOT_VISIBLE = 'The target is not visible to you';
    public const TARGET_NOT_IN_GAME = 'The target is not part of the current game';
    public const SONAR_ALREADY_SHARED = 'You have already shared your sonar with this submarine';
}
