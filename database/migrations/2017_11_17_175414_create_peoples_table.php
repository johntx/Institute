<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeoplesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('peoples', function (Blueprint $table) {
      $table->increments('id');
      $table->string('code',20)->nullable()->unique();
      $table->string('ci',20)->nullable();
      $table->string('nombre',50);
      $table->string('paterno',100);
      $table->string('materno',50)->nullable();
      $table->date('fecha_ingreso')->nullable();
      $table->date('fecha_nacimiento')->nullable();
      $table->string('nacionalidad',20)->nullable();
      $table->string('estado_civil',15)->nullable();
      $table->string('direccion',255)->nullable();
      $table->string('telefono',100)->nullable();
      $table->string('genero',10)->nullable();
      $table->string('tipo_sanguineo',10)->nullable();
      $table->string('email',100)->nullable();
      $table->integer('office_id')->unsigned()->nullable();
      $table->foreign('office_id')->references('id')->on('offices')->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('peoples');
  }
}
