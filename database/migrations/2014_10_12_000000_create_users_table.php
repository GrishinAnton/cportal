<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Таблица ролей
        Schema::create('role', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name')->unique();
            $table->string('description');
        });
        
        //Таблица пользователей
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            $table->unsignedSmallInteger('role_id')->default(1);
            $table->foreign('role_id')->references('id')->on('role');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role');
        Schema::dropIfExists('users');
    }
}
