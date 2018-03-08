<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notices', function (Blueprint $table) {
      $table->increments('id');
      $table->date('fecha')->nullable();
      $table->string('tipo',20)->nullable();
      $table->string('titulo',100)->nullable();
      $table->text('texto')->nullable();
      $table->string('foto',255)->nullable();
      $table->integer('user_id')->unsigned()->nullable();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('notices');
  }
}
