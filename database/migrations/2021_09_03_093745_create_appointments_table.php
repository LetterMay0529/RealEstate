<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('type_viewing');
            $table->date('date_viewing');
            $table->bigInteger('agent_id')->unsigned();
            $table->bigInteger('seeker_id')->unsigned();
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents');
            $table->foreign('seeker_id')->references('id')->on('seekers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
