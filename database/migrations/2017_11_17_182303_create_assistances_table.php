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
      $table->integer('inscription_id')->unsigned()->nullable();
      $table->foreign('inscription_id')->references('id')->on('inscriptions')->onDelete('set null');
      $table->integer('people_id')->unsigned()->nullable();
      $table->foreign('people_id')->references('id')->on('peoples')->onDelete('set null');
      $table->integer('subject_id')->unsigned()->nullable();
      $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
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
