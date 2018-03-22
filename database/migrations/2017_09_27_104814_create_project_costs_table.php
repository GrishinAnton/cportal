<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_costs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pers_id');
            $table->unsignedInteger('project_id');
            $table->double('project_cost');
            $table->string('rus_date');
            $table->string('year_month');
            $table->timestamps();

            $table->foreign('pers_id')->references('pers_id')->on('personal');
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
        Schema::dropIfExists('project_costs');
    }
}
