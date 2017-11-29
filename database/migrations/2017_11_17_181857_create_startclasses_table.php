<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStartclassesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('startclasses', function (Blueprint $table) {
      $table->increments('id');
      $table->string('estado',20)->nullable();
      $table->date('fecha_inicio')->nullable();
      $table->date('fecha_fin')->nullable();
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
    Schema::drop('startclasses');
  }
}
