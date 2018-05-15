<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToSalarriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->foreign('pers_id')
                ->references('pers_id')
                ->on('personal')
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
        Schema::table('salaries', function (Blueprint $table) {
            $table->dropForeign('salaries_pers_id_foreign');
        });
    }
}
