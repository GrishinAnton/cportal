<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('task_id')->unique();
            $table->unsignedInteger('project_id');
            $table->string('type');
            $table->string('permalink');
            $table->string('name');
            $table->integer('completed_on')->nullable();
            $table->boolean('is_completed');
            $table->integer('created_on');
            $table->unsignedInteger('assignee_id');
            $table->double('estimated_time');
            $table->double('tracked_time')->default(0);
            $table->timestamps();
            
            $table->foreign('project_id')->references('project_id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
