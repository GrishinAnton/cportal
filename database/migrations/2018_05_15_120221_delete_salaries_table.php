<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('salaries');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pers_id');
            $table->double('coefficient')->default(1.1);
            $table->boolean('salary_fix')->default(0);
            $table->smallInteger('hour')->default(300);
            $table->mediumInteger('salary')->default(30000)->nullable();
            $table->mediumInteger('edit_salary')->nullable();
            $table->date('date');
            $table->timestamps();

            $table->foreign('pers_id')->references('pers_id')->on('personal');
        });
    }
}
