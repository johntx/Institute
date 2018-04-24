<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssistancesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('assistances', function (Blueprint $table) {
      $table->increments('id');
      $table->date('fecha')->nullable();
      $table->integer('asistencia')->nullable();
      $table->integer('inscription_id')->unsigned()->nullable();
      $table->foreign('inscription_id')->references('id')->on('inscriptions')->onDelete('cascade');
      $table->integer('people_id')->unsigned()->nullable();
      $table->foreign('people_id')->references('id')->on('peoples')->onDelete('cascade');
      $table->integer('group_id')->unsigned()->nullable();
      $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
      $table->integer('subject_id')->unsigned()->nullable();
      $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
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
    Schema::drop('assistances');
  }
}
