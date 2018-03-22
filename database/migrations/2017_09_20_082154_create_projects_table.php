<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id')->unique();
            $table->string('class');
            $table->string('url_path');
            $table->string('name');
            $table->smallInteger('category_id');
            $table->boolean('is_trashed');
            $table->integer('trashed_on')->nullable();
            $table->integer('updated_on')->nullable();
            $table->text('body_formatted');
            $table->smallInteger('company_id');
            $table->smallInteger('currency_id');
            $table->boolean('is_completed');
            $table->integer('budget')->default(0)->nullable();
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
        Schema::dropIfExists('projects');
    }
}
