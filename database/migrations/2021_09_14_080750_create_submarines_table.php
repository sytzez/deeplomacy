<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmarinesTable extends Migration
{
    public function up(): void
    {
        Schema::create('submarines', function (Blueprint $table) {
            $table->id();
            $table->integer('x');
            $table->integer('y');
            $table->unsignedInteger('action_points');
            $table->boolean('is_alive');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->foreignId('game_id')
                ->constrained('games');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submarines');
    }
}
