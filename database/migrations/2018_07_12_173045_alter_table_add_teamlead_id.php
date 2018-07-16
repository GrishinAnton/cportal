<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddTeamleadId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personal', function (Blueprint $table) {
            $table->unsignedInteger('teamlead_id')->nullable()->after('group_id');
            $table->foreign('teamlead_id')->references('pers_id')->on('personal');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal', function (Blueprint $table) {
            $table->dropForeign('personal_teamlead_id_foreign');
            $table->dropColumn('teamlead_id');
        });
    }
}
