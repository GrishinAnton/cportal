<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnsToProjectCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_costs', function (Blueprint $table) {
            $table->dropColumn('hours');
            $table->dropColumn('rus_date');
            $table->dropColumn('year_month');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_costs', function (Blueprint $table) {
            $table->smallInteger('hours')->default(0);
            $table->string('rus_date');
            $table->string('year_month');
        });
    }
}
