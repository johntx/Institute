<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('scores', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('inscription_id')->unsigned()->nullable();
      $table->foreign('inscription_id')->references('id')->on('inscriptions')->onDelete('set null');
      $table->integer('people_id')->unsigned()->nullable();
      $table->foreign('people_id')->references('id')->on('peoples')->onDelete('set null');
      $table->integer('group_id')->unsigned()->nullable();
      $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
      $table->integer('subject_id')->unsigned()->nullable();
      $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
      $table->integer('partial_id')->unsigned()->nullable();
      $table->foreign('partial_id')->references('id')->on('partials')->onDelete('set null');
      $table->string('nota',10)->nullable();
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
    Schema::drop('scores');
  }
}
