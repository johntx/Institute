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
      $table->integer('nota')->nullable();
      $table->integer('inscription_id')->unsigned()->nullable();
      $table->foreign('inscription_id')->references('id')->on('inscriptions')->onDelete('cascade');
      $table->integer('test_id')->unsigned()->nullable();
      $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
      $table->integer('people_id')->unsigned()->nullable();
      $table->foreign('people_id')->references('id')->on('peoples')->onDelete('set null');
      $table->integer('group_id')->unsigned()->nullable();
      $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
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
