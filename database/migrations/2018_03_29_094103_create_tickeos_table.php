<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTickeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickeos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo',10);
            $table->string('estado',15)->nullable();
            $table->string('cancelado',10);
            $table->datetime('fecha')->unique();
            $table->integer('biometric_id')->unsigned();
            $table->foreign('biometric_id')->references('id')->on('biometrics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tickeos');
    }
}
