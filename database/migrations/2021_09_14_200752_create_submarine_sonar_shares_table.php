<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmarineSonarSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submarine_sonar_shares', function (Blueprint $table) {
            $table->foreignId('donor_id')
                ->constrained('submarines');
            $table->foreignId('recipient_id')
                ->constrained('submarines');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submarine_sonar_shares');
    }
}
