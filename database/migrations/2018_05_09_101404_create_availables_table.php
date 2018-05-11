<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lunes',255)->nullable();
            $table->string('martes',255)->nullable();
            $table->string('miercoles',255)->nullable();
            $table->string('jueves',255)->nullable();
            $table->string('viernes',255)->nullable();
            $table->string('sabado',255)->nullable();
            $table->integer('people_id')->unsigned();
            $table->foreign('people_id')->references('id')->on('peoples')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('availables');
    }
}
