<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subtask_id');
            $table->unsignedInteger('task_id');
            $table->unsignedInteger('assignee_id');
            $table->string('body');
            $table->integer('created_on');
            $table->string('permalink');
            $table->integer('completed_on')->nullable();
            $table->boolean('is_completed');
            $table->string('type');
            $table->timestamps();

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
        Schema::dropIfExists('subtasks');
    }
}
