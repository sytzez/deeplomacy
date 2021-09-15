<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRowsIntoConfigurationsTable extends Migration
{
    public function up(): void
    {
        DB::table('configurations')
            ->insert([
                [
                    'name'                                           => 'Small',
                    'description'                                    => '32x32',
                    'width'                                          => 32,
                    'height'                                         => 32,
                    'distance_squared_movable_per_action_point'      => 4 ** 2,
                    'field_of_view_squared'                          => 16 ** 2,
                    'distance_squared_allowed_to_give_action_points' => 32 ** 2,
                    'distance_squared_allowed_to_share_sonar'        => 32 ** 2,
                    'action_points_required_to_share_sonar'          => 2,
                    'action_points_required_to_attack'               => 2,
                    'amount_of_action_points_distributed'            => 2,
                    'max_num_of_players'                             => 8,
                    'minutes_between_action_point_distribution'      => 1,
                ],
                [
                    'name'                                           => 'Large',
                    'description'                                    => '64x64',
                    'width'                                          => 64,
                    'height'                                         => 64,
                    'distance_squared_movable_per_action_point'      => 8 ** 2,
                    'field_of_view_squared'                          => 32 ** 2,
                    'distance_squared_allowed_to_give_action_points' => 64 ** 2,
                    'distance_squared_allowed_to_share_sonar'        => 64 ** 2,
                    'action_points_required_to_share_sonar'          => 2,
                    'action_points_required_to_attack'               => 2,
                    'amount_of_action_points_distributed'            => 2,
                    'max_num_of_players'                             => 32,
                    'minutes_between_action_point_distribution'      => 1,
                ],
                [
                    'name'                                           => 'Huuuge',
                    'description'                                    => '128x128',
                    'width'                                          => 128,
                    'height'                                         => 128,
                    'distance_squared_movable_per_action_point'      => 16 ** 2,
                    'field_of_view_squared'                          => 32 ** 2,
                    'distance_squared_allowed_to_give_action_points' => 64 ** 2,
                    'distance_squared_allowed_to_share_sonar'        => 64 ** 2,
                    'action_points_required_to_share_sonar'          => 2,
                    'action_points_required_to_attack'               => 2,
                    'amount_of_action_points_distributed'            => 2,
                    'max_num_of_players'                             => 128,
                    'minutes_between_action_point_distribution'      => 1,
                ],
            ]);
    }

    public function down(): void
    {
        DB::table('configurations')
            ->truncate();
    }
}
