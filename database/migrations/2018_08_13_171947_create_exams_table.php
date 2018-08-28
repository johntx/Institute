<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pregunta');
            $table->string('respuesta1',200)->nullable();
            $table->string('respuesta2',200)->nullable();
            $table->string('respuesta3',200)->nullable();
            $table->string('respuesta4',200)->nullable();
            $table->string('respuesta5',200)->nullable();
            $table->integer('correcta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exams');
    }
}
