<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->float('coefficient')->default(1)->change();
            $table->smallInteger('close_hours')->nullable()->change();
            $table->smallInteger('salary_hours')->nullable()->change();
            $table->smallInteger('penalty_hours')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->double('coefficient');
            $table->smallInteger('close_hours');
            $table->smallInteger('salary_hours');
            $table->smallInteger('penalty_hours');
        });
    }
}
