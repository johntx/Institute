<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscriptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('inscriptions', function (Blueprint $table) {
      $table->increments('id');
      $table->string('estado',20)->nullable();
      $table->date('fecha_ingreso')->nullable();
      $table->date('fecha_retiro')->nullable();
      $table->integer('monto')->nullable();
      $table->integer('abono')->nullable();
      $table->integer('total')->nullable();
      $table->string('colegiatura',20)->nullable();
      $table->integer('people_id')->unsigned()->nullable();
      $table->foreign('people_id')->references('id')->on('peoples')->onDelete('cascade');
      $table->integer('group_id')->unsigned()->nullable();
      $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
      $table->integer('particular_id')->unsigned()->nullable();
      $table->foreign('particular_id')->references('id')->on('particulars')->onDelete('set null');
      $table->integer('user_id')->unsigned()->nullable();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
    Schema::drop('inscriptions');
  }
}
