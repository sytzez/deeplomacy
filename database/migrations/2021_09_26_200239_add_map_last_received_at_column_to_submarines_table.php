<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMapLastReceivedAtColumnToSubmarinesTable extends Migration
{
    public function up()
    {
        Schema::table('submarines', function (Blueprint $table) {
            $table->timestamp('map_last_received_at')
                ->nullable();
        });
    }

    public function down()
    {
        Schema::table('submarines', function (Blueprint $table) {
            $table->dropColumn('map_last_received_at');
        });
    }
}
