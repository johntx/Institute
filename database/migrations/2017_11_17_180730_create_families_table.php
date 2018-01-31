<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('families', function (Blueprint $table) {
      $table->increments('id');
      $table->string('ci',20)->nullable();
      $table->string('nombre_completo',200);
      $table->string('telefono',100)->nullable();
      $table->string('parentezco',20)->nullable();
      $table->integer('people_id')->unsigned()->nullable();
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
    Schema::drop('families');
  }
}
