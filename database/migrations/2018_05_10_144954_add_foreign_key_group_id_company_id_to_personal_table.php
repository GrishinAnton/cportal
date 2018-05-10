<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyGroupIdCompanyIdToPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personal', function (Blueprint $table) {
            $table->foreign('group_id')
                ->references('id')
                ->on('personal_groups')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('company_id')
                ->references('id')
                ->on('personal_companies')
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
        Schema::table('personal', function (Blueprint $table) {
            $table->dropForeign('personal_group_id_foreign');
            $table->dropForeign('personal_company_id_foreign');
        });
    }
}
