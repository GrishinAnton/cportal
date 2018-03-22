<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('timerecord_id');
            $table->unsignedInteger('pers_id');
            $table->unsignedInteger('task_id');
            $table->double('worktime');
            $table->date('date');
            $table->index('date');
            $table->timestamps();

            $table->foreign('pers_id')->references('pers_id')->on('personal');
            $table->foreign('task_id')->references('task_id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_times');
    }
}
