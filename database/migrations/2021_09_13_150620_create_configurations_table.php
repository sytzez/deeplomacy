<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->integer('width');
            $table->integer('height');
            $table->integer('distance_squared_movable_per_action_point');
            $table->integer('field_of_view_squared');
            $table->integer('distance_squared_allowed_to_give_action_points');
            $table->integer('distance_squared_allowed_to_share_sonar');
            $table->integer('action_points_required_to_share_sonar');
            $table->integer('action_points_required_to_attack');
            $table->integer('amount_of_action_points_distributed');
            $table->integer('max_num_of_players');
            $table->integer('minutes_between_action_point_distribution');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
}
