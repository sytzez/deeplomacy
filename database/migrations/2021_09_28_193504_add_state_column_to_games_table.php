<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateColumnToGamesTable extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->enum('state', [
                'waiting',
                'started',
                'finished',
            ])->default('waiting');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }
}
