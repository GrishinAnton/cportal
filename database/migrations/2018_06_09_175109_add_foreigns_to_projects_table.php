<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('personal_companies')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('status_id')
                ->references('id')
                ->on('project_statuses')
                ->onDelete('set null')
                ->onUpdate('cascade');
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
            $table->dropForeign('projects_company_id_foreign');
            $table->dropForeign('projects_status_id_foreign');
        });
    }
}
