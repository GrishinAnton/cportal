<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->timestamp('start_at')->nullable()->after('budget');
            $table->timestamp('finish_at')->nullable()->after('budget');
            $table->integer('hours_laid')->nullable()->after('budget');
            $table->integer('cost_per_hour')->nullable()->after('budget');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('start_at');
            $table->dropColumn('finish_at');
            $table->dropColumn('hours_laid');
            $table->dropColumn('cost_per_hour');
        });
    }
}
