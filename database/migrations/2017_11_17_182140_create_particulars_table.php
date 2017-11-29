<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticularsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('particulars', function (Blueprint $table) {
      $table->increments('id');
      $table->date('fecha_inicio')->nullable();
      $table->date('fecha_fin')->nullable();
      $table->integer('abono')->nullable();
      $table->integer('saldo')->nullable();
      $table->integer('costo')->nullable();
      $table->string('hora_inicio',20)->nullable();
      $table->string('hora_fin',20)->nullable();
      $table->integer('people_id')->unsigned()->nullable();
      $table->foreign('people_id')->references('id')->on('peoples')->onDelete('set null');
      $table->integer('career_id')->unsigned()->nullable();
      $table->foreign('career_id')->references('id')->on('careers')->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('particulars');
  }
}
