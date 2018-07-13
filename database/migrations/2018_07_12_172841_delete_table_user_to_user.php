<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTableUserToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_to_user', function (Blueprint $table) {
            Schema::dropIfExists('user_to_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_to_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id');
            $table->foreign('owner_id')->references('pers_id')->on('personal');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('pers_id')->on('personal');
            $table->unsignedInteger('group_id')->nullable();
            $table->foreign('group_id')->references('pers_id')->on('personal');
            $table->timestamps();
        });
    }
}
