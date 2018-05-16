<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProjectCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_costs', function (Blueprint $table) {
            $table->smallInteger('hours')->after('project_id');
            $table->tinyInteger('percent')->after('project_id');
            $table->mediumInteger('cost_override')->after('project_id');
            $table->date('date')->after('project_cost');
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
            $table->dropColumn('percent');
            $table->dropColumn('cost_override');
            $table->dropColumn('date');
            $table->dropColumn('hours');
        });
    }
}
