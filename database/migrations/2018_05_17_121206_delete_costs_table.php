<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('costs');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->increments('id');
            $table->double('cost')->default(0);
            $table->string('month');
            $table->string('year');
            $table->string('rus_date');
            $table->timestamps();
        });
    }
}
