<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunctionalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('functionalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',10)->unique();
            $table->string('label',20);
            $table->string('path',50)->unique();
            $table->integer('menu_id')->unsigned()->nullable();
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('functionalities');
    }
}
